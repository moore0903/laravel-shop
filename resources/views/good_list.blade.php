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
    <div class="cpkuai clear" id="sidebar">
        <div class="cpfl fmyh">
            <div class="cpside scrollbar-none">
                <ul class="fmyh lifl clear">
                    <li v-for="cata in catalogs" :class="'top_catalogs _cata_'+cata.hashid">
                        <p class="name" @click="sidebar(cata.hashid)">@{{ cata.title }}</p>
                    </li>
                </ul>
            </div>
            <dl v-for="catalog in catalogs" :class="'j-content lifl clear _catalog_'+catalog.hashid">
                <dd v-for="attr in catalog.attr"><a v-bind:href="attr.url">@{{ attr.title }}</a></dd>
            </dl>
        </div>
        <div class="cpmain">
            <ul class="cplist fmyh lifl clear">
                <li v-for="item in shopItem">
                    <a v-bind:href="item.url">
                        <p class="tu fl"><img :src="'{{asset('upload/').'/'}}'+item.img"></p>
                        <p class="name">@{{ item.title }}</p>
                        <p class="nr">@{{ item.short_title }}</p>
                        <p class="time">价格:<span>￥@{{ item.price }}元/@{{ item.unit_number }}@{{ item.units }}</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" @click="delCart(item.raw_id?item.raw_id:'')" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" :value="item.rows.qty?item.rows.qty:'0'"/>
                            <input class="add" @click="addCart(item.hashid)" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="cpanniu fmyh clear" id="shop_item_cart"> 合计：<i>@{{ cart_price_count }}</i>元
        <p class="anniu fr">
            <input name="" onclick="window.location='{{ url('/cart/list') }}'" type="button" value="选好了">
        </p>
    </div>
    <script>
        var catalog_sidebar = new Vue({
            el:'#sidebar',
            data:{
                'catalogs':{!! $catalogs??'{}' !!},
                'shopItem':{!! $shopItem??'{}' !!}
            },
            methods:{
                sidebar:function(hashid){
                    $('._cata_'+hashid).addClass('active').siblings('.top_catalogs').removeClass('active');
                    console.log($('._catalog_'+hashid).toggle());
                    $('._catalog_'+hashid).toggle().siblings('.j-content').hide();
                },
                addCart:function(hashid){
                    $.ajax({
                        type: "GET",
                        url: "{{ url('cart/add') }}",
                        data: "qty=1&hash_id="+hashid,
                        success: function(data){
                            if(data.stat == 1){
                                vue_shop_item_cart.cart_price_count = data.cart_totalPrice;

                            }else{
                                alert('添加购物车失败');
                            }
                        }
                    });
                },
                delCart:function(__raw_id){
                    $.ajax({
                        type: "GET",
                        url: "{{ url('cart/update') }}",
                        data: "type=minus&raw_id="+__raw_id,
                        success: function(data){
                            if(data.stat == 1){
                                vue_shop_item_cart.cart_price_count = data.cart_totalPrice;

                            }else{
                                alert('修改购物车失败');
                            }
                        }
                    });
                }
            }
        });

        var vue_shop_item_cart = new Vue({  //用于列表页的价钱显示
            el:'#shop_item_cart',
            data:{
                cart_price_count : {!! \Cart::totalPrice() !!}
            },
        });
    </script>
@endsection

@section('bottom_bar')

@endsection