@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="cart_submit">
    <div class="land">
        <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
        填写订单</div>
    <div class="distribution">
        <div class="disser">
            <div class="dispslist clear">
                <p class="bt fl">配送方式</p>
                <ul class="lifl fl clear">
                    <li>
                        <p class="name fl">
                            <input name="" type="radio" value="">
                        </p>
                        快递配送</li>
                    <li>
                        <p class="name fl">
                            <input name="" type="radio" value="">
                        </p>
                        门店自提</li>
                </ul>
            </div>
            <div class="disdzkuai">
                <ul class="lifl clear">
                    <!--<li class="di01">
                        <p class="name fl">联系人</p>
                        <p class="nr fl">
                            <input name="" type="text">
                        </p>
                    </li>-->
                    <!--<li class="di02">
                        <p class="name fl">手机</p>
                        <p class="nr fl">
                            <input name="" type="text">
                        </p>
                    </li>-->
                    <li class="di03">
                        <p class="name fl">详细地址</p>
                        <div class="yaddlist fl">
                          <p class="name"><i>李好</i> 18712345678</p>
                          <p class="nr">湖北省武汉市关山大道290号</p>
                        </div>
                        <div class="clean"></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="disser mtop">
            <div class="txevaxont clear" v-for="cart in cart_list">
                <p class="tu fl"><img width="125px" :src="cart.imgUrl"/></p>
                <p class="name">@{{ cart.name }}</p>
                <p class="sla">数量 x @{{ cart.qty }}</p>
                <p class="jya">¥@{{ cart.total }}元</p>
            </div>
        </div>
        <div class="dismsg clear">
            <p class="name fl">给商家留言：</p>
            <input type="text" name="text" placeholder="给商家留言（60字内）">
        </div>
        <ul class="diszflist lifl clear">
            <li><a href="#"><span class="fr">微信支付</span>支付方式</a></li>
            <li><a href="#"><span class="fr">暂无</span>我的优惠券</a></li>
        </ul>
        <ul class="disspnr lifl clear">
            <li><span class="fr">¥@{{ cart_totalPrice }}元</span>商品金额：</li>
            <li><span class="fr">¥@{{ postage }}元</span>物流费用：</li>
            <li><span class="fr">¥608.0元</span>优惠券：</li>
        </ul>
    </div>
    <div class="txorder">
        <p class="fs2">实付款¥@{{ cart_totalPrice }}元</p>
        <p class="fs3"><a href="#">提交订单</a></p>
    </div>
    <div class="stop"></div>
</div>
@endsection

@section('script')
    <script>
        var cart_submit = new Vue({
            el:'#cart_submit',
            data:{
                'address_list':{!! $address_list??'{}' !!},
                'gift_list':{!! $gift_list??'{}' !!},
                'cart_list':{!! $cart_list??'{}' !!},
                'cart_count':{!! $cart_count??'{}' !!},
                'cart_totalPrice':{!! $cart_totalPrice??'{}' !!},
                'postage':{!! $postage??'{}' !!}
            },
            methods: {

            }
        });
    </script>
@endsection