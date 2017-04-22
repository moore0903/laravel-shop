@extends('layouts.app')

@section('content')
<div class="wrap fmyh">
    <div class="cpdm clear">
        <div class="header j-search-input">
            <p class="hlbg fl"></p>
            <p class="hrbg fl">
                <input type="button" name="" value="搜索商品名称或品牌">
            </p>
        </div>
        <ul class="cpfllist lifl clear">
            <li class="on"><a href="#1">白酒</a></li>
            <li><a href="#1">葡萄酒</a></li>
            <li><a href="#1">洋酒</a></li>
            <li><a href="#1">啤酒</a></li>
            <li><a href="#1">黄酒</a></li>
            <li><a href="#1">保健酒</a></li>
            <li><a href="#1">酒具</a></li>
            <li><a href="#1">饮料</a></li>
        </ul>
        <ul class="cpsxlist lifl clear">
            <li class="on"><a href="javascript:;">销量排序</a></li>
            <li><a href="javascript:;"><i class="c01">价格排序</i></a></li>
            <li><a href="javascript:;"><i class="c02">筛选</i></a></li>
        </ul>
    </div>
    <aside>
        <div class="menu-left scrollbar-none" id="sidebar">
            <ul>
                <li class="active">全部</li>
                <li>茅台</li>
                <li>五粮液</li>
                <li>国窖</li>
                <li>汾酒</li>
                <li>浏阳河</li>
                <li>四特酒</li>
                <li>洋河</li>
                <li>泸州老窖</li>
            </ul>
        </div>
    </aside>
    <section class="menu-right padding-all scrollbar-none j-content">
        <ul class="lifl clear">
            @foreach($shopItem as $item)
            <li><a href="{{url('/shopItem/detail/').'/'.\Hashids::encode($item->id)}}">
                    <p class="tu"><img src="{{asset('upload/').'/'.$item->img}}"/></p>
                    <p class="name">{{$item->title}}</p>
                    <p class="jige"><i class="fr">¥{{$item->original_price}}元</i>¥{{$item->price}}元</p>
                </a></li>
            @endforeach
        </ul>
    </section>
    <section class="menu-right padding-all scrollbar-none j-content" style="display:none;">
        <ul class="lifl clear">
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
        </ul>
    </section>
    <section class="menu-right padding-all scrollbar-none j-content" style="display:none;">
        <ul class="lifl clear">
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
        </ul>
    </section>
    <section class="menu-right padding-all scrollbar-none j-content" style="display:none;">
        <ul class="lifl clear">
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
        </ul>
    </section>
    <section class="menu-right padding-all scrollbar-none j-content" style="display:none;">
        <ul class="lifl clear">
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
        </ul>
    </section>
    <section class="menu-right padding-all scrollbar-none j-content" style="display:none;">
        <ul class="lifl clear">
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
        </ul>
    </section>
    <section class="menu-right padding-all scrollbar-none j-content" style="display:none;">
        <ul class="lifl clear">
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
        </ul>
    </section>
    <section class="menu-right padding-all scrollbar-none j-content" style="display:none;">
        <ul class="lifl clear">
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
        </ul>
    </section>
    <section class="menu-right padding-all scrollbar-none j-content" style="display:none;">
        <ul class="lifl clear">
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
            <li><a href="#">
                    <p class="tu"><img src="images/img11.jpg"/></p>
                    <p class="name">52度五粮国宾酒尊品限量500ml</p>
                    <p class="jige"><i class="fr">¥1980.0元</i>¥608.0元</p>
                </a></li>
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
    <div class="cpflnr j-cpfl clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb"></p>品牌</div>
            <ul class="cplbylist lifl clear">
                <li><a href="#">八月桂花香四川1</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
            </ul>
        </div>
    </div>
    <div class="cpflnr j-cpfl clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb"></p>品牌</div>
            <ul class="cplbylist lifl clear">
                <li><a href="#">八月桂花香四川2</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
            </ul>
        </div>
    </div>
    <div class="cpflnr j-cpfl clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb"></p>品牌</div>
            <ul class="cplbylist lifl clear">
                <li><a href="#">八月桂花香四川3</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
            </ul>
        </div>
    </div>
    <div class="cpflnr j-cpfl clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb"></p>品牌</div>
            <ul class="cplbylist lifl clear">
                <li><a href="#">八月桂花香四川4</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
            </ul>
        </div>
    </div>
    <div class="cpflnr j-cpfl clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb"></p>品牌</div>
            <ul class="cplbylist lifl clear">
                <li><a href="#">八月桂花香四川5</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
            </ul>
        </div>
    </div>
    <div class="cpflnr j-cpfl clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb"></p>品牌</div>
            <ul class="cplbylist lifl clear">
                <li><a href="#">八月桂花香四川6</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
            </ul>
        </div>
    </div>
    <div class="cpflnr j-cpfl clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb"></p>品牌</div>
            <ul class="cplbylist lifl clear">
                <li><a href="#">八月桂花香四川7</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
            </ul>
        </div>
    </div>
    <div class="cpflnr j-cpfl clear">
        <div class="saixuan scrollbar-none fr">
            <div class="sxbt"><p class="gb"></p>品牌</div>
            <ul class="cplbylist lifl clear">
                <li><a href="#">八月桂花香四川8</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
                <li><a href="#">八月桂花香四川</a></li>
            </ul>
        </div>
    </div>
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
            $('#sidebar ul li').click(function(){
                $(this).addClass('active').siblings('li').removeClass('active');
                var index = $(this).index();
                $('.j-content').eq(index).show().siblings('.j-content').hide();
            })
        })
    </script>
@endsection