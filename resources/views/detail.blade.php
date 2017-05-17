@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="item_detail">
  <p class="fhanniu"><a href="javascript:window.history.go(-1)"></a></p>
  <p class="fhsya"><a href="{{url('/')}}"></a></p>
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
                            <ul class="slides">
                                <template v-if="item.images">
                                <li v-for="image in item.images">
                                    <img :src="'{{url('upload').'/'}}'+image"/>
                                </li>
                                </template>
                                <template v-else>
                                    <li><img :src="'{{url('upload').'/'}}'+item.img"/></li>
                                </template>
                            </ul>
                    </div>
                </section>
            </div>
            <div class="xsqg">
      <div class="time clear">
      <p class="name fl">距开始：</p>
      <dl class="lifl fl clear">
        <dd><i>03</i><span>:</span></dd>
        <dd><i>03</i><span>:</span></dd>
        <dd><i>03</i></dd>
      </dl>
      </div>
      </div>
            <div class="detanrkuai">
                <div :class="is_collection?'dsc on':'dsc'" @click="addCollection(item.hashid)">
                    <p class="tu"></p>
                    <p class="nr">收藏</p>
                </div>
                <p class="name">@{{ item.title }}</p>
                <p class="jiage">¥ @{{ item.price }}元<span>秒杀价：¥500.0元</span></p>
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
                <p class="kuaidi"><span class="fr">销量：@{{ item.sellcount_real+item.sellcount_false }}笔</span>快递：{{$postage}}</p>
            </div>
            <ul class="detalist lifl clear">
                <li>正品保证</li>
                <li>极速达</li>
                <li>正品保证</li>
            </ul>
            <div class="detasppjnr">
                <div class="title">商品评价（{{$commentCount}}）
                    <dl class="lifl fr clear" v-for="star in itemStar">
                        <dd></dd>
                    </dl>
                    <i class="fr">@{{ itemStar }}</i> </div>
                <ul class="lifl clear" v-for="(comment,index) in comments">
                    <li v-if="index < 1">
                        <div class="debtkuai">
                            <dl class="lifl fr clear" v-for="star in comment.pivot.star">
                                <dd></dd>
                            </dl>
                            <p class="tu fl"><img :src="comment.headimage?comment.headimage:'{{ asset('/packages/admin/AdminLTE/dist/img/user2-160x160.jpg') }}'"/></p>
                            <p class="name">@{{ comment.name }}</p>
                        </div>
                        <div class="depjnr">@{{ comment.pivot.content }}</div>
                        <template v-if="comment.pivot.images">
                            <dl id="gallery" class="detulist lifl clear" v-for="image in comment.pivot.images">
                                <dd><a :href="image"><img :src="image"/></a></dd>
                            </dl>
                        </template>
                        <p class="time">@{{ comment.pivot.create_at }}</p>
                    </li>
                </ul>
                <div class="demore">查看更多评论</div>
            </div>
            <div class="ccdetasppjnr">
                <div class="title">商品详情</div>
                <div class="detailxqnr" v-html="item.detail"></div>
            </div>
        </div>
        <div class="box">
            <div class="ccdetasppjnr m_top88">
                <div class="title">商品详情</div>
                <div class="detailxqnr" v-html="item.detail"></div>
            </div>
        </div>
        <div class="box">
            <div class="detasppjnr m_top88">
                <div class="title">商品评价（{{$commentCount}}）
                    <dl class="lifl fr clear" v-for="star in itemStar">
                        <dd></dd>
                    </dl>
                    <i class="fr">@{{ itemStar }}</i> </div>
                <ul class="lifl clear" v-for="(comment,index) in comments">
                    <li>
                        <div class="debtkuai">
                            <dl class="lifl fr clear" v-for="star in comment.pivot.star">
                                <dd></dd>
                            </dl>
                            <p class="tu fl"><img :src="comment.headimage?comment.headimage:'{{ asset('/packages/admin/AdminLTE/dist/img/user2-160x160.jpg') }}'"/></p>
                            <p class="name">@{{ comment.name }}</p>
                        </div>
                        <div class="depjnr">@{{ comment.pivot.content }}</div>
                        <template v-if="comment.pivot.images">
                            <dl id="gallery" class="detulist lifl clear" v-for="image in comment.pivot.images">
                                <dd><a :href="image"><img :src="image"/></a></dd>
                            </dl>
                        </template>
                        <p class="time">@{{ comment.pivot.create_at }}</p>
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
            <li><a href="{{url('cart/list')}}"> <i>@{{ cart.cart_count }}</i>
                    <p class="tu2"></p>
                    <p class="name">购物车</p>
                </a></li>
            <li class="dc01"><a @click="addCart(item.hashid)" href="javascript:void(0);">加入购物车</a></li>
            <li class="dc02"><a href="{{url('cart/submitCartQuick/'.'?shop_item_id='.$item->id.'&qty=1')}}">立即购买</a></li>
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
                'cart':{!! $cart??'{}' !!},
                'comments':{!! $comments??'{}' !!},
                'itemStar':{!! $itemStar??'{}' !!},
                'is_collection':{!! $is_collection??'""' !!},
            },
            methods:{
                addCart:function(hashid){
                    $.ajax({
                        type: "GET",
                        url: "{{ url('cart/add') }}",
                        data: "qty=1&hash_id="+hashid,
                        success: function(data){
                            if(data.stat == 1){
                                item_detail.cart.cart_count = data.cart_count;
                            }else{
                                layer.msg('添加购物车失败');
                            }
                        }
                    });
                },
                addCollection:function(hashid){
                    if(this.is_collection){
                        layer.msg('您已收藏过该商品');
                        return;
                    }
                    $.ajax({
                        type: "GET",
                        url: "{{ url('user/addCollection') }}",
                        data: "hash_id="+hashid,
                        success: function(data){
                            if(data.stat == 1){
                                item_detail.is_collection = 1;

                            }
                            layer.msg(data.msg);
                        }
                    });
                }
            }
        });



        function tabs(tabTit,on,tabCon){
            $(tabCon).each(function(){
                $(this).children().eq(0).show();
            });
            $(tabTit).each(function(){
                $(this).children().eq(0).addClass(on);
            });
            $(tabTit).children().click(function(){
                $(this).addClass(on).siblings().removeClass(on);
                var index = $(tabTit).children().index(this);
                $(tabCon).children().eq(index).show().siblings().hide();
            });
        }

        tabs(".tab-hd,","active",".tab-bd");

        $(function(){
            $('#thumbs a').touchTouch();
            $('.f02').addClass('on');
        });
    </script>
@endsection