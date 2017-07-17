@extends('layouts.app')

@section('header')
    <div class="header fmyh">
        <div class="logo"><a href="index.html"></a></div>
        <div class="mininav">
            <div class="mititle"></div>
            <ul class="mininavlist lifl clear">
                <li>
                    <p class="name"><a href="{{url('/')}}">首页</a></p>
                </li>
                @foreach(\App\Models\Catalog::getCatalog() as $item)
                    <li>
                        <p class="name m01"><a href="{{url('/shop_item/good_list?catalog_id='.\Hashids::encode($item->id))}}">{{$item->title}}</a></p>
                        <dl class="clear">
                            @foreach($item->attr as $attr)
                            <dd><a href="{{url('/shop_item/good_list?catalog_id='.\Hashids::encode($attr->id))}}">{{$attr->title}}</a></dd>
                            @endforeach
                        </dl>
                    </li>
                @endforeach
                <li>
                    <p class="name m01"><a href="#1">联系我们</a></p>
                </li>
            </ul>
        </div>
    </div>
@endsection

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
        <li><a href="{{url('/')}}">
                <p class="tu"><img src="{{ asset('images/m01.png') }}"/></p>
                <p class="name">首页</p>
            </a></li>
        <li><a href="{{url('/shop_item/good_list')}}">
                <p class="tu"><img src="{{ asset('images/m02.png') }}"/></p>
                <p class="name">菜单</p>
            </a></li>
        <li><a href="{{url('/page/1')}}">
                <p class="tu"><img src="{{ asset('images/m03.png') }}"/></p>
                <p class="name">联系我们</p>
            </a></li>
        <li><a href="{{url('/user/info')}}">
                <p class="tu"><img src="{{ asset('images/m04.png') }}"/></p>
                <p class="name">个人中心</p>
            </a></li>
    </ul>


    <div class="news fmyh">
        <div class="bt">菜品推荐</div>
        <ul class="lifl clear">
            @foreach(\App\Models\ShopItem::shopItemList(0,true,0,3) as $item)
            <li><a href="{{ url('/shop_item/detail').'/'.\Hashids::encode($item->id) }}">
                    <p class="tu fl"><img src="{{ asset('upload/'.$item->img) }}"/></p>
                    <p class="name">{{ $item->title }}</p>
                    <p class="nr">{{ $item->short_title }}</p>
                    <p class="time">价格:<span>￥{{ $item->price }}元/{{ $item->unit_number }}{{ $item->units }}</span></p>
                </a></li>
            @endforeach
        </ul>
    </div>
@endsection


@section('bottom_bar')
    <ul class="footer fmyh lifl clear" id="vue_cart">
        <li class="f01"><a href="{{ url('/shop_item/good_list') }}">
                <p class="tu"></p>
                <p class="name">选菜点菜</p>
            </a></li>
        <li class="f02"><a href="{{ url('/cart/list') }}">
                <p class="tu"></p>
                <p class="name">购物车<span v-if="cart_count > 0">(@{{ cart_count }})</span></p>
            </a></li>
        <li class="f03"><a href="{{ url('/') }}">
                <p class="tu"></p>
                <p class="name">首页</p>
            </a></li>
    </ul>



    <script>
        var vue_cart = new Vue({
            el:'#vue_cart',
            data:{
                cart_count : {!! \Cart::count() !!}
            },
        });
    </script>
@endsection