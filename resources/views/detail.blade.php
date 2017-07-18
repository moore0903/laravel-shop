@extends('layouts.app')

@section('header')

@endsection

@section('banner')

@endsection
@section('search')
    <div class="spxqtitle fmyh" xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="spxqnrkuai clear">
            <p class="name fl">
                <input type="text" name="text" placeholder="请输入你想要的菜品！">
            </p>
            <p class="nr fl">
                <input name="" type="button">
            </p>
        </div>
    </div>
@endsection

@section('content')
    <div class="detail fmyh" id="shop_item_detail">
        <div class="dtu"><img src="{{ asset('upload/'.$item->img) }}"/></div>
        <div class="dtitle fmyh">
            <p class="name">{{ $item->title }}({{ $item->unit_number }}{{ $item->units }})</p>
            <p class="nr">￥{{ $item->price }}</p>
        </div>
        <div class="sqxzkuai clear">
            <p class="name fl">选择数量：</p>
            <div class="gwsl fl">
                <input class="min" name="" type="button" value="-"/>
                <input class="text_box" name="qty" type="text" value="1"/>
                <input class="add" name="" type="button" value="+"/>
            </div>
            <p class="jrgwc fr">
                <input name="" @click="cartAdd" type="button" value="加入购物车">
            </p>
        </div>
        <div class="sqdetail">
            <div class="title clear">
                <h3>商品介绍</h3>
            </div>
            <div class="cont">{!! $item->detail !!}</div>
        </div>
    </div>

    <script>
        var shop_item_detail = new Vue({
            el:'#shop_item_detail',
            methods:{
                cartAdd:function(){
                    var qty = $('input[name="qty"]').val();
                    var has_id = '{{ \Hashids::encode($item->id) }}'
                    $.ajax({
                        type: "GET",
                        url: "{{ url('cart/add') }}",
                        data: "qty="+qty+"&hash_id="+has_id,
                        success: function(data){
                            if(data.stat == 1){
                                vue_cart.cart_count = data.cart_count;
//                                vue_shop_item_cart.cart_price_count = data.cart_price_count;
                            }else{
                                alert('添加购物车失败');
                            }
                        }
                    });
                }
            }
        });
    </script>

@endsection

@section('bottom_bar')
    <ul class="footer fmyh lifl clear" id="vue_cart">
        <li class="f01"><a href="{{ url('/shop_item/good_list') }}">
                <p class="tu"></p>
                <p class="name">选菜点菜</p>
            </a></li>
        <li class="f02"><a href="{{ url('/cart/list') }}">
                <p class="tu"></p>
                <p class="name">购物车<span v-if="cart_count > 0">(@{{ cart_count }})</span></p>
            </a></li>
        <li class="f03"><a href="{{ url('/') }}">
                <p class="tu"></p>
                <p class="name">首页</p>
            </a></li>
    </ul>



    <script>
        var vue_cart = new Vue({
            el:'#vue_cart',
            data:{
                cart_count : {!! \Cart::count() !!}
            },
        });
    </script>
@endsection