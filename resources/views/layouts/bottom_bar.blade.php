<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 2017/3/18
 * Time: 20:26
 */
?>
<ul class="footer fmyh lifl clear" id="vue_cart">
    <li class="f01"><a href="{{ url('/good_list') }}">
            <p class="tu"></p>
            <p class="name">选菜点菜</p>
        </a></li>
    <li class="f02"><a href="#">
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
