@extends('layouts.app')

@section('content')
    <div class="wrap fmyh">
        <div class="land">
            <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
            第三方登录</div>
        <a href="{{ url('/oauth/github') }}"><img src="{{asset('images/github.jpg')}}" /></a>
    </div>
@endsection

@section('script')
@endsection