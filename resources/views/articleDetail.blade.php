@extends('layouts.app')


@section('content')
    <div class="nbanner" style="background:url({{ asset('images/nbanner.jpg') }}) no-repeat center top;">
        <div class="wrap mod">
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
                <div class="xxzdetail">
                    <div class="xxzbt">{{ $info->title }}<i>发布时间：{{ date('Y/m/d',strtotime($info->created_at)) }}</i></div>
                    <div class="xxzcont">
                        {!! $info->content !!}
                    </div>
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