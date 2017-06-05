@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="cart_submit">
    <div v-show="is_main_show == 1">
        <div class="land">
            <p class="fhaniu"><a href="javascript:" onclick="self.location=document.referrer;"></a></p>
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
                                <p class="name fl on">
                                    <input name="distribution" type="radio" value="since" checked @click="updateDistribution('since')">
                                </p>
                                门店自提</li>
                        </ul>
                    </div>
                    <div class="disdzkuai">
                        <ul class="lifl clear">
                            <template v-if="distribution == 'express'" >
                                <template v-if="address">
                                    <li class="di03" @click="addressList()">
                                        <p class="name fl">详细地址</p>
                                        <div class="yaddlist fl">
                                            <p class="name"><i>@{{ address.realname }}</i> @{{ address.phone }}</p>
                                            <p class="nr">@{{ address.address }}</p>
                                        </div>
                                        <div class="clean"></div>
                                    </li>
                                </template>
                                <template v-else>
                                    <li class="di01" @click="addAddressShow()">
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
                    <input type="text" name="remark" :value="remark" placeholder="给商家留言（60字内）">
                </div>
                <ul class="diszflist lifl clear">
                    <li @click="payTypeShow()"><a href="javascript:void(0);"><span class="fr">@{{ pay_type_zh }}</span>支付方式</a></li>
                    <li @click="giftShow()"><a href="javascript:void(0);"><span class="fr">@{{ gift_zh }}</span>我的优惠券</a></li>
                </ul>
                <ul class="disspnr lifl clear">
                    <li><span class="fr">¥@{{ cart_totalPrice }}元</span>商品金额：</li>
                    <li><span class="fr">¥@{{ postage }}元</span>物流费用：</li>
                    <li><span class="fr">-¥@{{ discount }}元</span>优惠券：</li>
                </ul>
            </div>
            <div class="txorder">
                <p class="fs2">实付款¥@{{ cart_totalPrice + postage - discount }}元</p>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="useraddress" value="since"/>
                <input type="hidden" name="paytype" :value="pay_type_en"/>
                <input type="hidden" name="gift" :value="gift_id"/>
                <input type="hidden" name="postage" :value="postage"/>
                <p class="fs3"><a href="javascript:void(0);" @click="formSubmit()">提交订单</a></p>
            </div>
            <div class="stop"></div>
        </form>
    </div>

    {{-- 显示收货地址列表 --}}
    <div v-show="is_address_list_show == 1">
        <div class="land">
            <p class="fhaniu"><a href="javascript:void(0);" @click="show_main()"></a></p>
            选择收货地址</div>
        <ul class="addresslist lifl clear">
            <li v-for="address in address_list">
                <div class="addlist">
                    <p class="name"><i>@{{ address.realname }}</i> @{{ address.phone }}</p>
                    <p class="nr">@{{ address.address }}</p>
                </div>
                <div class="adshdz clear">
                    <ul class="lifl fr clear">
                        <li class="as1"><a href="javascript:void(0);" @click="updateAddress(address)">编辑</a></li>
                        <li class="as2"><a href="javascript:void(0);" @click="delAddress(address.id)" class="delete_box">删除</a></li>
                    </ul>
                    <p class="choice fschoice _address_list_selected" @click="addressSelected(address)">
                        <input name="all-sec" type="checkbox" value="">
                    </p>
                    <p class="name">选择收货地址</p>
                </div>
            </li>
        </ul>
        <div class="evaanniu">
            <input name="" @click="addAddressShow()" type="button" value="新增收货地址">
        </div>
    </div>

    {{-- 新增收货地址 --}}
    <div v-show="is_add_address_show == 1">
        <div class="land">
            <p class="fhaniu"><a href="javascript:void(0);" @click="show_main()"></a></p>
            新增收货地址</div>
            <ul class="shoutlist lifl clear">
                <li>
                    <p class="name">收货人</p>
                    <input type="text" name="add_address_realname" placeholder="请输入姓名">
                </li>
                <li>
                    <p class="name">手机号码</p>
                    <input type="text" name="add_address_phone" placeholder="请输入手机号">
                </li>
                <li>
                    <p class="name">详细地址</p>
                    <input type="text" name="add_address_address" placeholder="请输入详细地址">
                </li>
            </ul>
            <div class="evaanniu">
                <input name="" type="button" @click="addAddressSubmit()" value="保存并使用">
            </div>
    </div>

    {{-- 修改收货地址 --}}
    <div v-show="is_update_address_show == 1">
        <div class="land">
            <p class="fhaniu"><a href="javascript:void(0);" @click="show_main()"></a></p>
            修改收货地址</div>
        <ul class="shoutlist lifl clear">
            <li>
                <p class="name">收货人</p>
                <input type="text" name="update_address_realname" :value="updateAddress.realname" placeholder="请输入姓名">
            </li>
            <li>
                <p class="name">手机号码</p>
                <input type="text" name="update_address_phone" :value="updateAddress.phone" placeholder="请输入手机号">
            </li>
            <li>
                <p class="name">详细地址</p>
                <input type="text" name="update_address_address" :value="updateAddress.address" placeholder="请输入详细地址">
            </li>
        </ul>
        <div class="evaanniu">
            <input type="hidden" name="update_address_id" :value="updateAddress.id"/>
            <input name="" type="button" @click="updateAddressSubmit()" value="保存并使用">
        </div>
    </div>

    {{-- 显示支付方式 --}}
    <div v-show="is_pay_type_show == 1">
        <div class="land">
            <p class="fhaniu"><a href="javascript:void(0);" @click="show_main()"></a></p>
            支付方式</div>
        <div class="zhifutitle">选择支付方式</div>
        <ul class="zhifulist lifl clear">
            <li>
                <p class="tu"><img src="{{asset('images/img14.jpg')}}"/></p>
                <p class="name">微信支付</p>
                <p class="choice fschoice _pay_type" @click="payTypeSelected('WechatPay')">
                    <input name="all-sec" type="checkbox" value="">
                </p>
            </li>
            <li>
                <p class="tu"><img src="{{asset('images/img15.jpg')}}"/></p>
                <p class="name">支付宝支付</p>
                <p class="choice fschoice _pay_type" @click="payTypeSelected('Alipay')">
                    <input name="all-sec" type="checkbox" value="">
                </p>
            </li>
        </ul>
    </div>

    {{-- 优惠券选择列表 --}}
    <div v-show="is_gift_show == 1">
        <div class="land">
            <p class="fhaniu"><a href="javascript:void(0);" @click="show_main()"></a></p>
            我的优惠券</div>
        <ul class="couponlist lifl clear">
            <li v-for="gift in gift_list">
                <div class="coupkuai">
                    <p class="jiage">¥<span>@{{ gift.discountn }}</span> <i>满@{{ gift.discountnlimit }}减@{{ gift.discountn }}</i></p>
                    <p class="name">
                        <span>[所有订单］</span>
                        <i>适用范围：所有商品</i> <i>@{{ gift.start_time }}－@{{ gift.end_time }}</i>
                    </p>
                    <p class="receive"><a href="javascript:void(0);" @click="giftSelected(gift)">立即使用</a></p>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('script')
    <script>
        var cart_submit = new Vue({
            el:'#cart_submit',
            data:{
                'address':{!! $address??"''" !!},
                'address_list':{!! $address_list??'{}' !!},
                'gift_list':{!! $gift_list??'{}' !!},
                'cart_list':{!! $cart_list??'{}' !!},
                'cart_count':{!! $cart_count??'{}' !!},
                'cart_totalPrice':{!! $cart_totalPrice??'{}' !!},
                'postage':{!! $postage??'{}' !!},
                'discount':0,
                'distribution':'since',
                'since':{!! $since??'{}' !!},
                'remark':'',
                'updateAddress':'',
                'is_main_show':1,
                'is_address_list_show':0,
                'is_add_address_show':0,
                'is_update_address_show':0,
                'is_pay_type_show':0,
                'pay_type_en':'Alipay',
                'pay_type_zh':'支付宝支付',
                'is_gift_show':0,
                'gift_id':0,
                'gift_zh':'暂未选择'
            },
            methods: {
                payTypeShow:function(){  //显示支付方式
                    cart_submit.is_show_type('is_pay_type_show');
                },
                payTypeSelected:function(type){  //选定支付方式
                    cart_submit.is_show_type('is_main_show');
                    if(type == 'Alipay'){
                        this.pay_type_en = 'Alipay';
                        this.pay_type_zh = '支付宝支付';
                    }else{
                        this.pay_type_en = 'WechatPay';
                        this.pay_type_zh = '微信支付';
                    }
                    $('._pay_type').removeClass('on');
                },
                giftShow:function(){  //显示优惠券列表
                    cart_submit.is_show_type('is_gift_show');
                },
                giftSelected:function(gift){  //选定优惠券
                    cart_submit.is_show_type('is_main_show');
                    if(gift.discountnlimit <= this.cart_totalPrice){
//                        this.cart_totalPrice = this.cart_totalPrice + this.postage - gift.discountn;
                        cart_submit.gift_id = gift.id;
                        cart_submit.gift_zh = '满' + gift.discountnlimit +'减' + gift.discountn +'元';
                        cart_submit.discount = gift.discountn;
                    }else{
                        layer.msg('该优惠券满'+gift.discountnlimit+'元才可使用!');
                    }
                },
                delAddress:function(id){  //删除收货地址
                    layer.confirm('确定删除该收货地址吗?',function(index){
                        layer.close(index);
                        $.ajax({
                            type: "GET",
                            url: "{{ url('user/delAddress') }}",
                            data: "id="+id,
                            success: function(data){
                                if(data.stat == 1){
                                    cart_submit.address_list = data.address_list;
                                }else{
                                    layer.msg(data.msg);
                                }
                            }
                        });
                    });
                },
                addressList:function(){  //显示收货地址列表
                    cart_submit.is_show_type('is_address_list_show');
                },
                addressSelected:function(address){  //选定收货地址
                    cart_submit.is_show_type('is_main_show');
                    this.address = address;
                    $('._address_list_selected').removeClass('on');
                    $('input[name="useraddress"]').val(address.id);
                },
                addAddressShow:function(){  //显示新增收货地址
                    cart_submit.is_show_type('is_add_address_show');
                },
                addAddressSubmit:function(){  //保存新增收货地址
                    var realname = $('input[name="add_address_realname"]').val();
                    var phone = $('input[name="add_address_phone"]').val();
                    var address = $('input[name="add_address_address"]').val();
                    var _token = '{{ csrf_token() }}';
                    if(realname == null || realname == ''){
                        layer.msg('请填写收货人!');
                        return;
                    }else if(phone == null || phone == ''){
                        layer.msg('请输入联系电话');
                        return;
                    }else if(address == null || address == ''){
                        layer.msg('请输入收货地址!');
                        return;
                    }
                    $.post("{{url('user/addAddress')}}", { realname: realname, phone: phone, address: address, _token: _token},
                        function(data){
                            if(data.stat == 1){
                                cart_submit.address = data.data;
                                cart_submit.address_list = data.address_list;
                                cart_submit.is_show_type('is_main_show');
                                $('input[name="useraddress"]').val(data.data.id);
                            }else{
                                layer.msg(data.msg);
                            }
                        });
                },
                updateAddressShow:function(address){  //显示修改收货地址
                    cart_submit.is_show_type('is_update_address_show');
                    this.updateAddress = address;
                },
                updateAddressSubmit:function(){  //保存修改收货地址
                    var realname = $('input[name="update_address_realname"]').val();
                    var phone = $('input[name="update_address_phone"]').val();
                    var address = $('input[name="update_address_address"]').val();
                    var id = $('input[name="update_address_id"]').val();
                    var _token = '{{ csrf_token() }}';
                    if(realname == null || realname == ''){
                        layer.msg('请填写收货人!');
                        return;
                    }else if(phone == null || phone == ''){
                        layer.msg('请输入联系电话');
                        return;
                    }else if(address == null || address == ''){
                        layer.msg('请输入收货地址!');
                        return;
                    }
                    $.post("{{url('user/updateAddress')}}", { realname: realname, phone: phone, address: address, _token: _token, id: id},
                        function(data){
                            if(data.stat == 1){
                                cart_submit.address = data.data;
                                cart_submit.address_list = data.address_list;
                                cart_submit.is_show_type('is_main_show');
                                $('input[name="useraddress"]').val(data.data.id);
                            }else{
                                layer.msg(data.msg);
                            }
                        });
                },
                updateDistribution:function(type){   //更换自提或邮寄方式
                    this.distribution = type;
                    if(type == 'express'){
                        $('input[name="useraddress"]').val(0);
                        if(this.address){
                            $('input[name="useraddress"]').val(this.address.id);
                        }
                    }else{
                        $('input[name="useraddress"]').val('since');
                    }
                },
                formSubmit:function(){  //提交表单
                    var address = $('input[name="useraddress"]').val();
                    if(address == '' || address == null || address == 0){
                        layer.msg('请选择送货地址');
                        return;
                    }
                    $('#orderAdd').submit();
                },
                show_main:function(){
                    this.is_show_type('is_main_show');
                },
                is_show_type:function(show_type){  //显示模块
                    this.is_main_show = 0;
                    this.is_address_list_show = 0;
                    this.is_add_address_show = 0;
                    this.is_update_address_show = 0;
                    this.is_pay_type_show = 0;
                    this.is_gift_show = 0;
                    if(show_type == 'is_main_show'){
                        this.is_main_show = 1;
                    }else if(show_type == 'is_address_list_show'){
                        this.is_address_list_show = 1;
                    }else if(show_type == 'is_add_address_show'){
                        this.is_add_address_show = 1;
                    }else if(show_type == 'is_update_address_show'){
                        this.is_update_address_show = 1;
                    }else if(show_type == 'is_pay_type_show'){
                        this.is_pay_type_show = 1;
                    }else if(show_type == 'is_gift_show'){
                        this.is_gift_show = 1;
                    }
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
            $('.f03').addClass('on');
        });
    </script>
@endsection