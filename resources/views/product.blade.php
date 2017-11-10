@extends('layouts.app')


@section('content')
    <div class="hydhbanner" style="background:url({{ asset('images/img9.jpg') }}) no-repeat center top;"></div>
    <div class="wrap">
        <div class="vipside fl">
            <div class="vipdhtitle">会员订货系统<i class="ttuc">Member order system</i></div>
            <div class="pro_case protop">
                <div class="title">会员功能</div>
                <ul class="lifl clear">
                    <li class="on"><a href="{{ url('/product') }}">在线订购</a></li>
                    <li><a href="{{ url('/cart/list') }}">查看购物车</a></li>
                    <li><a href="{{ url('/my_order') }}">查看我的订单</a></li>
                    <li><a href="{{ url('/notice') }}">会员公告</a></li>
                    <li><a href="{{ url('/reset_password') }}">修改密码</a></li>
                    <li><a href="{{ url('/logout') }}">安全退出</a></li>
                </ul>
            </div>
            <div class="series">
                <div class="title">产品系列<i class="ttuc">Product series</i></div>
                <ul class="lifl clear">
                    @foreach(\App\Models\Catalog::parentCatalog(1) as $catalog)
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
                        <input name="" type="submit" />
                    </p>
                </form>

            </div>
        </div>
        <div class="vipmain fr">
            <div class="ny_title"><i class="fr">你所在位置：会员中心</i> 您好 <span>{{ $user->user_name??$user->name }}</span> 您是我们的 <span>经销商</span>，您目前有 <span>0</span> 个待处理订单。</div>
            <ul class="zxdglist lifl clear">
                @foreach($list as $item)
                <li><a href="{{ url('/product/detail/'.$item->id) }}">
                        <p class="tu"><img src="{{ asset('upload/'.$item->img) }}" width="237" height="188" /></p>
                        <p class="name">{{ $item->title }}</p>
                        <p class="more"></p>
                    </a></li>
                @endforeach
            </ul>
            <div class="page fmyh">
                {{ $list->links() }}
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