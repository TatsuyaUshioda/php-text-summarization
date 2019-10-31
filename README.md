# PHPで使える文章要約

## 何ができるの？
PHPで入力した文章の要約ができます。要約は抽出的要約と呼ばれるものです。<br>
抽出的要約とは、対象となる文章に含まれる文を組み合わせることで要約文を作るものです。

## スタートガイド
### 必要条件
1. PHP/Java/Pythonが動く環境<br>
2. 学習用日本語テキストデータ

### インストール(使用するツール群)
1. php-sentence-summarizationを自分の環境に配置<br>
2. [Igo-php](https://github.com/siahr/igo-php)のインストール<br>
取得したlib/以下を適当な場所に配置する。
### 使用する辞書作成の準備
1. Igo-phpの辞書生成は本家Igoを使う。<br>
詳細説明は[こちら](http://igo.osdn.jp/index.html#usage)
2. MeCabプロジェクトが配布している(もしくはそれと互換性のある)辞書を入手する<br>
・https://sourceforge.net/projects/mecab/files/mecab-ipadic/2.7.0-20070801/<br>
・https://github.com/neologd/mecab-ipadic-neologd<br>
 ※mecab-ipadic-neologdの場合はmecab-ipadic-neologdディレクトリで下記手順を実施してください<br>
```
$ bin/install-mecab-ipadic-neologd
```
上記コマンドでbuild/配下に「mecab-ipadic-2.7.0-20070801-neologd-?????」というディレクトリができるので下記で使用してください。<br>
### 使用する辞書作成
1. [Igo本体Jar版](https://ja.osdn.net/projects/igo/releases/)を入手
2. 上記で作成したテキスト辞書とIgoJar版を用いて辞書を作る<br>
```
$ java -cp igo-0.4.5.jar net.reduls.igo.bin.BuildDic ipadic mecab-ipadic-2.7.0-20070801 [文字コード]
```
文字コードはmecab-ipadicはEUC-JP、mecab-ipadic-neologdはUTF-8です。
この場合はipadic/以下が辞書本体になります。

下記コマンドで動作確認できます。
```
$ php Igo.php ipadic "昨日は海に行ってきました"
昨日	名詞,副詞可能,*,*,*,*,昨日,キノウ,キノー,0
は	助詞,係助詞,*,*,*,*,は,ハ,ワ,2
海	名詞,一般,*,*,*,*,海,ウミ,ウミ,3
に	助詞,格助詞,一般,*,*,*,に,ニ,ニ,4
行っ	動詞,自立,*,*,五段・カ行促音便,連用タ接続,行く,イッ,イッ,5
て	助詞,接続助詞,*,*,*,*,て,テ,テ,7
き	動詞,非自立,*,*,カ変・クル,連用形,くる,キ,キ,8
まし	助動詞,*,*,*,特殊・マス,連用形,ます,マシ,マシ,9
た	助動詞,*,*,*,特殊・タ,基本形,た,タ,タ,11
```

## 著者
・[TatsuyaUshioda](https://github.com/TatsuyaUshioda)

## License
Apache License 2.0
