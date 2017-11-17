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
    <div class="wrap" style="position:relative; z-index:999;">
        <div class="nphone"></div>
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
            </ul>
        </div>
    </div>
    <div class="main fr">
        <div class="ny_case">
            <div class="title"> {{ $catalog->title }} <i class="ttuc">{{ $catalog->en_title }}</i> </div>
            <ul class="product_quandan">
                @foreach($three_catalog as $item)
                    <li @if($item->id == $three_catalog_id)  class="on" @endif><a href="{{ url('/catalog/'.$item->id) }}">{{ $item->title }}</a></li>
                @endforeach
            </ul>
            <ul class="caselist lifl clear">
                @foreach($list as $item)
                <li>
                    <a href="{{ url('/case/detail/'.$item->id) }}"><img src="{{ asset('upload/'.$item->img) }}" width="269" height="186"/>
                        <p class="name">{{ $item->title }}</p>
                    </a>
                </li>
                @endforeach
            </ul>
            <div class="page fmyh">
                {{ $list->links() }}
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