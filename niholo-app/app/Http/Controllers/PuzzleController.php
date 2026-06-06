<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Card;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PuzzleController extends Controller
{
    public function show(Lesson $lesson, Card $card)
    {
        // Kiểm tra xem thẻ này có mảnh ghép không
        if (!$card->example_blocks_json || empty($card->example_blocks_json)) {
            abort(404, 'Thẻ này không có bài tập ghép câu.');
        }

        $blocksJson = $card->example_blocks_json;
        $isNewFormat = isset($blocksJson['blocks']);

        // Tạo mảng blocks xáo trộn
        if ($isNewFormat) {
            $blocks = collect($blocksJson['blocks'])->map(function ($block) {
                return [
                    'id' => $block['id'],
                    'text' => $block['text']
                ];
            })->shuffle()->values();
        } else {
            $blocks = collect($blocksJson)->map(function ($text, $index) {
                return [
                    'id' => $index + 1,
                    'text' => $text
                ];
            })->shuffle()->values();
        }

        // Tìm thẻ tiếp theo có puzzle trong bài học này
        $nextCard = Card::where('lesson_id', $lesson->id)
            ->whereNotNull('example_blocks_json')
            ->where('id', '>', $card->id)
            ->orderBy('id')
            ->first();

        return Inertia::render('Grammar/DragDropPuzzle', [
            'lesson' => $lesson,
            'card' => $card,
            'next_card_id' => $nextCard ? $nextCard->id : null,
            'puzzle' => [
                'id' => $card->id,
                'translation' => $card->example_vietnamese ?? $card->front_text ?? 'Hãy dịch câu này',
                'audio_url' => $card->example_audio_url,
                'blocks' => $blocks
            ]
        ]);
    }

    public function submit(Request $request, Lesson $lesson, Card $card)
    {
        $request->validate([
            'answer_order' => 'required|array'
        ]);

        $blocksJson = $card->example_blocks_json;
        $isNewFormat = isset($blocksJson['blocks']);

        if ($isNewFormat) {
            $correctOrder = $blocksJson['correct_order'];
        } else {
            $correctOrder = range(1, count($blocksJson));
        }

        $isCorrect = $request->answer_order == $correctOrder;

        return response()->json([
            'correct' => $isCorrect,
            'correct_sentence' => $card->example_japanese
        ]);
    }
}
