@extends('layouts.app')

@section('header')

@endsection

@section('banner')

@endsection

@section('search')

@endsection

@section('content')
    <div id="cart_list">
        <div class="membertitle fmyh">
            <p class="fh"><a href="javascript:window.history.go(-1)"></a></p>
            购物车</div>
        <template v-if="cart_count <= 0">
            <div class="shopping"></div>
            <div class="evaanniu">
                <input name="" onclick="window.location='{{ url('/shop_item/good_list') }}'" type="button" value="去购物">
            </div>
        </template>
        <template v-else>
            <ul class="gwclist fmyh lifl clear">
                <li v-for="cart in cart_lists">
                    <p class="name fl">@{{ cart.name }}</p>
                    <p class="nr fl">单价:￥<span class="price">@{{ cart.price }}</span></p>
                    <div class="gwsl fl">
                        <input class="min" @click="updateCart(cart.__raw_id)" name="" type="button" value="-" />
                        <input class="text_box" name="" type="text" :value="cart.qty" />
                        <input class="add" @click="addCart(cart.hashid,cart.__raw_id)" name="" type="button" value="+" />
                    </div>
                </li>
            </ul>
            <p class="gwchj fmyh" id="shop_item_cart">合计：
                <label id="total">@{{ cart_totalPrice }}</label>
                元 </p>
            <div class="gwcbottom">
                <input type="button" value="确认提交">
            </div>
        </template>
    </div>
<script>
    var cart_list = new Vue({
        el:'#cart_list',
        data:{
            'cart_lists':{!! $cart_lists??'{}' !!},
            'cart_count':{!! $cart_count??'{}' !!},
            'cart_totalPrice':{!! $cart_totalPrice??'{}' !!},
    },
    methods:{
        addCart:function(hashid,__raw_id){
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
                        layer.msg('<span style="font-size: 30px;">添加购物车失败</span>');
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
                        layer.msg('<span style="font-size: 30px;">修改购物车失败</span>');
                    }
                }
            });
        },
    }
    });

</script>
@endsection

@section('bottom_bar')

@endsection