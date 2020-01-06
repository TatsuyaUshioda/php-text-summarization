<?php

/*
 * Copyright 2019 TatsuyaUshioda
 * This software is released under Apache License Version 2.0, see LICENSE.
 */

require_once "lib/wakati.php";

if (count($argv) < 2) {
    print_r("php ml_data_wakati.php [inputfile filename] [output filename]
\n");
    exit;
}

$inputfile_name = $argv[1];
$outputfile_name = $argv[2];

$in_file = fopen($inputfile_name, "r");
$out_file = fopen($outputfile_name, 'w');

while (!feof($in_file)) {
    $raw_text = fgets($in_file);
    $wakati_text = wakati_base_sentence($raw_text);
    fwrite($out_file, $wakati_text . "\n");
}

fclose($in_file);
fclose($out_file);
