@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="item_detail">
    <ul class="detailstitle tab-hd lifl clear">
        <li>商品</li>
        <li>详情</li>
        <li>评价</li>
    </ul>
    <div class="detailscont tab-bd">
        <div class="box">
            <div class="nbanner">
                <section class="slider">
                    <div class="flexslider">
                        <ul v-for="image in item.images" class="slides">
                            <li><img :src="'{{url('upload').'/'}}'+image"/></li>
                        </ul>
                    </div>
                </section>
            </div>
            <div class="detanrkuai">
                <div class="dsc">
                    <p class="tu"></p>
                    <p class="nr">收藏</p>
                </div>
                <p class="name">@{{ item.title }}</p>
                <p class="jiage">¥ @{{ item.price }}元<i>¥ @{{ item.original_price }}元</i></p>
                <?php
                $configs = \App\Models\Config::all();
                $post_price = $configs->where('key','post_price')->first();
                $include_postage = $configs->where('key','include_postage')->first();
                $postage =  '免运费';
                if(!empty($post_price)){
                    $post_price = '运费'.$post_price->value.'元   ';
                    if(!empty($include_postage)){
                        $post_price .= '满'.$include_postage->value.'包邮';
                    }
                }
                ?>
                <p class="kuaidi"><span class="fr">销量：1002笔</span>快递：{{$postage}}</p>
            </div>
            <ul class="detalist lifl clear">
                <li>正品保证</li>
                <li>极速达</li>
                <li>正品保证</li>
            </ul>
            <div class="detasppjnr">
                <div class="title">商品评价（215）
                    <dl class="lifl fr clear">
                        <dd></dd>
                        <dd></dd>
                        <dd></dd>
                        <dd></dd>
                        <dd></dd>
                    </dl>
                    <i class="fr">5.0</i> </div>
                <ul class="lifl clear">
                    <li>
                        <div class="debtkuai">
                            <dl class="lifl fr clear">
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                            </dl>
                            <p class="tu fl"><img src="images/img27.jpg"/></p>
                            <p class="name">小蜜蜂9214</p>
                        </div>
                        <div class="depjnr">酒是正品，而且发货速度超级快，客服态度非常好一直在耐心解答我的问题.</div>
                        <dl id="gallery" class="detulist lifl clear">
                            <dd><a href="images/img25.jpg"><img src="images/img24.jpg"/></a></dd>
                            <dd><a href="images/img25.jpg"><img src="images/img24.jpg"/></a></dd>
                        </dl>
                        <p class="time">2017-03-09 14:02</p>
                    </li>
                </ul>
                <div class="demore">查看更多评论</div>
            </div>
            <div class="ccdetasppjnr">
                <div class="title">商品详情</div>
                <div class="detailxqnr">@{{ item.detail }}</div>
            </div>
        </div>
        <div class="box">
            <div class="ccdetasppjnr m_top88">
                <div class="title">商品详情</div>
                <div class="detailxqnr">@{{ item.detail }}</div>
            </div>
        </div>
        <div class="box">
            <div class="detasppjnr m_top88">
                <div class="title">商品评价（215）
                    <dl class="lifl fr clear">
                        <dd></dd>
                        <dd></dd>
                        <dd></dd>
                        <dd></dd>
                        <dd></dd>
                    </dl>
                    <i class="fr">5.0</i> </div>
                <ul class="lifl clear">
                    <li>
                        <div class="debtkuai">
                            <dl class="lifl fr clear">
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                            </dl>
                            <p class="tu fl"><img src="images/img27.jpg"/></p>
                            <p class="name">小蜜蜂9214</p>
                        </div>
                        <div class="depjnr">酒是正品，而且发货速度超级快，客服态度非常好一直在耐心解答我的问题.</div>
                        <dl id="gallery" class="detulist lifl clear">
                            <dd><a href="images/img20.jpg"><img src="images/img24.jpg"/></a></dd>
                            <dd><a href="images/img25.jpg"><img src="images/img24.jpg"/></a></dd>
                        </dl>
                        <p class="time">2017-03-09 14:02</p>
                    </li>
                    <li>
                        <div class="debtkuai">
                            <dl class="lifl fr clear">
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                            </dl>
                            <p class="tu fl"><img src="images/img27.jpg"/></p>
                            <p class="name">小蜜蜂9214</p>
                        </div>
                        <div class="depjnr">酒是正品，而且发货速度超级快，客服态度非常好一直在耐心解答我的问题.</div>
                        <dl id="gallery" class="detulist lifl clear">
                            <dd><a href="images/img25.jpg"><img src="images/img24.jpg"/></a></dd>
                            <dd><a href="images/img25.jpg"><img src="images/img24.jpg"/></a></dd>
                        </dl>
                        <p class="time">2017-03-09 14:02</p>
                    </li>
                    <li>
                        <div class="debtkuai">
                            <dl class="lifl fr clear">
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                            </dl>
                            <p class="tu fl"><img src="images/img27.jpg"/></p>
                            <p class="name">小蜜蜂9214</p>
                        </div>
                        <div class="depjnr">酒是正品，而且发货速度超级快，客服态度非常好一直在耐心解答我的问题.</div>
                        <dl id="gallery" class="detulist lifl clear">
                            <dd><a href="images/img25.jpg"><img src="images/img24.jpg"/></a></dd>
                            <dd><a href="images/img25.jpg"><img src="images/img24.jpg"/></a></dd>
                        </dl>
                        <p class="time">2017-03-09 14:02</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="dccfot">
        <ul class="dccfotlist lifl clear">
            <li><a href="#">
                    <p class="tu1"></p>
                    <p class="name">客服</p>
                </a></li>
            <li><a href="#"> <i>3</i>
                    <p class="tu2"></p>
                    <p class="name">购物车</p>
                </a></li>
            <li class="dc01"><a href="#">加入购物车</a></li>
            <li class="dc02"><a href="#">立即购买</a></li>
        </ul>
    </div>
    <div class="stop"></div>
</div>
@endsection

@section('script')
    <script>
        var item_detail = new Vue({
            el:'#item_detail',
            data:{
                'item':{!! $item??'{}' !!},
            },
            methods:{
                addCart:function(hashid){
                    $.ajax({
                        type: "GET",
                        url: "{{ url('cart/add') }}",
                        data: "qty=1&has_id="+hashid,
                        success: function(data){
                            if(data.stat == 1){
                                vue_shop_item_cart.cart_price_count = data.cart_price_count;
                            }else{
                                layer.msg('添加购物车失败');
                            }
                        }
                    });
                }
            }
        });

        $(function(){
            $('#thumbs a').touchTouch();
        });
    </script>
@endsection