@extends('layouts.app')


@section('content')
    <div class="hydhbanner" style="background:url({{ asset('images/img9.jpg') }}) no-repeat center top;"></div>
    <div class="wrap">
        <div class="vipside fl">
            <div class="vipdhtitle">会员订货系统<i class="ttuc">Member order system</i></div>
            <div class="pro_case protop">
                <div class="title">会员功能</div>
                <ul class="lifl clear">
                    <li class="on"><a href="#">在线订购</a></li>
                    <li><a href="#">查看购物车</a></li>
                    <li><a href="#">查看我的订单</a></li>
                    <li><a href="#">会员公告</a></li>
                    <li><a href="#">修改密码</a></li>
                    <li><a href="#">安全退出</a></li>
                </ul>
            </div>
            <div class="series">
                <div class="title">产品系列<i class="ttuc">Product series</i></div>
                <ul class="lifl clear">
                    <li><a href="#">地暖线材及辅配件</a></li>
                    <li><a href="#">HLK高端A型彩画墙暖</a></li>
                    <li><a href="#">地暖线材及辅配件</a></li>
                    <li><a href="#">HLK高端A型彩画墙暖</a></li>
                </ul>
            </div>
            <div class="search clear">
                <p class="name fl">
                    <input type="text" id="userId" placeholder="请输入产品关键词">
                </p>
                <p class="nr fl">
                    <input name="" type="button" />
                </p>
            </div>
        </div>
        <div class="vipmain fr">
            <div class="ny_title"><i class="fr">你所在位置：会员中心</i> 您好 <span>张先生</span> 您是我们的 <span>经销商</span>，您目前有 <span>0</span> 个待处理订单。</div>
            <div class="gwckuai">
                <div class="vipzcnr">
                    <div class="title">用户 <i>张先生</i> 注册信息</div>
                    <ul class="lifl clear">
                        <li>
                            <p class="name">用户密码：</p>
                            123456789</li>
                        <li>
                            <p class="name">用户姓名：</p>
                            张先生</li>
                        <li>
                            <p class="name">用户性别：</p>
                            男</li>
                        <li>
                            <p class="name">电子邮箱：</p>
                        </li>
                        <li>
                            <p class="name">联系手机：</p>
                            13098868407</li>
                        <li>
                            <p class="name">联系电话：</p>
                        </li>
                        <li>
                            <p class="name">邮政编码：</p>
                        </li>
                        <li>
                            <p class="name">QQ/MSN：</p>
                        </li>
                        <li>
                            <p class="name">通讯地址：</p>
                        </li>
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