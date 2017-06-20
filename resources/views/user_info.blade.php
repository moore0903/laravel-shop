@extends('layouts.app')

@section('content')
    <div class="wrap fmyh">
        <div class="setuptitle">
            <p class="szaniu"><a href="{{url('user/setting')}}"></a></p>
            <p class="tu"><img src="{{Auth::user()->headimage}}"/></p>
            <p class="name">{{Auth::user()->name}}</p>
        </div>
        <div class="setupddlist">
            <p class="bt"><span class="fr"><a href="{{url('order/list')}}">查看全部订单</a></span>我的订单</p>
            <ul class="lifl clear">
                <li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_NOTPAY}}">
                        @if($order_no_pay_count > 0)
                            <p class="sz">{{$order_no_pay_count}}</p>
                        @endif
                        <p class="tu1"></p>
                        <p class="name">待付款</p>
                    </a></li>
                <li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_PAYED}}">
                        @if($order_payed_count > 0)
                            <p class="sz">{{$order_payed_count}}</p>
                        @endif
                        <p class="tu5"></p>
                        <p class="name">待发货</p>
                    </a></li>
                <li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_EXPRESS}}">
                        @if($order_express_count > 0)
                            <p class="sz">{{$order_express_count}}</p>
                        @endif
                        <p class="tu2"></p>
                        <p class="name">待收货</p>
                    </a></li>
                <li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_EVALUATE}}">
                        @if($order_finish_count > 0)
                            <p class="sz">{{$order_finish_count}}</p>
                        @endif
                        <p class="tu3"></p>
                        <p class="name">待评价</p>
                    </a></li>
                <!--<li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_SERVICE}}">
                        @if($order_service_count > 0)
                            <p class="sz">{{$order_service_count}}</p>
                        @endif
                        <p class="tu4"></p>
                        <p class="name">退货</p>
                    </a></li>-->
            </ul>
        </div>
        <ul class="setuplmlist lifl clear">
            <li><a href="{{url('user/myGift')}}">
                    <p class="s01"><span class="name">我的优惠券</span></p>
                </a></li>
            <li><a href="{{url('user/myCollection')}}">
                    <p class="s02"><span class="name">我的收藏</span></p>
                </a></li>
            <li><a href="{{url('user/myBrowse')}}">
                    <p class="s03"><span class="name">我的足迹</span></p>
                </a></li>
            <li><a href="#">
                    <p class="s04"><span class="name">我的分享</span></p>
                </a></li>
        </ul>
        <ul class="setuplmlist lifl clear">
            <li><a href="#">
                    <p class="s05"><span class="name">我的微店</span></p>
                </a></li>
            <li><a href="tel:4008299519">
                    <p class="s06"><span class="name">联系客服</span></p>
                </a></li>
            <li><form action="{{url('/logout')}}" method="post">
                    <p class="s05"><input type="submit" class="name" value="退出登录"/></p>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form></li>
        </ul>
        <div class="setuptjkuai">
            <div class="title"></div>
            <div class="collelist">
                <ul class="cplist lifl clear">
                    @foreach($recomment_shop as $item)
                        <li><a href="#">
                                <p class="tu"><img src="{{asset('upload'.'/'.$item->img)}}"/></p>
                                <p class="name">{{$item->title}}</p>
                                <p class="jige"><i class="fr">¥{{ $item->original_price }}元</i>¥{{ $item->price }}元</p>
                                <ins class="c1"></ins>
                            </a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        @include('layouts.footer_nav')
        <div class="stop"></div>
    </div>
@endsection

@section('script')
    <script>
        $('.f04').addClass('on');
    </script>
@endsection