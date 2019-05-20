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
            <div class="self_introduction">
                自己紹介：{{ $self_introduction }}
            </div>
            @if( Auth::check() && Auth::user()->name !== $username )
                <div class="follow">
                    @if( \App\Follow::isFollowingUserByName(Auth::user()->name, $username) )
                        <form method="post" action="/unfollow">
                            {{ csrf_field() }}
                            <input type=hidden name="username" value="{{ $username }}">
                            <input type="submit" value="フォロー解除">
                        </form>
                    @else
                        <form method="post" action="/follow">
                            {{ csrf_field() }}
                            <input type=hidden name="username" value="{{ $username }}">
                            <input type="submit" value="フォロー">
                        </form>
                    @endif
                </div>
            @endif
            <div class="tweet-wrapper">
                @if( Auth::check() && \App\Follow::isFollowingUserByName(Auth::user()->name, $username) )
                    @foreach($tweets as $tweet)
                    <div class="tweet" data-tweet_id="{{ $tweet->tweet_id }}" style="padding:2rem; border-top: solid 1px #E6ECF0; border-bottom: solid 1px #E6ECF0;">
                        <div>{{ $tweet->name }}</div>
                        <div class="tweet_body">{{ $tweet->tweet_body }}</div>
                    </div>
                    @endforeach
                @else
                    <div class="tweet" style="padding:2rem; border-top: solid 1px #E6ECF0; border-bottom: solid 1px #E6ECF0;">
                        <div class="tweet_body">このユーザのツイートは閲覧できません</div>
                    </div>
                @endif
            </div>
            
        </div>
        <script src="/js/app.js"></script>
        <script src="/js/userpage.js"></script>
    </body>
</html>
