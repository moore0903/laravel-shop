@extends('layouts.app')

@section('header')

@endsection

@section('banner')

@endsection

@section('search')

@endsection

@section('content')
    <div class="membertitle fmyh">
        <p class="fh"><a href="javascript:window.history.go(-1)"></a></p>
        我的订单</div>
    <ul class="odlist lifl clear">
        @foreach($order_list as $order)
        <li>
            @foreach($order->detail as $detail)
            <div class="evaxont clear">
                <p class="tu fl"><img src="{{ $detail->thumbnail }}"></p>
                <p class="name">{{$detail->product_title}}</p>
                <p class="sla">数量 x{{ $detail->product_num }}</p>
                <p class="jya">¥{{ $detail->product_price }}元</p>
            </div>
            @endforeach
        </li>
    </ul>
    @endforeach
@endsection

@section('bottom_bar')

@endsection