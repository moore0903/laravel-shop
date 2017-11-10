@extends('layouts.app')


@section('content')
    <div class="hydhbanner" style="background:url({{ asset('images/img9.jpg') }}) no-repeat center top;"></div>
    <div class="wrap">
        <div class="vipside fl">
            <div class="vipdhtitle">会员订货系统<i class="ttuc">Member order system</i></div>
            <div class="pro_case protop">
                <div class="title">会员功能</div>
                <ul class="lifl clear">
                    <li class="on"><a href="{{ url('/product_search') }}">在线订购</a></li>
                    <li><a href="{{ url('/cart/list') }}">查看购物车</a></li>
                    <li><a href="{{ url('/order/list') }}">查看我的订单</a></li>
                    <li><a href="{{ url('/notice') }}">会员公告</a></li>
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
                        <input type="text" name="key" id="userId" placeholder="请输入产品关键词">
                    </p>
                    <p class="nr fl">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input name="" type="submit" value="" />
                    </p>
                </form>

            </div>
        </div>
        <div class="vipmain fr">
            <div class="ny_title"><i class="fr">你所在位置：会员中心>{{ $catalog->title }}</i> 您已经成功登陆 <span>温特斯顿</span> 网络订货中心!</div>
            <div class="protopbg clear">
                <div class="prolkuai fl">
                    <div class="protcont scroll">
                        <ul>
                            @foreach($info->images as $image)
                            <li><img src="{{ asset('upload/'.$image) }}" width="357" height="285" /></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="probcont scroll">
                        <ul>
                            @foreach($info->images as $image)
                                <li><img src="{{ asset('upload/'.$image) }}"/></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="prorkuai fl">
                    <p class="bt">{{ $info->title }}</p>
                    <ul class="lifl clear">
                        <li>
                            <p class="name">市场价：<i>￥{{ $info->price }}</i></p>
                        </li>
                        <li>
                            <p class="name">会员折扣：<i>{{ $user->discount }}折</i></p>
                        </li>
                        <li>
                            <p class="name">供货价：<i>￥{{ $info->price * $user->discount }}</i></p>
                        </li>
                        <li>
                            <p class="name fl">购买数量：</p>
                            <p class="nr fl">
                                <input name="qty" type="text" value="1" />
                            </p>
                            <p class="time fl">件</p>
                        </li>
                        <li class="gwc">
                            <input name="cart_add" type="button" value="" />
                        </li>
                    </ul>
                </div>
            </div>
            <div class="prodetail">
                <div class="title">产品参数</div>
                {{--<ul class="pdlist lifl clear">--}}
                    {{--<li>长度：13.58米</li>--}}
                    {{--<li>额定功率：220W</li>--}}
                    {{--<li>适用面积：1.5--2㎡</li>--}}
                {{--</ul>--}}
                <div class="cont">
                    {!! $info->detail !!}
                </div>
            </div>
        </div>
        <div class="clean"></div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(1);
        $('input[name="cart_add"]').on('click',function(){
            var qty = $('input[name="qty"]').val();
            qty = qty ? qty : 1;
            $.get("{{ url('/cart/add') }}", { qty: qty, id: {{ $info->id }} },
                function(data){
                    if(data.stat == 1){
                        layer.msg('加入购物车成功');
                    }else{
                        layer.msg('加入购物车失败');
                    }
                });
        });
    </script>
@endsection