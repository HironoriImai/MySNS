## 開発環境の構築手順

### 開発環境

- macOS 10.14
- php 7.1（macOSに標準搭載）
- composer 1.8.5
- Laravel 5.8
- Apache 2.4（macOSに標準搭載）
- MariaDB 10.2

### composerのインストール

    brew install composer

### Laravelプロジェクトの作成

composerコマンドを使って `MySNS` という名前のプロジェクトを作成．

Laravelコマンドを使う方法もあるらしいが今回は省略．
    
    composer create-project --prefer-dist laravel/laravel MySNS

以降，作成された `MySNS` ディレクトリ内での作業となる．

キャッシュディレクトリ等のアクセス権の変更

    chmod -R 777 bootstrap/cache
    chmod -R 777 storage

環境変数（DB接続関連）を設定

    cp .env.example .env
    vi .env

書き換える箇所は以下の通り

    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=MySNS   # ここ
    DB_USERNAME=xxxx    # ここ
    DB_PASSWORD=xxxx    # ここ

gitからcloneしている場合は以下のコマンドを発行する必要がある

    composer install
    php artisan key:generate

### Node.js設定

Mixを使いたいので設定を行う

    npm install

### DB設定

インストールはbrewでインストールできる．

    brew install mariadb    # インストール
    mysql.server start      # 起動

brewのMariaDBなら文字コードもutf8mb4になっているので初期設定でもある程度動く．

今回の課題とは直接関係ないので詳細は省くが，以下自分なりのチューニング．

    [client]
    # 文字コード
    default-character-set=utf8mb4
    
    [mysqld]
    # 文字コード
    character-set-server  = utf8mb4
    collation-server      = utf8mb4_general_ci
    # スロークエリの対処
    slow_query_log      = ON
    slow_query_log_file = /var/log/mysql/mariadb-slow.log
    long_query_time     = 3
    # パケットサイズ上限
    max_allowed_packet  = 16M
    # スレッドのキャッシュ数
    thread_stack        = 192K
    thread_cache_size   = 32
    # クエリのキャッシュサイズ
    query_cache_size    = 256M
    query_cache_limit   = 10M
    query_cache_type    = 1
    # InnoDB
    # Barracuda，dynamic使う（8KB問題）
    innodb_file_per_table     = 1
    innodb_file_format        = Barracuda
    innodb_file_format_max    = Barracuda
    innodb_default_row_format = dynamic
    # バッファ
    innodb_buffer_pool_size   = 4G
    # ログ
    innodb_log_file_size      = 256M
    # MyISAM
    key_buffer_size         = 128M
    myisam_recover_options  = BACKUP

MySQL（MariaDB）に当該データベースを作成する．

    mysql -uroot -p
    MariaDB> create database MySNS;
    MariaDB> grant all privileges on MySNS.* to xxxxx@localhost identified by 'xxxxx';

### Git設定

Gitの設定もしておく．

予めGitHubには空のプロジェクトが作成されており，
sshは `GitHub` の名前で接続できるように設定してあるものとする

    git remote add origin ssh://GitHub/HironoriImai/MySNS.git
    git config user.name xxxxxxxx
    git config user.email xxxx@xxxx


## webサーバーを立ち上げる手順

WebサーバにはmacOS標準搭載のApacheを使う．

OS起動時には起動しているが，もし起動していない場合は以下コマンドで起動．

    sudo apachectl start

Laravelの `php artisan serve` コマンドでもプロジェクトのWebサーバがたてられるが，
気持ち的にHTTPのサイトでパスワード入力したくなかったのでApacheでHTTPS環境作る．

まずはWebRootにプロジェクト内のpublicディレクトリへのシンボリックリンクを貼る

    sudo ln -s /path/to/MySNS/public /var/www/MySNS

`/etc/apache2/other/MySNS.conf` に以下を追記する．

    Listen 4433
    <VirtualHost *:4433>
        DocumentRoot "/var/www/MySNS"
        SSLEngine on
        # ドキュメントルート以下
        <Directory "/var/www/MySNS">
            SSLRequireSSL
            Options FollowSymLinks
            Require all granted
            AllowOverride All
        </Directory>
    </VirtualHost>

以下のURLでトップページが出てくればOK  
https://localhost:4433/

- Laravelは `.htaccess` を使うので `AllowOverride All` を忘れずに
- 443は別で使っていたので4433ポートを使った
- 鍵，証明書，暗号スイートなどSSL関連は別ファイルにまとめてある


## テストを実行する手順

Laravelに同梱されているPHPUnitを使ってテストを行う

    ./vendor/bin/phpunit

実行後に `OK` と出てくればテストが通ったという意味


## 参考文献

Laravelプロジェクトの作成方法  
https://qiita.com/da-sugi/items/7ee7a458aad4209bab01

Laravelのディレクトリ構造について  
https://qiita.com/shosho/items/93cbff79376c41c3a30b

LaravelでSNSを作成  
https://qiita.com/n_oshiumi/items/cef0906ba7bab016f041
https://qiita.com/n_oshiumi/items/8993ab268209d19f052e

Laravelでの認証機能の実装  
https://www.ritolab.com/entry/51

ホーム以外が404になる原因（mod_rewriteが無効だっただけ...）  
http://murayama.hatenablog.com/entry/2015/09/10/081522

Bladeについて  
https://www.msng.info/archives/2016/01/laravel-blade-braces-dont-always-escape.php

LaravelからのDBアクセス  
https://www.ritolab.com/entry/93

JSとCSSのMixの設定  
https://www.ritolab.com/entry/30               ※情報が古い．要適宜読み替え  
https://readouble.com/laravel/5.8/ja/mix.html  ※公式

LaravelのPOST内容のvalidatin  
https://qiita.com/fagai/items/9904409d3703ef6f79a2

Laravelでのapi_tokenを使った認証  
https://qiita.com/zaburo/items/57657c78f54accf400f6
https://qiita.com/ayasamind/items/abadb9737e9d6480806b

Laravel+PHPUnitでテスト  
https://qiita.com/zaburo/items/839c81a1e166a48fe3fa

ログイン処理が必要なページ，メソッドのテスト  
https://qiita.com/acro5piano/items/924d7b0e6d331471b631

テストデータ（シード）の登録  
https://qiita.com/n-oota/items/e1890a6451fe33fb25f6
