<?php

/*
 * Copyright 2019 TatsuyaUshioda
 * This software is released under Apache License Version 2.0, see LICENSE.
 */

/**
 * テキスト(1文)を形態素解析して原形の配列を返却する
 * @param $text
 * @return array
 */
function wakati_base_array($text)
{
    //正規化
    $text = mb_convert_kana($text, "KVa");

    $mecab = new \MeCab\Tagger();
    $nodes = $mecab->parseToNode($text);

    $wakati_array = [];
    foreach ($nodes as $n) {
        //load surface and base
        $surface = $n->getSurface();
        $info = $n->toArray();
        $data = explode(',', $info['feature']);

        if ($data[6] != "*") {
            $wakati_array[] = $data[6];
        }elseif($surface){
            $wakati_array[] = $surface;
        }
    }
    return $wakati_array;
}

/**
 * テキスト(1文)を形態素解析して原形の1文を返却する
 * @param $text
 * @return string
 */
function wakati_base_sentence($text)
{
    return implode(wakati_base_array($text), ' ');
}

