@extends('layouts.app')

@section('content')
    <div class="wrap fmyh">
        <div class="land">
            <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
            我的优惠劵</div>
        <ul class="couponlist lifl clear">
            @foreach($gift_list as $gift)
                <li>
                    <div class="coupkuai">
                        <p class="jiage">¥<span>{{$gift->discountn}}</span> <i>满{{$gift->discountnlimit}}减{{$gift->discountn}}</i></p>
                        <p class="name">
                            <span>[所有订单］</span>
                            <i>适用范围：所有商品</i> <i>{{$gift->start_time}}－{{$gift->end_time}}</i>
                        </p>
                        <p class="receive">
                            <a href="javascript:void(0);">
                                @if($gift->usecountmax <= $gift->usecount )
                                    已使用
                                @elseif($gift->start_time > date('Y-m-d H:i:s'))
                                    未开始
                                @elseif($gift->end_time < date('Y-m-d H:i:s'))
                                    已结束
                                @else
                                    可使用
                                @endif
                            </a>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

@section('script')
    <script>
        $('.f04').addClass('on');
    </script>
@endsection