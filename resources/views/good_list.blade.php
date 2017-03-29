@extends('layouts.app')

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
    <div class="cpkuai clear">
        <div class="cpfl fmyh" id="sidebar">
            <div class="cpside scrollbar-none">
                <ul v-for="cata in catalogs" class="fmyh lifl clear">
                    <li :class="'top_catalogs _cata_'+cata.hashid">
                        <p class="name" @click="sidebar(cata.hashid)">@{{ cata.title }}</p>
                    </li>
                </ul>
            </div>
            <div v-for="catalog in catalogs">
                <dl :class="'j-content lifl clear _catalog_'+catalog.hashid" v-for="attr in catalog.attr">
                    <dd><a href="#">@{{ attr.title }}</a></dd>
                </dl>
            </div>
        </div>
        <div class="cpmain">
            <ul class="cplist fmyh lifl clear">
                <li><a href="#">
                        <p class="tu fl"><img src="images/img1.jpg"></p>
                        <p class="name">鱼香肉丝</p>
                        <p class="nr">湖北省政府的可信数据交易市场立足湖北，辐射全国，开启"数据消费经</p>
                        <p class="time">价格:<span>￥2.2元/500g</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" value="1"/>
                            <input class="add" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
                <li><a href="#">
                        <p class="tu fl"><img src="images/img1.jpg"></p>
                        <p class="name">鱼香肉丝</p>
                        <p class="nr">湖北省政府的可信数据交易市场立足湖北，辐射全国，开启"数据消费经</p>
                        <p class="time">价格:<span>￥2.2元/500g</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" value="1"/>
                            <input class="add" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
                <li><a href="#">
                        <p class="tu fl"><img src="images/img1.jpg"></p>
                        <p class="name">鱼香肉丝</p>
                        <p class="nr">湖北省政府的可信数据交易市场立足湖北，辐射全国，开启"数据消费经</p>
                        <p class="time">价格:<span>￥2.2元/500g</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" value="1"/>
                            <input class="add" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
                <li><a href="#">
                        <p class="tu fl"><img src="images/img1.jpg"></p>
                        <p class="name">鱼香肉丝</p>
                        <p class="nr">湖北省政府的可信数据交易市场立足湖北，辐射全国，开启"数据消费经</p>
                        <p class="time">价格:<span>￥2.2元/500g</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" value="1"/>
                            <input class="add" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
                <li><a href="#">
                        <p class="tu fl"><img src="images/img1.jpg"></p>
                        <p class="name">鱼香肉丝</p>
                        <p class="nr">湖北省政府的可信数据交易市场立足湖北，辐射全国，开启"数据消费经</p>
                        <p class="time">价格:<span>￥2.2元/500g</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" value="1"/>
                            <input class="add" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
                <li><a href="#">
                        <p class="tu fl"><img src="images/img1.jpg"></p>
                        <p class="name">鱼香肉丝</p>
                        <p class="nr">湖北省政府的可信数据交易市场立足湖北，辐射全国，开启"数据消费经</p>
                        <p class="time">价格:<span>￥2.2元/500g</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" value="1"/>
                            <input class="add" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
                <li><a href="#">
                        <p class="tu fl"><img src="images/img1.jpg"></p>
                        <p class="name">鱼香肉丝</p>
                        <p class="nr">湖北省政府的可信数据交易市场立足湖北，辐射全国，开启"数据消费经</p>
                        <p class="time">价格:<span>￥2.2元/500g</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" value="1"/>
                            <input class="add" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
                <li><a href="#">
                        <p class="tu fl"><img src="images/img1.jpg"></p>
                        <p class="name">鱼香肉丝</p>
                        <p class="nr">湖北省政府的可信数据交易市场立足湖北，辐射全国，开启"数据消费经</p>
                        <p class="time">价格:<span>￥2.2元/500g</span></p>
                    </a>
                    <div class="sla">
                        <p class="name fl">选择数量：</p>
                        <div class="gwsl fl">
                            <input class="min" name="" type="button" value="-"/>
                            <input class="text_box" name="" type="text" value="1"/>
                            <input class="add" name="" type="button" value="+"/>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="cpanniu fmyh clear" id="shop_item_cart"> 合计：<i>100</i>元
        <p class="anniu fr">
            <input name="" type="button" value="选好了">
        </p>
    </div>
    <script>
        var catalog_sidebar = new Vue({
            el:'#sidebar',
            data:{
                'catalogs':{!! $catalogs??'{}' !!}
            },
            methods:{
                sidebar:function(hashid){
                    $('.top_catalogs').removeClass('active');
                    $('.j-content').hide();
                    $('._cata_'+hashid).addClass('active');
                    $('._catalog_'+hashid).show();
                }
            }
        });

        var vue_shop_item_cart = new Vue({  //用于列表页的价钱显示
            el:'#shop_item_cart',
            data:{
                cart_count_price : {!! \Cart::total() !!}
            },
        });

        $(function(){

        });
    </script>
@endsection