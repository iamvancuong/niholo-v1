<?php
use App\Models\Card;
use App\Models\Kanji;

$kanjis = Kanji::all();
$vocabCards = Card::where('type', 'vocabulary')->get();

$count = 0;
foreach ($vocabCards as $card) {
    $attachedKanjiIds = [];
    // We want to preserve the order of characters as they appear in the word!
    // But mb_strpos is fine for just finding them. To order them by appearance:
    $kanjiPositions = [];
    foreach ($kanjis as $kanji) {
        $pos = mb_strpos($card->front_text, $kanji->character);
        if ($pos !== false) {
            $kanjiPositions[$kanji->id] = $pos;
        }
    }
    
    if (!empty($kanjiPositions)) {
        asort($kanjiPositions);
        $attachedKanjiIds = array_keys($kanjiPositions);
        $card->kanjis()->syncWithoutDetaching($attachedKanjiIds);
        $count++;
    }
}
echo "Synced kanjis for $count vocabulary cards.\n";
