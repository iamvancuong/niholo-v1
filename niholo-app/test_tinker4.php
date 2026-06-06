<?php
dump(App\Models\Card::where('front_text', '今日')->with('kanjis')->get()->toArray());
