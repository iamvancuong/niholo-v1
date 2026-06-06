<?php
$lesson = App\Models\Lesson::find(8);
$lesson->load("cards.kanjis");
dump($lesson->cards->where("type", "kanji")->first()->toArray());
