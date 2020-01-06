# 1.PHPで使える文章要約

## 2.何ができるの？
PHPで入力した文章の要約ができます。要約は抽出的要約と呼ばれるものです。<br>
抽出的要約とは、対象となる文章に含まれる文を組み合わせることで要約文を作るものです。

## 3.スタートガイド
### 3.1 必要条件
1. PHPとApacheが動く環境<br>
2. MeCab向けにC++ コンパイラ(g++など)とiconv(libiconv)
3. UTF-8のモデル生成用の日本語テキストデータ(以降「モデル生成用テキスト」)

### 3.2 インストール(使用するツール群)
1. php-sentence-summarizationを自分の環境に配置<br>
2. MeCabと辞書のインストール(後述)<br>
3. [php-mecab](https://github.com/rsky/php-mecab)のインストール(後述)<br>
4. [php-ML](https://php-ml.readthedocs.io/en/latest/)のインストール(後述)<br>

#### 3.2.1 MeCabと辞書のインストール
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
#### 3.2.2 php-mecabのインストール

```
# cd /usr/local/src/
# git clone https://github.com/rsky/php-mecab.git
# cd /usr/local/src/php-mecab/mecab
# phpize
# ./configure
# make
# make install

# vi /etc/php.ini
(環境により異なる)
下記コードを記載
extension=mecab.so
mecab.default_dicdir=[辞書パス]
```

#### 3.2.3 php-MLのインストール
下記コマンドを実行

```
$ composer install
```

### 3.3 モデル生成用テキストを用いたモデル生成
大きく分けて事前処理と本処理に分かれます。
#### 3.3.1 事前処理
「モデル生成用テキスト」に対してMeCabを用いて分かち書き(原形集約)をします。<br>
コマンドラインでの実行は下記になります。<br>
```$ php tool/ml_model_wakati.php [モデル生成用テキスト] [出力ファイルパス]```

入力ファイル例
```
テストですが何か
```

出力ファイル例
```
テスト です が 何 か
```
#### 3.3.2 本処理(モデル生成)
分かち書き済みのモデル生成用テキストを下記コマンドの入力ファイルとします。

```
$ php tool/ml_model_create.php [入力ファイルパス] [出力ファイルパス]
```
※メモリエラーになる場合はphp.iniのmemory_limitを増やしてください。

### 3.4 モデルを用いた文章要約
config/example.model.phpをコピーしてmodel.phpを作成<br>
生成したモデルをmodel_pathで指定する

#### 3.4.1 ブラウザを用いた方法
/index.phpにアクセスしてください。<br>
「要約対象」に要約対象の文章、「要約割合(%)」に対象文章に対する要約割合を入力して「submit」をクリックすると結果が下部に表示されます。

#### 3.4.2 コマンドラインから実行
下記コマンドを実行してください。

```
$ php lib/txt2sumally.php [要約対象のテキストファイル] [要約割合(%)]
```
## 著者
・[TatsuyaUshioda](https://github.com/TatsuyaUshioda)

## License
Apache License, Version 2.0
詳しいことはLICENSEに書いてます。
