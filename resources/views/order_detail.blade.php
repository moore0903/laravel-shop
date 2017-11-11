@extends('layouts.app')


@section('content')
    <div class="hydhbanner" style="background:url({{ asset('images/img9.jpg') }}) no-repeat center top;"></div>
    <div class="wrap">
        <div class="vipside fl">
            <div class="vipdhtitle">会员订货系统<i class="ttuc">Member order system</i></div>
            <div class="pro_case protop">
                <div class="title">会员功能</div>
                <ul class="lifl clear">
                    <li><a href="{{ url('/product_search') }}">在线订购</a></li>
                    <li><a href="{{ url('/cart/list') }}">查看购物车</a></li>
                    <li class="on"><a href="{{ url('/order/list') }}">查看我的订单</a></li>
                    <li><a href="{{ url('/catalog/36') }}">会员公告</a></li>
                    <li><a href="{{ url('/reset_password') }}">修改密码</a></li>
                    <li><a href="{{ url('/logout') }}">安全退出</a></li>
                </ul>
            </div>
            <div class="series">
                <div class="title">产品系列<i class="ttuc">Product series</i></div>
                <ul class="lifl clear">
                    @foreach(\App\Models\Catalog::parentCatalog(32) as $catalog)
                        <li><a href="{{ url('/catalog/'.$catalog->id) }}">{{ $catalog->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="search clear">
                <form method="post" action="{{ url('/product_search') }}">
                    <p class="name fl">
                        <input type="text" name="search_title" id="userId" placeholder="请输入产品关键词">
                    </p>
                    <p class="nr fl">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input name="" type="submit" value="" />
                    </p>
                </form>

            </div>
        </div>
        <div class="vipmain fr">
            <div class="ny_title"><i class="fr">你所在位置：会员中心</i> 您已经成功登陆 <span>温特斯顿</span> 网络订货中心！</div>
            <div class="wdlistdetail">
                <div class="title">订单号：<i>{{ $order->serial }}</i></div>
                <div class="titleddzt">订单状态</div>
                <div class="wddztlist">
                    <p class="wdnr"></p>
                    <ul class="lifl clear mod">
                        <li @if($order->stat == \App\Models\Order::STAT_NOTPAY)  class="on" @endif>
                            <p class="tu">1</p>
                            <p class="name">订单提交成功</p>
                        </li>
                        <li @if($order->stat == \App\Models\Order::STAT_PAYED)  class="on" @endif>
                            <p class="tu">2</p>
                            <p class="name">商家已收到货款</p>
                        </li>
                        <li @if($order->stat == \App\Models\Order::STAT_EXPRESS)  class="on" @endif>
                            <p class="tu">3</p>
                            <p class="name">商家已经发货</p>
                        </li>
                        <li @if($order->stat == \App\Models\Order::STAT_FINISH)  class="on" @endif>
                            <p class="tu">4</p>
                            <p class="name">商品已收到</p>
                        </li>
                    </ul>
                </div>
                <div class="wdkuai">
                    <div class="wxtstitle">温馨提示：{{ \App\Models\Order::statDescribe($order->stat) }}</div>
                    <div class="wxqsd">订购商品详细清单</div>
                    <table class="wxxqlist">
                        <tr>
                            <th style="width:220px">商品名称</th>
                            <th style="width:114px">市场价</th>
                            <th style="width:100px">折扣</th>
                            <th style="width:125px">供货价</th>
                            <th style="width:102px">数量</th>
                            <th style="width:172px">总价</th>
                        </tr>
                        @foreach($details as $detail)
                        <tr>
                            <td style="width:220px">{{ $detail->product_title }}</td>
                            <td style="width:114px">￥{{ $detail->product_price }}</td>
                            <td style="width:100px">{{ Auth::user()->discount }}折</td>
                            <td style="width:125px">￥{{ $detail->product_price * Auth::user()->discount }}元</td>
                            <td style="width:102px">{{ $detail->product_num }}件</td>
                            <td style="width:172px">￥{{ $detail->product_price * Auth::user()->discount * $detail->product_num }}元</td>
                        </tr>
                        @endforeach
                    </table>
                    <p class="wxgwcsp">购物车中有商品：{{ $order->details()->count() }} 种  总数：{{ $order->details()->sum('product_num') }} 件  共计：￥{{ $order->totalpay }} 元（人民币）</p>
                    <div class="wxqsd">订货人信息</div>
                    <ul class="dhrlist lifl clear">
                        <li><p class="name fl">收货人姓名：</p><p class="nr fl">{{ Auth::user()->user_name }}</p></li>
                        <li><p class="name fl">性别：</p><p class="nr fl">{{ Auth::user()->sex? '女' : '男' }}</p></li>
                        <li><p class="name fl">联系电话：</p><p class="nr fl">{{ Auth::user()->phone }}</p></li>
                        <li><p class="name fl">收货人地址：</p><p class="nr fl">{{ Auth::user()->address }}</p></li>
                        <li><p class="name fl">邮政编码：</p><p class="nr fl">{{ Auth::user()->code }}</p></li>
                        <li><p class="name fl">电子信箱：</p><p class="nr fl">{{ Auth::user()->email }}</p></li>
                        {{--<li><p class="name fl">是否需要发票：</p><p class="nr fl">否</p></li>--}}
                    </ul>
                    <ul class="dklist lifl clear">
                        <li><a href="{{ url('/order/list') }}">返回订单列表</a></li>
                        <li><a href="#">删除该订单</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clean"></div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(1);
    </script>
@endsection