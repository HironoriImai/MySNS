@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- API Tokenの作成 -->
                <div class="card-header">API Token</div>
                <div class="card-body">
                    <form method="post" action="/home/generate_api_token">
                        {{ csrf_field() }}
                        @if (Auth::user()->api_token===null)
                            <input type="text" readonly>
                        @else
                            <input type="text" value="{{ Auth::user()->api_token }}" style="width: 300px;" readonly>
                        @endif
                        <input type="submit" value="新規API Tokenを作成">
                    </form>
                </div>
                <!-- 自己紹介文 -->
                <div class="card-header">自己紹介</div>
                <div class="card-body">
                    <form method="post" action="/home/register_self_introduction">
                        {{ csrf_field() }}
                        <textarea name="self_introduction" style="width:100%">{{ Auth::user()->self_introduction }}</textarea>
                        <div style="text-align:right">
                            <input type="submit" value="自己紹介を更新">
                        </div>
                    </form>
                </div>
                <!-- プライベートアカウント -->
                <div class="card-header">プライベートアカウント</div>
                <div class="card-body">
                    <form method="post" action="/home/private_setting">
                        {{ csrf_field() }}
                        @if (Auth::user()->is_private)
                            <input type="hidden" name="private" value="false">
                            <input type="submit" value="プライベートを解除">
                        @else
                            <input type="hidden" name="private" value="true">
                            <input type="submit" value="プライベートに設定">
                        @endif
                    </form>
                </div>
                <!-- ほかページへのリンク -->
                <div class="card-header">The Other Users' Tweets</div>
                <div class="card-body">
                    <a href="/timeline_all_user">他の全てのユーザの投稿を表示</a>
                </div>
            </div>
        </div>
    </div>
</div>

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
@endsection
