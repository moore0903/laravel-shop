@extends('layouts.app')

@section('content')
<div class="wrap fmyh">
    <div class="land">
        <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
        我的足迹</div>
    <div class="collelist">
        <ul class="cplist lifl clear">
            @foreach($browse_list as $browse)
            <li>
                <a href="{{url('shop_item/detail/'.\Hashids::encode($browse->shop_item_id))}}">
                    <p class="tu"><img src="{{asset('upload'.'/'.$browse->shopItem->img)}}" /></p>
                    <p class="name">{{$browse->shopItem->title}}</p>
                    <p class="jige"><i class="fr">¥{{$browse->shopItem->original_price}}元</i>¥{{$browse->shopItem->price}}元</p>
                    {{--<ins class="c1"></ins>--}}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('.f04').addClass('on');
    </script>
@endsection