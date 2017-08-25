@extends('layouts.app')

@section('content')
    <div class="index-page-box">
        <div class="index-page-container">
            <div class="logo-box"><img src="{{ asset('assets/images/logo.png') }}" alt="高校修LOGO"></div>
            <div class="index-menu-box">
                <a class="menu-btn" href="{{ url('mobileBrand/') }}"><img src="{{ asset('assets/images/icon-phone.png') }}" class="icon-phone">手机报修</a>
                <a class="menu-btn" href="{{ url('pcConfirm/') }}"><img src="{{ asset('assets/images/icon-PC.png') }}" class="icon-PC">电脑报修</a>
            </div>
            <div class="index-fixed-btn"><img src="{{ asset('assets/images/icon-kf.png') }}">咨询客服</div>
        </div>
    </div>
@endsection

@section('script')

@endsection
