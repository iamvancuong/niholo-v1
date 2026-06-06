<?php
$card = App\Models\Card::where("front_text", "三")->first();
dump($card->kanjis->toArray());
