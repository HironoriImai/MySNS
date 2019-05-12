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
showRegistrationFormメソッドを作ってみるも変わらず．もとに戻す．

→ggってたらmod_rewriteが有効になっていないだけと気付き解決
じゃあshowRegistrationFormメソッドはどこで宣言されてるの？あとで実装ちゃんと見てみよう．
こういうのあると面倒だから開発時は $ php artisan serve 使う．


###### ツイート機能 ######
モデル作成 & マイグレーションファイル作成
$ php artisan make:Model Tweet --migration

作成したマイグレーションファイル編集
→user_id, tweet_bodyカラムを追加

Tweetモデルを編集
$fillable = [ 'user_id', 'tweet_body', ];

マイグレーションを適用
$ php artisan migrate

ルーティング設定
Route::get('/@{user_name}', 'UserPageController@showUserPage');

Laravelだんだんわかってきた．
UserPageControllerを作成，ユーザのページとツイートの表示を実装
CSSはちゃんと作りたいけどひとまずコピペエンジニアリング．
インラインで気持ち悪いので時間あれば直す．

TweetControllerを作成，
ツイートの投稿/編集/削除用のルートを作成，とりあえずfunctionだけ作っとく．
ツイートの投稿のメソッドを実装．


##### ツイート編集・削除 #####
JSが必要になるのでMixをインストール
$ npm install

webpack.mix.jsを編集

vue.jsも覚えてみたいけど，今回は時間がないのでひとまず使い慣れたjQuery使う．

コントローラとモデルを編集．


###### タイムラインの表示 ######
TimelineControllerを作成，ルーティングを作成
各ユーザのページの逆をすればいいだけ
各ユーザページが時系列考慮してなかったのでついでに修正

- 自分以外のすべてのユーザーの投稿を時系列順に見る機能
これ，もしかして全ユーザのツイート混合ではなく，各ユーザごとの一覧表示のことを意味しているかも？
要確認．140字の全角半角と一緒に確認する．


###### 参考 ######
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
https://www.ritolab.com/entry/30				// 情報が古い．要適宜読み替え
https://readouble.com/laravel/5.8/ja/mix.html	// 公式

LaravelのPOST内容のvalidatin
https://qiita.com/fagai/items/9904409d3703ef6f79a2
