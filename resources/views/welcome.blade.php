@extends('layouts.app')

@section('content')
    <script src="{{ asset('/packages/moment/moment.js')}}"></script>
    <div class="wrap fmyh">
        <div class="fdm clear">
            <div class="header j-search-input">
                <p class="hlbg fl"></p>
                <p class="hrbg fl">
                    <input type="button" name="" value="请输入您搜索的关键词！">
                </p>
            </div>
        </div>
        <div class="banner">
            <section class="slider">
                <div class="flexslider">
                    <ul class="slides">
                        <li><img src="images/banner.jpg"></li>
                        <li><img src="images/banner.jpg"></li>
                        <li><img src="images/banner.jpg"></li>
                        <li><img src="images/banner.jpg"></li>
                    </ul>
                </div>
            </section>
        </div>
        <ul class="navlist lifl clear">
            <li><a href="{{url('shop_item/good_list').'?catalog_id='.\Hashids::encode(1)}}">
                    <p class="tu"></p>
                    <p class="name">白酒</p>
                </a></li>
            <li><a href="{{url('shop_item/good_list').'?catalog_id='.\Hashids::encode(2)}}">
                    <p class="tu1"></p>
                    <p class="name">葡萄酒</p>
                </a></li>
            <li><a href="{{url('gift/available')}}">
                    <p class="tu2"></p>
                    <p class="name">优惠券</p>
                </a></li>
            <li><a href="{{url('shop_item/good_list').'?catalog_id='.\Hashids::encode(6)}}">
                    <p class="tu3"></p>
                    <p class="name">啤酒</p>
                </a></li>
            <li><a href="{{url('shop_item/good_list').'?catalog_id='.\Hashids::encode(5)}}">
                    <p class="tu4"></p>
                    <p class="name">洋酒</p>
                </a></li>
        </ul>
        <script>
            function countdown(start_time, end_time) {
                var t = end_time - start_time;
                var d = 0;
                var h = 0;
                var m = 0;
                var s = 0;
                if (t >= 0) {
                    d = Math.floor(t / 1000 / 60 / 60 / 24);
                    h = Math.floor((t / 1000 / 60 / 60 % 24) + (d * 24));
                    m = Math.floor(t / 1000 / 60 % 60);
                    s = Math.floor(t / 1000 % 60);
                }
                if (h < 10) h = '0' + h;
                if (m < 10) m = '0' + m;
                if (s < 10) s = '0' + s;
                return '<dd><i>' + h + '</i><span>:</span></dd><dd><i>' + m + '</i><span>:</span></dd><dd><i>' + s + '</i></dd>';
            }
        </script>
        <div class="fdm1 clear">
            <div class="seckill fl">
                <p class="title"></p>
                <div class="time clear _sec_kill_countdown_0" style="display: none;">
                    <p class="name fl">距结束：</p>
                    <dl class="lifl fl clear">
                        <dd><i>03</i><span>:</span></dd>
                        <dd><i>03</i><span>:</span></dd>
                        <dd><i>03</i></dd>
                    </dl>
                </div>
                <div class="time1 clear _sec_kill_countdown_1" style="display: none;">
                    <p class="name fl">距结束：</p>
                    <dl class="lifl fl clear">
                        <dd><i>03</i><span>:</span></dd>
                        <dd><i>03</i><span>:</span></dd>
                        <dd><i>03</i></dd>
                    </dl>
                </div>
                <ul class="lifl clear">
                    @foreach(\App\Models\SecKill::getSecKill(2) as $key => $item)
                        <li data-sec_kill_countdown_name="">
                            <a href="{{url('shop_item/detail/'.\Hashids::encode($item->shopItem->id))}}">
                                <img src="{{asset('upload/'.$item->shopItem->img)}}" width="241" height="207"/>
                                <p class="name">秒杀<i>{{$item->sec_kill_price}}</i></p>
                                <span style="display: none;" class="_sec_kill"></span>
                            </a>
                        </li>
                        <script>
                            function sec_kill_countdown(sec_kill_name, end_time) {
                                var sec_kill = $('.' + sec_kill_name);
                                countdown_timer = setInterval(function () {
                                    if (moment() - moment(end_time) >= 0) {
                                        clearInterval(countdown_timer);
                                        sec_kill.hide();
                                    } else {
                                        sec_kill.show();
                                        sec_kill.find('.lifl').html(countdown(moment(), moment(end_time)));
                                    }
                                }, 1000);
                            }

                            @if($key == 0) sec_kill_countdown('_sec_kill_countdown_1','{{$item->end_time}}'); @else sec_kill_countdown('_sec_kill_countdown_0','{{$item->end_time}}'); @endif
                        </script>
                    @endforeach
                </ul>
            </div>
            <div class="coupons fr">
                <p class="title"></p>
                <div class="cont"><a href="{{url('gift/available')}}"></a></div>
            </div>
        </div>
        <div class="fdm2"><a href="#"><img src="images/img3.jpg"/></a></div>
        <div class="tjcp">
            <div class="title"><span class="fr"><a href="#"></a></span>商品推荐</div>
            <div class="swiper-container">
                <ul class="swiper-wrapper">
                    @foreach(\App\Models\ShopItem::shopItemList(0,true,false,6) as $item)
                        <li class="swiper-slide"><a href="{{url('shop_item/detail/'.\Hashids::encode($item->id))}}">
                                <p class="w1">推<br/>
                                    荐</p>
                                <p class="tu"><img src="{{asset('upload/'.$item->img)}}"/></p>
                                <p class="name">¥{{$item->price}}元<i>¥{{$item->original_price}}元</i></p>
                            </a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="farea">
            <div class="title"></div>
            <div class="cont clear">
                <div class="fak1 fl"><a href="#">
                        <p class="bt"></p>
                        <p class="tu"><img src="images/img5.jpg"/></p>
                    </a></div>
                <div class="faknr fr">
                    <div class="fak2"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img6.jpg"/></p>
                        </a></div>
                    <div class="fak3 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img7.jpg"/></p>
                        </a></div>
                    <div class="fak4 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img8.jpg"/></p>
                        </a></div>
                </div>
            </div>
            <ul class="falist lifl clear">
                @foreach(\App\Models\Catalog::parentCatalog(1,5) as $catalog)
                    <li><a href="{{url('shop_item/good_list').'?catalog_id='.\Hashids::encode($catalog->id)}}">
                            <p class="tu"><img width="105" src="{{asset('upload/'.$catalog->img)}}"/></p>
                            <p class="name">{{$catalog->title}}</p>
                        </a></li>
                @endforeach
            </ul>
        </div>
        <div class="farea farea1">
            <div class="title"></div>
            <div class="cont clear">
                <div class="fak1 fl"><a href="#">
                        <p class="bt"></p>
                        <p class="tu"><img src="images/img5.jpg"/></p>
                    </a></div>
                <div class="faknr fr">
                    <div class="fak2"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img6.jpg"/></p>
                        </a></div>
                    <div class="fak3 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img7.jpg"/></p>
                        </a></div>
                    <div class="fak4 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img8.jpg"/></p>
                        </a></div>
                </div>
            </div>
            <ul class="falist lifl clear">
                @foreach(\App\Models\Catalog::parentCatalog(2,5) as $catalog)
                    <li><a href="{{url('shop_item/good_list').'?catalog_id='.\Hashids::encode($catalog->id)}}">
                            <p class="tu"><img width="105" src="{{asset('upload/'.$catalog->img)}}"/></p>
                            <p class="name">{{$catalog->title}}</p>
                        </a></li>
                @endforeach
            </ul>
        </div>
        <div class="farea farea2">
            <div class="title"></div>
            <div class="cont clear">
                <div class="fak1 fl"><a href="#">
                        <p class="bt"></p>
                        <p class="tu"><img src="images/img5.jpg"/></p>
                    </a></div>
                <div class="faknr fr">
                    <div class="fak2"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img6.jpg"/></p>
                        </a></div>
                    <div class="fak3 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img7.jpg"/></p>
                        </a></div>
                    <div class="fak4 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img8.jpg"/></p>
                        </a></div>
                </div>
            </div>
            <ul class="falist lifl clear">
                @foreach(\App\Models\Catalog::parentCatalog(5,5) as $catalog)
                    <li><a href="{{url('shop_item/good_list').'?catalog_id='.\Hashids::encode($catalog->id)}}">
                            <p class="tu"><img width="105" src="{{asset('upload/'.$catalog->img)}}"/></p>
                            <p class="name">{{$catalog->title}}</p>
                        </a></li>
                @endforeach
            </ul>
        </div>
        <div class="cplove">
            <ul class="cptitle lifl clear tab-hd">
                <li><i>猜你喜欢</i></li>
                <li><i class="c1">爆款专区</i></li>
            </ul>
            <div class="cpcont tab-bd">
                <div class="box">
                    <ul class="cplist lifl clear">
                        @foreach(\App\Models\ShopItem::like(12) as $item)
                            <li><a href="{{url('shop_item/detail/'.\Hashids::encode($item->id))}}">
                                    <p class="tu"><img width="374" height="342" src="{{asset('upload/'.$item->img)}}"/>
                                    </p>
                                    <p class="name">{{$item->title}}</p>
                                    <p class="jige"><i class="fr">¥{{$item->original_price}}元</i>¥{{$item->price}}元</p>
                                    <ins class="c1"></ins>
                                </a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="box">
                    <ul class="cplist lifl clear">
                        @foreach(\App\Models\ShopItem::sellCountOrder(12) as $item)
                            <li><a href="{{url('shop_item/detail/'.\Hashids::encode($item->id))}}">
                                    <p class="tu"><img width="374" height="342" src="{{asset('upload/'.$item->img)}}"/>
                                    </p>
                                    <p class="name">{{$item->title}}</p>
                                    <p class="jige"><i class="fr">¥{{$item->original_price}}元</i>¥{{$item->price}}元</p>
                                    <ins class="c1"></ins>
                                </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @include('layouts.footer_nav')
        <div class="stop"></div>
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
                    <?php
                    $configs = \App\Models\Config::all();
                    $search_key = $configs->where('key', 'search_key')->first();
                    $searches = [];
                    if (!empty($search_key)) $searches = explode(',', $search_key->value);
                    ?>
                    @foreach($searches as $search)
                        <li>
                            <a href="{{url('shop_item/good_list').'?search='.$search}}">{{ $search }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>


        function tabs(tabTit, on, tabCon) {
            $(tabCon).each(function () {
                $(this).children().eq(0).show();
            });
            $(tabTit).each(function () {
                $(this).children().eq(0).addClass(on);
            });
            $(tabTit).children().click(function () {
                $(this).addClass(on).siblings().removeClass(on);
                var index = $(tabTit).children().index(this);
                $(tabCon).children().eq(index).show().siblings().hide();
            });
        }

        tabs(".tab-hd,", "active", ".tab-bd");

        $('.f01').addClass('on');
    </script>
@endsection