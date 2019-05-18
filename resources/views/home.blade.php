@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>

                <!-- API Tokenの作成 -->
                <div class="card-header">API Token</div>

                <div class="card-body">
                    <form method="post" action="/home/generate_api_token">
                        {{ csrf_field() }}
                        @if ($api_token===null)
                            <input type="text" readonly>
                        @else
                            <input type="text" value="{{ $api_token }}" style="width: 300px;" readonly>
                        @endif
                            <input type="submit" value="新規API Tokenを作成">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
