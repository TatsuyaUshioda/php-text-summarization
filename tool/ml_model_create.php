<?php
require_once 'vendor/autoload.php';

use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TfIdfTransformer;

if (count($argv) < 2) {
    print_r("php ml_data_create.php [inputfile filename] [output filename]
\n");
    exit;
}

//入力ファイル
$inputfile_name = $argv[1];
//出力ファイル
$outputfile_name = $argv[2];

$texts = file($inputfile_name);

if (count($texts) <= 0) {
    print_r("input text data not found.\n");
    exit;
}

print_r("info : Vectorize1\n");

$vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
$vectorizer->fit($texts);
print_r("info : Vectorize2\n");
$vectorizer->transform($texts);

print_r("info : words output\n");

//単語一覧
$words = $vectorizer->getVocabulary();
$words_count = count($words); //単語数取得

print_r("info : TFIDF1\n");

$transformer = new TfIdfTransformer($texts);
$transformer->fit($texts);
print_r("info : TFIDF2\n");
$transformer->transform($texts);

if (count($texts[0]) != $words_count) {
    print_r("array not found.\n");
    exit;
}

//単語のTFIDF配列初期化
$words_tfidf = [];
for ($i = 0; $i < $words_count; $i++) {
    $words_tfidf[] = (float)0;
}

//同一単語の中でTFIDF最大値を保持する
foreach ($texts as $sentence) {
    foreach ($sentence as $key => $value) {
        if ($value > $words_tfidf[$key]) {
            $words_tfidf[$key] = $value;
        }
    }
}

$fpout = fopen($outputfile_name, "w");

//単語とTFIDF値の統合
for ($i = 0; $i < $words_count; $i++) {
    fwrite($fpout, $words[$i] . "," . $words_tfidf[$i] . "\n");

}
fclose($fpout);
print_r("info : process is finished.\n");
