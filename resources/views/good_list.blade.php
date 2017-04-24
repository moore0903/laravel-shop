@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="shop_item_list" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="cpdm clear">
        <div class="header j-search-input">
            <p class="hlbg fl"></p>
            <p class="hrbg fl">
                <input type="button" name="" value="搜索商品名称或品牌">
            </p>
        </div>
        <ul class="cpfllist lifl clear">
            <li v-for="(catalog,index) in catalogs" :class="'catalogs _cata_'+catalog.hashid">
                <a href="javascript:void(0);" v-on:click='sidebar(catalog.hashid)'>@{{ catalog.title }}</a>
            </li>
        </ul>
        <ul class="cpsxlist lifl clear">
            <li class="on"><a href="javascript:;">销量排序</a></li>
            <li><a href="javascript:;"><i class="c01">价格排序</i></a></li>
            <li><a href="javascript:;"><i class="c02">筛选</i></a></li>
        </ul>
    </div>
    <aside>
        <div class="menu-left scrollbar-none">
            <ul>
                <li v-for="cata in subCatalog" v-on:click="getShopItems(cata.hashid)">
                    @{{ cata.title }}
                </li>
            </ul>
        </div>
    </aside>
    <section class="menu-right padding-all scrollbar-none j-content">
        <ul class="lifl clear">
            <li v-for="item in shopItems">
                <a :href="item.url">
                    <p class="tu"><img :src="item.imgUrl"/></p>
                    <p class="name">@{{ item.title }}</p>
                    <p class="jige"><i class="fr">¥ @{{item.original_price}}元</i>¥ @{{item.price}}元</p>
                </a>
            </li>
        </ul>
    </section>
    <ul class="footer fmyh lifl clear">
        <li class="f01"><a href="index.asp">
                <p class="tu"></p>
                <p class="name">首页</p>
            </a></li>
        <li class="f02 on"><a href="cpfl.asp">
                <p class="tu"></p>
                <p class="name">分类</p>
            </a></li>
        <li class="f03"><a href="#">
                <p class="tu"></p>
                <p class="name">购物车</p>
            </a></li>
        <li class="f04"><a href="#">
                <p class="tu"></p>
                <p class="name">个人中心</p>
            </a></li>
    </ul>
    <div class="stop"></div>
    <div class="cpflnr j-ccgg clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt">筛选</div>
            <div class="sxtitle">价格区间（元）</div>
            <ul class="sxjg lifl clear">
                <li><input type="text" name="text" placeholder="最低价"></li>
                <li><input type="text" name="text" placeholder="最高价"></li>
            </ul>
            <div class="sxtitle">产地</div>
            <ul class="cpsxccc lifl clear">
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
                <li><a href="#">四川</a></li>
            </ul>
        </div>
    </div>
    <div class="search">
        <div class="sedm">
            <p class="fh j-close-search"></p>
            <div class="header clear">
                <p class="hlbg fl"></p>
                <p class="hrbg fl">
                    <input type="text" name="text" placeholder="搜索商品名称或品牌">
                </p>
            </div>
            <p class="ssk">
                <input type="button" value="搜索">
            </p>
        </div>
        <div class="seakuai">
            <div class="title">热门搜索</div>
            <ul class="selist lifl clear">
                <li><a href="#">五粮液</a></li>
                <li><a href="#">茅台</a></li>
                <li><a href="#">剑南春</a></li>
                <li><a href="#">五粮液</a></li>
                <li><a href="#">茅台</a></li>
                <li><a href="#">剑南春</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function($){
            var layerLoad = '';

            var shop_item_list = new Vue({
                el:'#shop_item_list',
                data:{
                    'shopItems':{!! $shopItem??'{}' !!},
                    'cart':{!! $cart??'{}' !!},
                    'catalogs':{!! $catalogs??'{}' !!},
                    'subCatalog':{!! $subCatalogs??'{}' !!},
                },
                methods:{
                    getShopItems:function(hashid){
                        $.get("{{url('shop_item/ajax_shop_item')}}", { hash_id: hashid},
                            function(data){
                                layer.close(layerLoad);
                                if(data.stat){
                                    shop_item_list.shopItems = data.shopItems;
                                }else{
                                    layer.msg(data.msg);
                                }
                            });
                    },
                    getSubCatalog:function(hashid){
                        $.get("{{url('shop_item/ajax_sub_catalog')}}", { hash_id: hashid},
                            function(data){
                                layer.close(layerLoad);
                                if(data.stat){
                                    shop_item_list.subCatalog = data.catalogs;
                                }else{
                                    layer.msg(data.msg);
                                }
                            });
                    },
                    sidebar:function(hashid){
                        layerLoad = layer.load();
                        $('._cata_'+hashid).addClass('on').siblings('.catalogs').removeClass('on');
                        shop_item_list.getSubCatalog(hashid);
                        shop_item_list.getShopItems(hashid);
                    },
                }
            });
        });


    </script>
@endsection