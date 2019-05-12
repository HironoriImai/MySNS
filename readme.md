###### プロジェクト作成・初期設定 ######
$ composer create-project --prefer-dist laravel/laravel MySNSTest
$ cd MySNSTest
$ composer global require "laravel/installer"
$ chmod -R 777 bootstrap/cache
$ chmod -R 777 storage
$ vi .env
	DB_CONNECTION=mysql
	DB_HOST=localhost
	DB_PORT=3306
	DB_DATABASE=MySNS
	DB_USERNAME=xxxx
	DB_PASSWORD=xxxx


###### ユーザ認証作成 ######
認証機能の追加
$ php artisan migrate
$ php artisan make:auth

ここで詰まった．
登録/ログインページが404．
$ php artisan route:list
ルートは通ってる．apacheのログにも404とだけ．

RegisterControllerコントローラにshowRegistrationFormメソッドがない．
showRegistrationFormメソッドを作ってみるも変わらず．

→ggってたらmod_rewriteが有効になっていないだけと気付き解決
じゃあshowRegistrationFormメソッドはどこで宣言されてるの？あとで実装ちゃんと見てみよう．
