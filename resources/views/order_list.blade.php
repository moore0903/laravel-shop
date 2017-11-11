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
            <div class="ny_title"><i class="fr">你所在位置：会员中心</i> 您好 <span>{{ Auth::user()->user_name??Auth::user()->name }}</span> 您是我们的 <span>经销商</span>，您目前有 <span>{{ \App\Models\Order::NotHandleOrder() }}</span> 个待处理订单。</div>
            <div class="gwckuai">
                <div class="wdlist">
                    <div class="title clear">
                        <div class="fr">请选择查找不同状态下的订单：
                            <select name="stat">
                                <option value="0">-请选择订单状态-</option>
                                <option value="{{ \App\Models\Order::STAT_NOTPAY }}">{{ \App\Models\Order::statDescribe(\App\Models\Order::STAT_NOTPAY) }}</option>
                                <option value="{{ \App\Models\Order::STAT_PAYED }}">{{ \App\Models\Order::statDescribe(\App\Models\Order::STAT_PAYED) }}</option>
                                <option value="{{ \App\Models\Order::STAT_EXPRESS }}">{{ \App\Models\Order::statDescribe(\App\Models\Order::STAT_EXPRESS) }}</option>
                                <option value="{{ \App\Models\Order::STAT_FINISH }}">{{ \App\Models\Order::statDescribe(\App\Models\Order::STAT_FINISH) }}</option>
                            </select>
                        </div>
                    </div>
                    <table class="wdlistkuai">
                        <tr>
                            <th width="25%">订单编号</th>
                            <th width="25%">商品总数</th>
                            <th width="25%">订单总计价格</th>
                            <th width="25%">订单状态</th>
                        </tr>
                        @foreach($orders as $order)
                        <tr>
                            <td width="25%"><a href="{{ url('/order/detail/'.$order->id) }}">{{ $order->serial }}</a></td>
                            <td width="25%"><i>{{ $order->details()->sum('product_num') }}</i>件</td>
                            <td width="25%"><i>￥{{ $order->totalpay }}</i>元</td>
                            <td width="25%">{{ \App\Models\Order::statDescribe($order->stat) }}</td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="wdlistms">点击订单编号查看订单详情！为了不耽误您的订购，请及时处理您的订单！</div>
                </div>
            </div>
        </div>
        <div class="clean"></div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(1);
        $('select[name="stat"]').on('change',function(){
            $(this).val();
            window.location.href = "{{ url('/order/list?stat=') }}"+$(this).val();
        });
    </script>
@endsection