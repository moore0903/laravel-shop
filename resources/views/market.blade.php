@extends('layouts.app')


@section('content')
    <div class="nfdm">
        <div class="nbanner scroll">
            <ul>
                @foreach($banners as $banner)
                    <li><a href="#" style=" background:url({{ asset('upload/'.$banner->img) }}) no-repeat center top;"></a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="wrap fmyh clear">
        <div class="side fl">
            <div class="pro_case">
                <div class="title">采暖市场</div>
                <ul class="lifl clear">
                    @foreach($catalogs as $cata)
                        <li @if($cata->id == $catalog->id)  class="on" @endif><a href="{{ url('/market/'.$cata->id) }}">{{ $cata->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="main fr">
            <div class="ny_case">
                <div class="title"> {{ $catalog->title }} <i class="ttuc">{{ $catalog->en_title }}</i> </div>
                <ul class="caselist lifl clear">
                    @foreach($articles as $article)
                    <li>
                        <a href="{{ url('/market/detail/'.$article->id) }}"><img src="{{ asset('upload/'.$article->img) }}" width="269" height="186"/>
                            <p class="name">{{ $article->title }}</p>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="page fmyh">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(3);
    </script>
@endsection