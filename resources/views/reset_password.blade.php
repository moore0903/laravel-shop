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
                    <li><a href="{{ url('/order/list') }}">查看我的订单</a></li>
                    <li><a href="{{ url('/catalog/36') }}">会员公告</a></li>
                    <li class="on"><a href="{{ url('/reset_password') }}">修改密码</a></li>
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
                <div class="vipzcnr vipzcnr1">
                    <div class="title">用户 <i>{{ Auth::user()->user_name??Auth::user()->name }}</i> 注册信息</div>
                    <form name="form1" action="{{ url('/reset_password') }}" class="demoform" method="post">
                        <dl class="lifl clear">
                            <dd>
                                <p class="name fl">原密码：</p>
                                <p class="nr fl">
                                    <input name="old_password" type="password" />
                                </p>
                            </dd>
                            <dd>
                                <p class="name fl">新密码：</p>
                                <p class="nr fl">
                                    <input name="new_password" type="password" />
                                </p>
                            </dd>
                            <dd>
                                <p class="name fl">再次输入新密码：</p>
                                <p class="nr fl">
                                    <input name="confirm_password" type="password" />
                                </p>
                            </dd>
                            <dd>
                                <p class="anniu">
                                    <input name="" type="submit" value="提交修改密码" />
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                </p>
                            </dd>
                        </dl>
                    </form>
                </div>
            </div>
        </div>
        <div class="clean"></div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(1);

        $(".demoform").Validform({
            tiptype: 1,
            ajaxPost: true,
            callback: function (data) {
                if (data.status === 'n') {
                    $.Showmsg(data.info);
                    $('#captcha').trigger('click');
                    return false;
                } else {
                    $.Showmsg('修改成功,请重新登录');
                    window.location.href = "{{ url('/') }}";
                }
            }
        });
    </script>
@endsection