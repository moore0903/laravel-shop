@extends('layouts.app')

@section('content')
    <header class="ui-header ui-header-style">
        <i class="am-icon-angle-left am-icon-fw" onclick="history.back()"></i>
        <h1>您的手机品牌是？</h1>
    </header>
    <section class="ui-container">
        <div class="brand-list" id="brand_list">
            @foreach($mobileBrands as $brand)
                <div class="brand-item" data-id="{{ $loop->iteration }}" data-name="{{ $brand->brand_name }}">
                    <a href="{{ url('mobileModel/'.'?brand_id='.$brand->id) }}">{{ $brand->brand_name }}<i class="am-icon-angle-right am-fr am-margin-right"></i></a>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('script')

@endsection