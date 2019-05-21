<!DOCTYPE HTML>
<html lang="ja">
    <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>タイムライン</title>
    <link rel="stylesheet" href="/css/userpage.css">
    </head>
    <body style="height:100%; background-color: #E6ECF0;">
        <div class="wrapper" style="margin: 0 auto; width: 50%; height: 100%; background-color: white;">
            <div class="tweet-wrapper">
                @foreach($tweets as $tweet)
                <div class="tweet" data-tweet_id="{{ $tweet->tweet_id }}" style="padding:2rem; border-top: solid 1px #E6ECF0; border-bottom: solid 1px #E6ECF0;">
                    <div>{{ $tweet->name }}</div>
                    <div class="tweet_body">{{ $tweet->tweet_body }}</div>
                </div>
                @endforeach
            </div>
        </div>
        <script src="/js/app.js"></script>
        <script src="/js/userpage.js"></script>
    </body>
</html>
