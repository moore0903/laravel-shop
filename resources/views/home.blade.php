@extends('layouts.app')

@section('header')
    <div class="header fmyh">
        <div class="logo"><a href="index.html"></a></div>
        <div class="mininav">
            <div class="mititle"></div>
            <ul class="mininavlist lifl clear">
                <li>
                    <p class="name"><a href="index.html">首页</a></p>
                </li>
                <li>
                    <p class="name m01"><a href="#1">省级政务云</a></p>
                    <dl class="clear">
                        <dd><a href="cloud.html">总体概况</a></dd>
                        <dd><a href="cloud1.html">基础设施</a></dd>
                        <dd><a href="cloud2.html">基础数据库共享</a></dd>
                        <dd><a href="cloud3.html">服务产品</a></dd>
                        <dd><a href="cloud4.html">服务保障</a></dd>
                        <dd><a href="cloud5.html">服务模式</a></dd>
                    </dl>
                </li>
                <li>
                    <p class="name"><a href="bigdata.html">大数据</a></p>
                </li>
                <li>
                    <p class="name m01"><a href="#1">产业引领</a></p>
                    <dl class="clear">
                        <dd><a href="leading.html">楚天大数据交易所(筹)</a></dd>
                        <dd><a href="leading1.html">湖北大数据产业园</a></dd>
                        <dd><a href="leading2.html">云应用</a></dd>
                    </dl>
                </li>
                <li>
                    <p class="name m01"><a href="#1">关于楚天云</a></p>
                    <dl class="clear">
                        <dd><a href="about.html">成立背景</a></dd>
                        <dd><a href="about1.html">企业简介</a></dd>
                        <dd><a href="about2.html">顶层设计</a></dd>
                        <dd><a href="about3.html">发展历程</a></dd>
                        <dd><a href="about4.html">动态资讯</a></dd>
                        <dd><a href="about5.html">未来展望</a></dd>
                    </dl>
                </li>
                <li>
                    <p class="name m01"><a href="#1">加入我们</a></p>
                    <dl class="clear">
                        <dd><a href="contact.html">招聘职位</a></dd>
                        <dd><a href="contact1.html">联系我们</a></dd>
                    </dl>
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


@section('bottom_bar')
    <ul class="footer fmyh lifl clear" id="vue_cart">
        <li class="f01"><a href="{{ url('/good_list') }}">
                <p class="tu"></p>
                <p class="name">选菜点菜</p>
            </a></li>
        <li class="f02"><a href="#">
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