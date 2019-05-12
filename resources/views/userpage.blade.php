<!DOCTYPE HTML>
<html lang="ja">
    <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $username }}</title>
    <link rel="stylesheet" href="/css/userpage.css">
    </head>
    <body style="height:100%; background-color: #E6ECF0;">
        <div class="wrapper" style="margin: 0 auto; width: 50%; height: 100%; background-color: white;">
            <form action="/tweet/post" method="post">
            {{ csrf_field() }}
                <div style="background-color: #E8F4FA; text-align: center;">
                    <input type="text" name="tweet_body" style="margin: 1rem; padding: 0 1rem; width: 70%; border-radius: 6px; border: 1px solid #ccc; height: 2.3rem;" placeholder="今どうしてる？">
                    <button type="submit" style="background-color: #2695E0; color: white; border-radius: 10px; padding: 0.5rem;">ツイート</button>
                </div>
                @if($errors->first('tweet'))
                    <p style="font-size: 0.7rem; color: red; padding: 0 2rem;">※{{$errors->first('tweet')}}</p>
                @endif
            </form>

            <div class="tweet-wrapper">
                @foreach($tweets as $tweet)
                <div class="tweet" data-tweet_id="{{ $tweet->tweet_id }}" style="padding:2rem; border-top: solid 1px #E6ECF0; border-bottom: solid 1px #E6ECF0;">
                    <div class="tweet_body">{{ $tweet->tweet_body }}</div>
                    <div>
                    	<a href="#" class="edit_tweet">編集</a>
                    	<a href="#" class="delete_tweet">削除</a>
               		</div>
                </div>
                @endforeach
            </div>
        </div>
        <script src="/js/app.js"></script>
        <script src="/js/userpage.js"></script>
    </body>
</html>