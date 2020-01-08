<?php

require_once "lib/txt2sumally.php";

//標準入力用
//php cli/txt2sumally.php [input_file] [sumally_output_num_percent]
if (count($argv) > 2) {
    $text = file_get_contents($argv[1]);
    print_r(txt2sumally($text, $argv[2]));
}
