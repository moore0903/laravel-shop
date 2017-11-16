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
                <div class="title">企业文化</div>
                <ul class="lifl clear">
                    @foreach($pages as $page)
                        <li @if($info->id == $page->id)  class="on" @endif><a href="{{ url('/culture/'.$page->id) }}">{{ $page->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="main fr">
            <div class="ny_case">
                <div class="title"> {{ $info->title }} <i class="ttuc">{{ $info->en_title }}</i> </div>
                <div class="ny_dan">
                    {!! $info->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(2);
    </script>
@endsection