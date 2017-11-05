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