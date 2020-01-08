<?php

/*
 * Copyright 2019 TatsuyaUshioda
 * This software is released under Apache License Version 2.0, see LICENSE.
 */

require_once "lib/wakati.php";

/**
 * 要約処理
 * @param $main_text
 * 要約対象文
 * @param $output_num_percent
 * 出力する文の割合(パーセント表記)
 * @return array
 */
function txt2sumally($main_text, $output_num_percent)
{
    $config = include 'config/model.php';

    //モデルのファイルを指定
    $model_file = $config['model_path'];
    $model_array = model_load($model_file);

    //改行の文をそれぞれ配列に保持
    $main_text = preg_replace(['/\n(\s|\n)*\n/u', '/(\s)*\n/u'], ["\n", "\n"], $main_text);
    $main_text_array = preg_split("/(\n|\r\n)/", $main_text);
    $main_text_array = array_filter($main_text_array, 'strlen');
    $main_text_array = array_merge($main_text_array);

    return summarize($main_text_array, $model_array, $output_num_percent);
}

/**
 * 要約処理
 * @param $main_text_array
 * 本文
 * @param $model_array
 * モデル
 * @param $outline_num_percent
 * 出力する文の割合(パーセント表記)
 * @return array
 */
function summarize($main_text_array, $model_array, $output_num_percent)
{
    foreach ($main_text_array as $i => $text) {
        $text_rank_array[$i] = array_reduce(wakati_base_array($text), function ($rank, $words) use ($model_array) {

            //数値を含む場合に優先
            if (preg_match("/[0-9,，.．]+/u", $words)) {
                return $rank = $rank + (float)1;
            } elseif (array_key_exists($words, $model_array)) {
                return $rank = $rank + $model_array[$words];
            } else {
                return $rank = $rank + (float)1;
            }
        }, (float)0);
    }

    //入力したパーセンテージを元に出力文の数を決定(0の場合は1とする)
    $out_line_num = (int)(count($main_text_array) * ($output_num_percent / 100));
    $out_line_num = $out_line_num ? $out_line_num : 1;

    //重要な文を指定の出力文数取得する

    array_multisort($text_rank_array, SORT_DESC, SORT_NUMERIC, $main_text_array);
    return array_slice($main_text_array, 0, $out_line_num);
}

/**
 * 生成したモデルを読み込む
 * @param $file
 * @return array|false
 */
function model_load($file)
{
    //モデル読み込み
    $model_f = new SplFileObject($file);
    $model_f->setFlags(SplFileObject::READ_CSV);

    $model_array = [];
    if ($model_f) {
        foreach ($model_f as $line) {
            //空行はスキップ
            if (empty($line[0])) {
                continue;
            }
            $model_array[(string)$line[0]] = (float)$line[1];
        }
    }
    return $model_array;
}

/**
 * エスケープ処理
 * @param $string
 * @return string
 */
function hsc($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
