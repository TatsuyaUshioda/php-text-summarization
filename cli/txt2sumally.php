<?php

require_once "lib/txt2sumally.php";

//標準入力用
//php cli/txt2sumally.php [input_file] per [sumally_output_num_percent]
//php cli/txt2sumally.php [input_file] sen [sumally_output_num_sentence]
if (count($argv) > 3) {
    $text = file_get_contents($argv[1]);
    print_r(txt2sumally($text, $argv[2],$argv[3]));
}
