@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="cart_list">
    <template v-if="cart_count <= 0">
        <div class="land">购物车</div>
        <div class="shopping"></div>
        <div class="evaanniu">
            <input name="shopping" @click="shopping()" type="button" value="去购物">
        </div>
    </template>
    <template v-else>
        <div class="land">购物车</div>
        <div class="shoptitle">注意：请在30分钟完成支付</div>
        <ul class="shoplist lifl clear">
            <li v-for="cart in cart_lists">
                <p class="choice">
                    <input @click="cartRawId(cart.__raw_id)" name="cartpro" type="checkbox" :value="cart.__raw_id">
                </p>
                <p class="delete_box" @click="delCart(cart.__raw_id)"></p>
                <p class="tu fl"><img width="125px" :src="cart.imgUrl"/></p>
                <p class="name">@{{ cart.name }}</p>
                <p class="jiagea">¥ @{{ cart.price }}元</p>
                <div class="gwsl fl">
                    <input class="min" @click="updateCart(cart.__raw_id)" name="" type="button" value="-" />
                    <input class="text_box" name="" type="text" :value="cart.qty" />
                    <input class="add" @click="addCart(cart.hashid)" name="" type="button" value="+" />
                </div>
            </li>
        </ul>
        <div class="fselect">
            <p class="choice fschoice">
                <input name="all-sec" type="checkbox" @click="allRawIds()" value="">
            </p>
            <p class="fs1">全选</p>
            <p class="fs2">合计¥ @{{ cart_totalPrice }}元 <i>不含运费</i></p>
            <p class="fs3"><a href="#">结算(@{{ cart_raw_ids.length?cart_raw_ids.length:'0' }})</a></p>
        </div>
        @include('layouts.footer_nav')
        <div class="fstop"></div>
        {{--<div class="jd_win">--}}
        {{--<div class="jd_win_box">--}}
        {{--<div class="jd_win_tit">你确定删除该商品吗？</div>--}}
        {{--<div class="jd_btn clearfix clear"> <a href="#" class="cancle f_left fl">取消</a> <a href="#" class="submit f_right fr">确定</a> </div>--}}
        {{--</div>--}}
        {{--</div>--}}
    </template>
</div>
@endsection

@section('script')
    <script>
        var cart_list = new Vue({
            el:'#cart_list',
            data:{
                'cart_lists':{!! $cart_lists??'{}' !!},
                'cart_count':{!! $cart_count??'{}' !!},
                'cart_totalPrice':{!! $cart_totalPrice??'{}' !!},
                'cart_raw_ids':new Array(),
                'cart_raw_count':{!! $cart_raw_count??'{}' !!}
            },
            methods:{
                addCart:function(hashid){
                    $.ajax({
                        type: "GET",
                        url: "{{ url('cart/add') }}",
                        data: "qty=1&hash_id="+hashid,
                        success: function(data){
                            if(data.stat == 1){
                                cart_list.cart_totalPrice = data.cart_totalPrice;
                                cart_list.cart_count = data.cart_count;
                                cart_list.cart_lists = data.cart_lists;
                            }else{
                                layer.msg('添加购物车失败');
                            }
                        }
                    });
                },
                updateCart:function(__raw_id){
                    $.ajax({
                        type: "GET",
                        url: "{{ url('cart/update') }}",
                        data: "type=minus&raw_id="+__raw_id,
                        success: function(data){
                            if(data.stat == 1){
                                cart_list.cart_totalPrice = data.cart_totalPrice;
                                cart_list.cart_count = data.cart_count;
                                cart_list.cart_lists = data.cart_lists;
                            }else{
                                layer.msg('修改购物车失败');
                            }
                        }
                    });
                },
                delCart:function(__raw_id){
                    layer.confirm('确定删除该商品吗?',function(index){
                        layer.close(index);
                        $.ajax({
                            type: "GET",
                            url: "{{ url('cart/del') }}",
                            data: "raw_id="+__raw_id,
                            success: function(data){
                                if(data.stat == 1){
                                    cart_list.cart_totalPrice = data.cart_totalPrice;
                                    cart_list.cart_count = data.cart_count;
                                    cart_list.cart_lists = data.cart_lists;
                                }else{
                                    layer.msg('删除购物车失败');
                                }
                            }
                        });
                    });
                },
                shopping:function(){
                    window.location.href='{{url("shop_item/good_list")}}';
                },
                cartRawId:function(__raw_id){
                    var index=0,is=0;
                    for(var i = 0;i<this.cart_raw_ids.length;i++){
                        if(this.cart_raw_ids[i] == __raw_id){
                            is = 1;
                            index = i;
                        }
                    }
                    if(is == 0){
                        this.cart_raw_ids.splice(index,0,__raw_id);
                    }else{
                        this.cart_raw_ids.splice(index,1);
                    }
                },
                allRawIds:function(){
                    if(this.cart_raw_ids.length <= 0){
                        for(cart in this.cart_lists){
                            this.cart_raw_ids.splice(0,0,cart);
                        }
                    }else{
                        this.cart_raw_ids = '';
                    }
                }
            }
        });
    </script>
@endsection