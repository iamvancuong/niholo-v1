<?php
$card = App\Models\Card::where('type', 'vocabulary')->where('front_text', '今日')->first();
if ($card) {
    dump($card->kanjis->pluck('character')->toArray());
} else {
    dump("Not found");
}
