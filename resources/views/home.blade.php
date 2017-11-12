@extends('layouts.app')


@section('content')
    <div class="fdm">
        <div class="banner scroll">
            <ul>
                @foreach($banners as $banner)
                <li><a href="#" style=" background:url({{ asset('upload/'.$banner->img) }}) no-repeat center top;"></a></li>
                @endforeach
            </ul>
        </div>
        <ul class="pan lifl clear">
        </ul>
    </div>
    <div class="fdm3">
        <div class="fdm2">
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
                    <li class="abl1"><a href="{{ url('/catalog/11') }}">企业实力</a></li>
                    <li class="abl2"><a href="{{ url('/catalog/12') }}">企业荣誉</a></li>
                    <li class="abl3"><a href="{{ url('/catalog/13') }}">企业规划</a></li>
                    <li class="abl4"><a href="{{ url('/catalog/14') }}">企业风采</a></li>
                </ul>
            </div>
        </div>
    </div>
        </div>
    </div>
    <div class="fdm4">
    <div class="wrap fmyh">
        <div class="case">
            <div class="title">案例展示<i>地暖黑科技，温暖陪伴你</i> </div>
            <ul class="lifl clear">
                @foreach($case_recommend as $key => $case)
                <li class="c{{ $key+1 }}"><a href="{{ url('/case/detail/'.$case->id) }}"><img src="{{ asset('upload/'.$case->img) }}" @if($key == 2) width="596" height="413" @else width="269" height="186" @endif/>
                        <div class="canr">
                            <p class="name">{{ $case->title }}</p>
                            <p class="nr">查看详情</p>
                        </div>
                    </a></li>
                @endforeach
            </ul>
        </div>
    </div>
    </div>
    <div class="fdm5">
    <div class="wrap fmyh">
        <div class="news">
            <div class="title">新闻资讯<i>科研精英+营销大师+明星代言 强兵强将强强集合  超强战队所向披靡</i> </div>
            <div class="cont clear">
                <div class="nwlbg fl"> <a href="{{ url('/article/detail/'.$article_hot->id) }}">
                        <div class="tu"><img src="{{ asset('upload/'.$article_hot->img) }}"/></div>
                        <p class="name clear"><i class="fr">{{ date('Y/m/d',strtotime($article_hot->created_at)) }}</i>{{ $article_hot->title }}</p>
                        <p class="nr">{{ mb_substr(strip_tags($article_hot->content),0,50) }}</p>
                    </a> </div>
                <ul class="nwrbg fr lifl clear">
                    @foreach($article_recommend as $item)
                    <li><a href="{{ url('/article/detail/'.$item->id) }}">
                            <p class="time">{{ date('d',strtotime($item->created_at)) }}<i>{{ date('Y/m',strtotime($item->created_at)) }}</i></p>
                            <p class="name">{{ $item->title }}</p>
                            <p class="nr">{{ mb_substr(strip_tags($item->content),0,50) }}</p>
                        </a></li>
                    @endforeach
                </ul>
            </div>
            <div class="more"><a href="{{ url('/catalog/25') }}">查看更多</a></div>
        </div>
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
