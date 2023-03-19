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

## SQLインジェクション

## SQLインジェクション（ブラインド）
