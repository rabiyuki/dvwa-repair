# DVWAの脆弱性を対策
## はじめに
Damn Vulnerable Web Application (DVWA)はRandomStormにより開発された脆弱なPHP/MySQL製のWebアプリケーションです。

本アプリケーションの主な使用目的として、セキュリティ専門家が自分のスキルやツールを合法的な環境でテストしたり、開発者がWebアプリケーションの安全性を確保するプロセスを理解するために使用されます。

- dockerhub

https://hub.docker.com/r/vulnerables/web-dvwa

- GitHub

https://github.com/RandomStorm/DVWA

## DVWAの起動について
### 修正を実施していない状態のDVWAの起動
1. dockerhubからイメージをダウンロードします。
2. `docker run --rm -it -p 80:80 vulnerables/web-dvwa`のコマンドを実行します。
3. ブラウザで`localhost`へアクセスします。
4. ログイン画面が表示されます（ログイン情報やログイン後のデータベースセットアップについては、dockerhubを参照してください）。

### 修正済みのDVWAの起動
1. docker-compose.ymlがあるディレクトリで`docker compose up`を実行します。
2. ブラウザで`localhost:8080`へアクセスします。
3. ログイン画面が表示されます（ログイン情報は初期設定となっており、データベースセットアップは不要です）。

## クロスサイトスクリプティング
### DOM-based型
基本的な対策方法（IPA参照）
1. DOM操作用のメソッドやプロパティの使用する。
  - `createTextNode()`などのメソッドを使用すれば、意図しないDOMツリーの変更が起こりにくい
  - 結果的にDOM-based型のXSSの脆弱性を作り出しにくくなる
2. 文脈に応じてエスケープ処理を施す。
  - `innerHTML`や`document.write()`は意図しないDOMツリーの変更の恐れがあるため、これらを使用するときには出力箇所に応じて、エスケープ処理を行う
3. JavaScriptライブラリの問題の場合は、ライブラリをアップデートする。

今回は「文脈に応じてエスケープ処理を施す」を実施

修正対象ファイル：`html\vulnerabilities\xss_d\index.php`

### 格納型と反射型
基本的な対策方法（IPA参照）
1. ウェブページに出力する全ての要素に対して、エスケープ処理を施す。
2. 入力されたHTMLテキストから、スクリプトに該当する文字列を排除する。
  - `<script>`や`javascript:`を無害な文字列へ置換する場合、`<xscript>`や`xjavascript:`のように、その文字列に適当な文字を付加する。
4. HTTPレスポンスヘッダのContent-Typeフィールドに文字コード（charset）を指定する。
  - Content-Typeフィールドで文字コードの指定を省略した場合、ブラウザは文字コードを独自の方法で推定して、推定した文字コードにしたがって画面表示を処理する。
5. クロスサイト・スクリプティングの潜在的な脆弱性対策として有効なブラウザの機能を有効にするレスポンスヘッダを返す。
  - X-XSS-Protection
  - Content Security Policy

今回は「エスケープ処理を施す」を実施

修正対象ファイル（格納型）：`html\dvwa\includes\dvwaPage.inc.php`

※データベースに格納する前にXSS対策としてエスケープ処理を行うと、予期せぬHTML構造になり、画面表示が崩壊する恐れがある。<br>
そのため、入力値を表示をする段階でエスケープ処理を行うことが望ましい。

修正対象ファイル（反射型）：`html\vulnerabilities\xss_r\source\medium.php`

## SQLインジェクション
基本的な対策方法（IPA参照）
1. SQL文の組み立ては全てプレースホルダで実装する。
2. SQL文の組み立てを文字列連結により行う場合は、エスケープ処理等を行うデータベースエンジンのAPIを用いて、SQL文のリテラルを正しく構成する。
3. エラーメッセージをそのままブラウザに表示しない。
4. データベースアカウントに適切な権限を与える。

今回は「SQL文の組み立ては全てプレースホルダで実装する」を実施

修正対象ファイル：`html\vulnerabilities\sqli\source\medium.php`
