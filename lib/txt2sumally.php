<?php

/**
 * 要約処理
 * @param $main_text
 * 要約対象文
 * @param $out_line_num
 * 出力する文の数
 * @return array
 */
function txt2sumally($main_text, $out_line_num)
{
    $config = include 'config/model.php';

    //モデルのファイルを指定
    $model_file = $config['model_path'];
    $model_array = model_load($model_file);

    //改行の文をそれぞれ配列に保持
    $main_text = preg_replace('/\n(\s|\n)*\n/u', "\n", $main_text);
    $main_text = preg_replace('/(\s)*\n/u', "\n", $main_text);
    $main_text_array = preg_split("/(\n|\r\n|。)/", $main_text);
    $main_text_array = array_filter($main_text_array, 'strlen');
    $main_text_array = array_merge($main_text_array);

    //入力文数
    $in_line_num = count($main_text_array);

    //入力文を分かち書き
    for ($i = 0; $i < $in_line_num; $i++) {
        $wakati￿_array[$i] = Mecab\split($main_text_array[$i]); //php7
    }

    //重要度計算
    for ($i = 0; $i < $in_line_num; $i++) {
        $text_rank = (float)0; //
        foreach ($wakati￿_array[$i] as $words) {
            if (array_key_exists($words, $model_array)) {
                $text_rank = $text_rank + $model_array[$words];
            } else {
                $text_rank = $text_rank + (float)1;
            }
        }
        $text_rank_array[$i] = $text_rank;
    }

    //作った配列を結合
    $text_summarize_array = array_map(null, $main_text_array, $text_rank_array);
    unset($main_text_array);
    unset($wakati￿_array);
    unset($text_rank_array);

    //重要な文を指定の出力文数取得する
    $sort = array_column($text_summarize_array, 1);
    array_multisort($sort, SORT_DESC, SORT_NUMERIC, $text_summarize_array);
    $summarize_texts = array_column(array_slice($text_summarize_array, 0, $out_line_num), 0);

    return $summarize_texts;
}

/**
 * 生成したモデルを読み込む
 * @param $file
 * @return array|false
 */
function model_load($file)
{
    try {
        //モデル読み込み
        $model_f = new SplFileObject($file);
        $model_f->setFlags(SplFileObject::READ_CSV);
    } catch (RuntimeException $e) {
        throw $e;
    }

    $model_array = [];
    if ($model_f) {
        foreach ($model_f as $line) {
            //空行はスキップ
            if (empty($line[0])) {
                continue;
            }
            $model_key[] = (string)$line[0];
            $model_value[] = (float)$line[1];
        }
        $model_array = array_combine($model_key, $model_value);
    }
    return $model_array;
}

//標準入力用
//php lib/txt2sumally.php [input_file] [sumally_num]
if (count($argv) > 2) {
    $text = file_get_contents($argv[1]);
    print_r(txt2sumally($text, $argv[2]));
}