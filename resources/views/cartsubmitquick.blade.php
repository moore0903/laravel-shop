@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="cart_submit">
    <div class="land">
        <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
        填写订单</div>
    <form method="post" action="{{url('order/add')}}" id="orderAdd">
        <div class="distribution">
            <div class="disser">
                <div class="dispslist clear">
                    <p class="bt fl">配送方式</p>
                    <ul class="lifl fl clear">
                        <li>
                            <p class="name fl">
                                <input name="distribution" type="radio" value="express" @click="updateDistribution('express')">
                            </p>
                            快递配送</li>
                        <li>
                            <p class="name fl">
                                <input name="distribution" type="radio" value="since" checked @click="updateDistribution('since')">
                            </p>
                            门店自提</li>
                    </ul>
                </div>
                <div class="disdzkuai">
                    <ul class="lifl clear">
                        <template v-if="distribution == 'express'" >
                            <template v-if="address">
                                <li class="di03" >
                                    <p class="name fl">详细地址</p>
                                    <div class="yaddlist fl">
                                        <p class="name"><i>@{{ address.realname }}</i> @{{ address.phone }}</p>
                                        <p class="nr">@{{ address.address }}</p>
                                    </div>
                                    <div class="clean"></div>
                                </li>
                            </template>
                            <template v-else>
                                <li class="di01">
                                    <p class="name fl">新增送货地址</p>
                                </li>
                            </template>
                        </template>
                        <template v-else>
                            <li class="di03">
                                <p class="name fl">自提地址</p>
                                <div class="yaddlist fl">
                                    <p class="name"><i>@{{ since.realname }}</i> @{{ since.phone }}</p>
                                    <p class="nr">@{{ since.address }}</p>
                                </div>
                                <div class="clean"></div>
                            </li>
                        </template>
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
                <input type="text" name="remark" :value="remark?remark:''" placeholder="给商家留言（60字内）">
            </div>
            <ul class="diszflist lifl clear">
                <li><a href="#"><span class="fr">微信支付</span>支付方式</a></li>
                <li><a href="#"><span class="fr">暂无</span>我的优惠券</a></li>
            </ul>
            <ul class="disspnr lifl clear">
                <li><span class="fr">¥@{{ cart_totalPrice }}元</span>商品金额：</li>
                <li><span class="fr">¥@{{ postage }}元</span>物流费用：</li>
                <li><span class="fr">-¥0.00元</span>优惠券：</li>
            </ul>
        </div>
        <div class="txorder">
            <p class="fs2">实付款¥@{{ cart_totalPrice }}元</p>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="useraddress" value="since"/>
            <p class="fs3"><a href="javascript:void(0);" @click="formSubmit()">提交订单</a></p>
        </div>
        <div class="stop"></div>
    </form>
</div>
@endsection

@section('script')
    <script>
        var cart_submit = new Vue({
            el:'#cart_submit',
            data:{
                'address':{!! $address??'{}' !!},
                'gift_list':{!! $gift_list??'{}' !!},
                'cart_list':{!! $cart_list??'{}' !!},
                'cart_count':{!! $cart_count??'{}' !!},
                'cart_totalPrice':{!! $cart_totalPrice??'{}' !!},
                'postage':{!! $postage??'{}' !!},
                'distribution':'since',
                'since':{!! $since??'{}' !!},
                remark:'',
            },
            methods: {
                updateDistribution:function(type){
                    this.distribution = type;
                },
                formSubmit:function(){
                    var address = $('input[name="useraddress"]').val();
                    if(address == '' || address == null || address == 0){
                        layer.msg('请选择送货地址');
                        return;
                    }
                    $('#orderAdd').submit();
                }

            }
        });

        $(function(){
                <?php
                $error = $remark = '';
                if(isset($errors)){
                    $error = $errors->first();
                }
                $input = session()->get('_old_input')??'';
                if(!empty($input)){
                    $remark = $input['remark'];
                }
                ?>
            var error = '{{$error}}';
            var remark = '{{$remark}}';
            if(error){
                layer.msg(error);
            }
            if(remark){
                cart_submit.remark = remark;
            }
        });
    </script>
@endsection