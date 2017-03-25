@extends('layouts.app')

@section('banner')
    <div class="banner">
        <section class="slider">
            <div class="flexslider">
                <ul class="slides">
                    <li><img src="{{ asset('images/banner.jpg') }}"></li>
                    <li><img src="{{ asset('images/banner.jpg') }}"></li>
                    <li><img src="{{ asset('images/banner.jpg') }}"></li>
                    <li><img src="{{ asset('images/banner.jpg') }}"></li>
                </ul>
            </div>
        </section>
    </div>
@endsection

@section('search')

@endsection


@section('content')
    <ul class="menu fmyh lifl clear">
        <li><a href="#">
                <p class="tu"><img src="{{ asset('images/m01.png') }}"/></p>
                <p class="name">首页</p>
            </a></li>
        <li><a href="#">
                <p class="tu"><img src="{{ asset('images/m02.png') }}"/></p>
                <p class="name">菜单</p>
            </a></li>
        <li><a href="#">
                <p class="tu"><img src="{{ asset('images/m03.png') }}"/></p>
                <p class="name">联系我们</p>
            </a></li>
        <li><a href="#">
                <p class="tu"><img src="{{ asset('images/m04.png') }}"/></p>
                <p class="name">个人中心</p>
            </a></li>
    </ul>


    <div class="news fmyh">
        <div class="bt">菜品推荐</div>
        <ul class="lifl clear">
            @foreach(\App\Models\ShopItem::shopItemList(0,true,0,3) as $item)
            <li><a href="{{ url('/shopItem/detail').'/'.\Hashids::encode($item->id) }}">
                    <p class="tu fl"><img src="{{ asset('upload/'.$item->img) }}"/></p>
                    <p class="name">{{ $item->title }}</p>
                    <p class="nr">{{ $item->short_title }}</p>
                    <p class="time">价格:<span>￥{{ $item->price }}元/{{ $item->unit_number }}{{ $item->units }}</span></p>
                </a></li>
            @endforeach
        </ul>
    </div>
@endsection
