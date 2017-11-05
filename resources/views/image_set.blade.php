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
                <div class="title"> {{ $info->title }} <i class="ttuc">{{ $info->en_title }}</i> </div>
                <div class="ny_honor">
                    <div class="lmtitle">
                        {!! $info->content !!}
                    </div>
                    <div class="honorkuai">
                        <div class="honortop scroll">
                            <ul>
                                @foreach($info->images as $item)
                                <li><img src="{{ asset('upload/'.$item) }}" width="463" height="283" /></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="honorbot clear">
                            <p class="prev fl"></p>
                            <div class="hontu fl scroll">
                                <ul>
                                    @foreach($info->images as $item)
                                    <li><img src="{{ asset('upload/'.$item) }}" width="146" height="89" alt=""></li>
                                    @endforeach
                                </ul>
                            </div>
                            <p class="next fr"></p>
                        </div>
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