@extends('layouts.app')

@section('content')
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
            <li><a href="#">
                    <p class="tu"></p>
                    <p class="name">白酒</p>
                </a></li>
            <li><a href="#">
                    <p class="tu1"></p>
                    <p class="name">葡萄酒</p>
                </a></li>
            <li><a href="#">
                    <p class="tu2"></p>
                    <p class="name">优惠券</p>
                </a></li>
            <li><a href="#">
                    <p class="tu3"></p>
                    <p class="name">啤酒</p>
                </a></li>
            <li><a href="#">
                    <p class="tu4"></p>
                    <p class="name">洋酒</p>
                </a></li>
        </ul>
        <div class="fdm1 clear">
            <div class="seckill fl">
                <p class="title"></p>
                <p class="time"><img src="images/img1.jpg" /></p>
                <ul class="lifl clear">
                    <li><a href="#"><img src="images/img2.jpg" />
                            <p class="name">秒杀<i>108元</i></p>
                        </a></li>
                    <li><a href="#"><img src="images/img2.jpg" />
                            <p class="name">秒杀<i>108元</i></p>
                        </a></li>
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
                    <li class="swiper-slide"><a href="#">
                            <p class="w1">推<br/>
                                荐</p>
                            <p class="tu"><img src="images/img4.jpg"/></p>
                            <p class="name">¥398.0元<i>¥1980.0元</i></p>
                        </a></li>
                    <li class="swiper-slide"><a href="#">
                            <p class="w2">爆<br/>
                                款</p>
                            <p class="tu"><img src="images/img4.jpg"/></p>
                            <p class="name">¥398.0元<i>¥1980.0元</i></p>
                        </a></li>
                    <li class="swiper-slide"><a href="#">
                            <p class="w1">推<br/>
                                荐</p>
                            <p class="tu"><img src="images/img4.jpg"/></p>
                            <p class="name">¥398.0元<i>¥1980.0元</i></p>
                        </a></li>
                    <li class="swiper-slide"><a href="#">
                            <p class="w1">推<br/>
                                荐</p>
                            <p class="tu"><img src="images/img4.jpg"/></p>
                            <p class="name">¥398.0元<i>¥1980.0元</i></p>
                        </a></li>
                    <li class="swiper-slide"><a href="#">
                            <p class="w1">推<br/>
                                荐</p>
                            <p class="tu"><img src="images/img4.jpg"/></p>
                            <p class="name">¥398.0元<i>¥1980.0元</i></p>
                        </a></li>
                    <li class="swiper-slide"><a href="#">
                            <p class="w1">推<br/>
                                荐</p>
                            <p class="tu"><img src="images/img4.jpg"/></p>
                            <p class="name">¥398.0元<i>¥1980.0元</i></p>
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="farea">
            <div class="title"></div>
            <div class="cont clear">
                <div class="fak1 fl"> <a href="#">
                        <p class="bt"></p>
                        <p class="tu"><img src="images/img5.jpg"/></p>
                    </a> </div>
                <div class="faknr fr">
                    <div class="fak2"> <a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img6.jpg"/></p>
                        </a> </div>
                    <div class="fak3 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img7.jpg"/></p>
                        </a> </div>
                    <div class="fak4 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img8.jpg"/></p>
                        </a> </div>
                </div>
            </div>
            <ul class="falist lifl clear">
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">五粮液</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">五粮液</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
            </ul>
        </div>
        <div class="farea farea1">
            <div class="title"></div>
            <div class="cont clear">
                <div class="fak1 fl"> <a href="#">
                        <p class="bt"></p>
                        <p class="tu"><img src="images/img5.jpg"/></p>
                    </a> </div>
                <div class="faknr fr">
                    <div class="fak2"> <a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img6.jpg"/></p>
                        </a> </div>
                    <div class="fak3 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img7.jpg"/></p>
                        </a> </div>
                    <div class="fak4 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img8.jpg"/></p>
                        </a> </div>
                </div>
            </div>
            <ul class="falist lifl clear">
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">五粮液</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">五粮液</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
            </ul>
        </div>
        <div class="farea farea2">
            <div class="title"></div>
            <div class="cont clear">
                <div class="fak1 fl"> <a href="#">
                        <p class="bt"></p>
                        <p class="tu"><img src="images/img5.jpg"/></p>
                    </a> </div>
                <div class="faknr fr">
                    <div class="fak2"> <a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img6.jpg"/></p>
                        </a> </div>
                    <div class="fak3 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img7.jpg"/></p>
                        </a> </div>
                    <div class="fak4 fl"><a href="#">
                            <p class="bt"></p>
                            <p class="tu fr"><img src="images/img8.jpg"/></p>
                        </a> </div>
                </div>
            </div>
            <ul class="falist lifl clear">
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">五粮液</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">五粮液</p>
                    </a></li>
                <li><a href="#">
                        <p class="tu"><img src="images/img9.jpg"/></p>
                        <p class="name">茅台</p>
                    </a></li>
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
                        <li><a href="#">
                                <p class="tu"><img src="images/img10.jpg" /></p>
                                <p class="name">1法国拉菲传奇波尔多红酒葡萄酒750ml</p>
                                <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                                <ins class="c1"></ins> </a></li>
                        <li><a href="#">
                                <p class="tu"><img src="images/img10.jpg" /></p>
                                <p class="name">法国拉菲传奇波尔多红酒葡萄酒750ml</p>
                                <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                                <ins class="c2"></ins> </a></li>
                        <li><a href="#">
                                <p class="tu"><img src="images/img10.jpg" /></p>
                                <p class="name">法国拉菲传奇波尔多红酒葡萄酒750ml</p>
                                <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                                <ins class="c2"></ins> </a></li>
                        <li><a href="#">
                                <p class="tu"><img src="images/img10.jpg" /></p>
                                <p class="name">法国拉菲传奇波尔多红酒葡萄酒750ml</p>
                                <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                                <ins class="c1"></ins> </a></li>
                    </ul>
                </div>
                <div class="box">
                    <ul class="cplist lifl clear">
                        <li><a href="#">
                                <p class="tu"><img src="images/img10.jpg" /></p>
                                <p class="name">2法国拉菲传奇波尔多红酒葡萄酒750ml</p>
                                <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                                <ins class="c1"></ins> </a></li>
                        <li><a href="#">
                                <p class="tu"><img src="images/img10.jpg" /></p>
                                <p class="name">法国拉菲传奇波尔多红酒葡萄酒750ml</p>
                                <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                                <ins class="c2"></ins> </a></li>
                        <li><a href="#">
                                <p class="tu"><img src="images/img10.jpg" /></p>
                                <p class="name">法国拉菲传奇波尔多红酒葡萄酒750ml</p>
                                <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                                <ins class="c2"></ins> </a></li>
                        <li><a href="#">
                                <p class="tu"><img src="images/img10.jpg" /></p>
                                <p class="name">法国拉菲传奇波尔多红酒葡萄酒750ml</p>
                                <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                                <ins class="c1"></ins> </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="footer fmyh lifl clear">
            <li class="f01 on"><a href="index.asp">
                    <p class="tu"></p>
                    <p class="name">首页</p>
                </a></li>
            <li class="f02"><a href="{{url('shop_item/good_list')}}">
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

@endsection