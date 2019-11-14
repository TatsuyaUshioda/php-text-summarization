# 1.PHPで使える文章要約

## 2.何ができるの？
PHPで入力した文章の要約ができます。要約は抽出的要約と呼ばれるものです。<br>
抽出的要約とは、対象となる文章に含まれる文を組み合わせることで要約文を作るものです。

## 3.スタートガイド
### 3.1 必要条件
1. PHPが動く環境<br>
2. MeCab向けにC++ コンパイラ(g++など)とiconv(libiconv)
3. UTF-8の学習モデル生成用の日本語テキストデータ(以降「モデル生成用テキスト」)

### 3.2 インストール(使用するツール群)
1. php-sentence-summarizationを自分の環境に配置<br>
2. MeCabと辞書のインストール(後述)<br>
3. [php-mecab](https://github.com/rsky/php-mecab)のインストール<br>
4. [php-ML](https://php-ml.readthedocs.io/en/latest/)のインストール(下記コマンドを実行)<br>
```
$ composer install
```
### 3.2 MeCabと辞書のインストール
MeCabと使用する辞書をインストールします。

1. MeCabのインストール
[こちら](https://taku910.github.io/mecab/)に沿ってインストールする<br>
※MacでHomebrewが使える場合は下記を実行してください。
    ```
    $ brew install mecab
    ```
2. 辞書のインストール<br>
MeCabで使用可能な辞書を入手する。<br>
使用するのは1つですが、名前が知られている辞書を記載します。

    2.1 [IPA 辞書](https://sourceforge.net/projects/mecab/files/mecab-ipadic/2.7.0-20070801/)<br>
    mecab-ipadicのインストール方法は[こちら](https://taku910.github.io/mecab/#install)<br>
    ※MacでHomebrewが使える場合は下記を実行してください。
    ```
    $ brew install mecab-ipadic
    ```

    2.2 [mecab-ipadic-NEologd](https://github.com/neologd/mecab-ipadic-neologd)

3. 実行

下記コマンドで実行できれば正常にインストールが完了しています。
※mecab-ipadic-NEologdの場合は辞書のパスを指定してください
```
$ echo "今日は何の日" | mecab [-d 辞書のパス]
今日	名詞,副詞可能,*,*,*,*,今日,キョウ,キョー
は	助詞,係助詞,*,*,*,*,は,ハ,ワ
何	名詞,代名詞,一般,*,*,*,何,ナニ,ナニ
の	助詞,連体化,*,*,*,*,の,ノ,ノ
日	名詞,非自立,副詞可能,*,*,*,日,ヒ,ヒ
EOS
```

### 3.3 モデル生成用テキストを用いた学習モデル生成
大きく分けて事前処理と本処理に分かれます。
#### 3.3.1 事前処理
「モデル生成用テキスト」に対してMeCabを用いて分かち書きをします。<br>
分かち書きが済んでいる場合は次に進んでください<br>
コマンドラインで実行の場合は下記になります。<br>
```$ mecab [入力ファイル] -d [辞書ファイルパス] -O wakati -o [出力ファイル名]```

入力ファイル例
```
テストですが何か
```

出力ファイル例
```
テスト です が 何 か
```
#### 3.3.2 本処理(学習モデル生成)
Coming Soon

## 著者
・[TatsuyaUshioda](https://github.com/TatsuyaUshioda)

## License
Apache License 2.0
