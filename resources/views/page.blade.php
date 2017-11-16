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
                <div class="title">{{ $top_catalog->title }}</div>
                <ul class="lifl clear">
                    @foreach($catalog_set as $item)
                        <li @if($item->id == $catalog->id)  class="on" @endif><a href="{{ url('/catalog/'.$item->id) }}">{{ $item->title }}</a></li>
                    @endforeach
                    @if($top_catalog->id == 29)
                        <li @if(Route::currentRouteName() == '/message') class="on" @endif><a href="{{ url('/message') }}">在线留言</a></li>
                    @endif
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
        setNav({{ $set_nev }});
    </script>
@endsection