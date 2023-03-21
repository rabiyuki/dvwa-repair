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

対象ファイル：`html\vulnerabilities\xss_d\index.php`

### 格納型と反射型
- 

## SQLインジェクション

## SQLインジェクション（ブラインド）
