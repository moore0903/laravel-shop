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

@section('content')
    <div class="news fmyh">
        <div class="bt">菜品推荐</div>
        <ul class="lifl clear">
            @foreach(\App\Models\ShopItem::shopItemList(0,true,0,3) as $item)
            <li><a href="#">
                    <p class="tu fl"><img src="{{ asset('upload/'.$item->img) }}"/></p>
                    <p class="name">{{ $item->title }}</p>
                    <p class="nr">{{ $item->short_title }}</p>
                    <p class="time">价格:<span>￥{{ $item->price }}元/{{ $item->unit_number }}{{ $item->units }}</span></p>
                </a></li>
            @endforeach
        </ul>
    </div>
@endsection
