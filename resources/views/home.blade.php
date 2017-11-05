@extends('layouts.app')


@section('content')
    <div class="fdm">
        <div class="banner scroll">
            <ul>
                <li><a href="#" style=" background:url({{ asset('images/banner.jpg') }}) no-repeat center top;"></a></li>
                <li><a href="#" style=" background:url({{ asset('images/banner.jpg') }}) no-repeat center top;"></a></li>
                <li><a href="#" style=" background:url({{ asset('images/banner.jpg') }}) no-repeat center top;"></a></li>
                <li><a href="#" style=" background:url({{ asset('images/banner.jpg') }}) no-repeat center top;"></a></li>
            </ul>
        </div>
        <ul class="pan lifl clear">
        </ul>
    </div>
    <div class="wrap fmyh">
        <div class="about mod">
            <p class="phone"></p>
            <div class="title"> 关于我们<i>中国采暖科技引领者，中国采暖产业领先品牌</i> </div>
            <div class="cont clear">
                <div class="tu"><img src="{{ asset('images/img1.jpg') }}" width="394" height="265"/></div>
                <h3>苏州温特斯顿新能源材料科技有限公司</h3>
                <p class="nr">温特斯顿-超导强热石墨烯地暖，由温特斯顿科技有限公司研发、生产、推广，温特斯顿科技有限公司是一家全球技术领先的专业从事低碳新能源领域，产品系统研发、制造与销售的高科技企业。
                    公司总部位于长三角核心城市之一苏州，生产基地位于苏州科技创业园，拥有数千平米的生产基地。公……</p>
                <ul class="ablist lifl clear">
                    <li class="abl1"><a href="#">企业实力</a></li>
                    <li class="abl2"><a href="#">企业荣誉</a></li>
                    <li class="abl3"><a href="#">企业规划</a></li>
                    <li class="abl4"><a href="#">企业风采</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="wrap fmyh">
        <div class="case">
            <div class="title">案例展示<i>地暖黑科技，温暖陪伴你</i> </div>
            <ul class="lifl clear">
                <li class="c1"><a href="#"><img src="{{ asset('images/img2.jpg') }}" width="269" height="186"/>
                        <div class="canr">
                            <p class="name">某新店开业装修某新店开业装修某新店开业装修</p>
                            <p class="nr">查看详情</p>
                        </div>
                    </a></li>
                <li class="c2"><a href="#"><img src="{{ asset('images/img2.jpg') }}" width="269" height="186"/>
                        <div class="canr">
                            <p class="name">某新店开业装修</p>
                            <p class="nr">查看详情</p>
                        </div>
                    </a></li>
                <li class="c3"><a href="#"><img src="{{ asset('images/img3.jpg') }}" width="596" height="413"/>
                        <div class="canr">
                            <p class="name">某新店开业装修某新店开业装修某新店开业装修某新店开业装修</p>
                            <p class="nr">查看详情</p>
                        </div>
                    </a></li>
                <li class="c4"><a href="#"><img src="{{ asset('images/img2.jpg') }}" width="269" height="186"/>
                        <div class="canr">
                            <p class="name">某新店开业装修</p>
                            <p class="nr">查看详情</p>
                        </div>
                    </a></li>
                <li class="c5"><a href="#"><img src="{{ asset('images/img2.jpg') }}" width="269" height="186"/>
                        <div class="canr">
                            <p class="name">某新店开业装修</p>
                            <p class="nr">查看详情</p>
                        </div>
                    </a></li>
            </ul>
        </div>
    </div>
    <div class="wrap fmyh">
        <div class="news">
            <div class="title">新闻资讯<i>科研精英+营销大师+明星代言 强兵强将强强集合  超强战队所向披靡</i> </div>
            <div class="cont clear">
                <div class="nwlbg fl"> <a href="#">
                        <div class="tu"><img src="{{ asset('images/img4.jpg') }}"/></div>
                        <p class="name clear"><i class="fr">2017/10/13</i>照顾好家人的身体健康，从温特斯顿地暖开始！</p>
                        <p class="nr">在我国，根深蒂固的暖气和空调供暖，让很多人对光电纤维地暖行业的发展前景不太乐观，然而，恒乐康光电纤维地暖敢于尝试，始终相信，光电……</p>
                    </a> </div>
                <ul class="nwrbg fr lifl clear">
                    <li><a href="#">
                            <p class="time">08<i>2017/10</i></p>
                            <p class="name">照顾好家人的身体健康，从温特斯顿地暖开始！</p>
                            <p class="nr">在我国，根深蒂固的暖气和空调供暖，让很多人对光电纤维地暖行业的发展前景不太乐观，然而，恒乐康光电纤维地暖敢于尝试，始终相信，光电……</p>
                        </a></li>
                    <li><a href="#">
                            <p class="time">08<i>2017/10</i></p>
                            <p class="name">照顾好家人的身体健康，从温特斯顿地暖开始！</p>
                            <p class="nr">在我国，根深蒂固的暖气和空调供暖，让很多人对光电纤维地暖行业的发展前景不太乐观，然而，恒乐康光电纤维地暖敢于尝试，始终相信，光电……</p>
                        </a></li>
                    <li><a href="#">
                            <p class="time">08<i>2017/10</i></p>
                            <p class="name">照顾好家人的身体健康，从温特斯顿地暖开始！</p>
                            <p class="nr">在我国，根深蒂固的暖气和空调供暖，让很多人对光电纤维地暖行业的发展前景不太乐观，然而，恒乐康光电纤维地暖敢于尝试，始终相信，光电……</p>
                        </a></li>
                </ul>
            </div>
            <div class="more"><a href="#">查看详情</a></div>
        </div>
    </div>
    <div class="wq1"></div>
    <div class="wq2"></div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(1);
    </script>
@endsection
