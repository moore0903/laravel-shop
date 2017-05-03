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
            <li class="_sort _sortSell"><a href="javascript:void(0);" @click="sortType('sell')">销量排序</a></li>
            <li class="_sort _sortPrice"><a href="javascript:void(0);" @click="sortType('price')"><i class="c01">价格排序</i></a></li>
            <li><a href="javascript:void(0);"><i class="c02">筛选</i></a></li>
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
    @include('layouts.footer_nav')
    <div class="stop"></div>
    <div class="cpflnr j-ccgg clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb">筛选</div>
            <div class="sxtitle">价格区间（元）</div>
            <ul class="sxjg lifl clear">
                <li><input type="text" name="text" placeholder="最低价"></li>
                <li><input type="text" name="text" placeholder="最高价"></li>
            </ul>
            <div class="sxtitle">产地</div>
            <ul class="cpsxccc lifl clear">
                <li v-for="production in productions">
                    <a class="on" href="#">@{{ production }}</a>
                </li>
            </ul>
        <div class="sxanniu clear"><input name="" type="button" value="确定"></div>
        </div>
    </div>
    <div class="search">
        <div class="sedm">
            <form action="{{url('shop_item/good_list')}}">
                <p class="fh j-close-search"></p>
                <div class="header clear">
                    <p class="hlbg fl"></p>
                    <p class="hrbg fl">
                        <input type="text" name="search" placeholder="搜索商品名称或品牌">
                    </p>
                </div>
                <p class="ssk">
                    <input type="submit" value="搜索">
                </p>
            </form>
        </div>
        <div class="seakuai">
            <div class="title">热门搜索</div>
            <ul class="selist lifl clear">
                <li v-for="search in searches">
                    <a :href="'{{url('shop_item/good_list').'?search='}}'+search">@{{ search }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
            var layerLoad = '';

            var shop_item_list = new Vue({
                el:'#shop_item_list',
                data:{
                    'shopItems':{!! $shopItem??'{}' !!},
                    'cart':{!! $cart??'{}' !!},
                    'catalogs':{!! $catalogs??'{}' !!},
                    'subCatalog':{!! $subCatalogs??'{}' !!},
                    'sortTypeStr': 'sell',
                    'currentCataHashid':0,
                    'searches':{!! $searches??'{}' !!},
                    'productions':{!! collect(\App\Models\ShopItem::$productions) !!}
                },
                methods:{
                    getShopItems:function(hashid){
                        $.get("{{url('shop_item/ajax_shop_item')}}", { hash_id: hashid,sortType: shop_item_list.sortTypeStr},
                            function(data){
                                layer.close(layerLoad);
                                if(data.stat){
                                    shop_item_list.shopItems = data.shopItems;
                                    shop_item_list.currentCataHashid = hashid;
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
                    sortType:function(type){
                        if(type == 'sell'){
                            shop_item_list.sortTypeStr = 'sell';
                            $('._sortSell').addClass('on').siblings('._sort').removeClass('on');
                        }else if(type == 'price'){
                            if(shop_item_list.sortTypeStr == 'priceDesc'){
                                shop_item_list.sortTypeStr = 'priceAsc';
                            }else{
                                shop_item_list.sortTypeStr = 'priceDesc';
                            }
                            $('._sortPrice').addClass('on').siblings('._sort').removeClass('on');
                        }
                        layerLoad = layer.load();
                        shop_item_list.getShopItems(shop_item_list.currentCataHashid);
                    }
                }
            });

    </script>
@endsection