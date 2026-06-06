<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Card;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateCardImagesCommand extends Command
{
    protected $signature = 'app:generate-images';
    protected $description = 'Generate local flashcard images using OpenAI DALL-E 3 based on [PROMPT] inside image_url';

    public function handle()
    {
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            $this->error('OPENAI_API_KEY is not set in .env');
            return 1;
        }

        $cards = Card::whereNotNull('image_url')
            ->where(function($query) {
                $query->where('image_url', 'like', '[PROMPT]%')
                      ->orWhere('image_url', 'like', 'https://image.pollinations.ai%');
            })
            ->get();

        if ($cards->isEmpty()) {
            $this->info('No cards to process.');
            return 0;
        }

        $this->info("Found {$cards->count()} cards to process with DALL-E 3...");
        $bar = $this->output->createProgressBar($cards->count());
        $bar->start();

        foreach ($cards as $card) {
            $prompt = null;
            if (Str::startsWith($card->image_url, '[PROMPT]')) {
                $prompt = Str::replaceFirst('[PROMPT]', '', $card->image_url);
            } elseif (Str::startsWith($card->image_url, 'https://image.pollinations.ai')) {
                $path = parse_url($card->image_url, PHP_URL_PATH);
                $prompt = urldecode(Str::replaceFirst('/prompt/', '', $path));
            }

            if (!$prompt) {
                $bar->advance();
                continue;
            }

            try {
                $response = Http::withToken($apiKey)
                    ->timeout(60)
                    ->post('https://api.openai.com/v1/images/generations', [
                        'model' => 'dall-e-2',
                        'prompt' => $prompt,
                        'n' => 1,
                        'size' => '512x512'
                    ]);

                if ($response->successful()) {
                    $openAiUrl = $response->json('data.0.url');
                    
                    // Download the image from OpenAI
                    $imageContent = Http::timeout(60)->get($openAiUrl)->body();
                    
                    $filename = 'card_' . $card->id . '_' . Str::random(5) . '.png';
                    $path = 'cards/' . $filename;
                    
                    Storage::disk('public')->put($path, $imageContent);
                    
                    $card->update([
                        'image_url' => '/storage/' . $path
                    ]);
                } else {
                    $this->error("\nFailed for card {$card->id}: " . $response->body());
                }
            } catch (\Exception $e) {
                $this->error("\nException for card {$card->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("All images generated and saved successfully.");
        return 0;
    }
}
