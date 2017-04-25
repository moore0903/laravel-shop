@extends('layouts.app')

@section('content')
    <div class="wrap fmyh">
        <div class="land">
            <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
            领取优惠劵</div>
        <ul class="couponlist lifl clear">
            @foreach($giftcodes as $gift)
            <li>
                <div class="coupkuai">
                    <p class="jiage">¥<span>{{$gift->discountn}}</span> <i>满{{$gift->discountnlimit}}减{{$gift->discountn}}</i></p>
                    <p class="name">
                        <span>[所有订单］</span>
                        <i>适用范围：所有商品</i> <i>{{$gift->start_time}}－{{$gift->end_time}}</i>
                    </p>
                    <p class="receive" data-title="{{$gift->title}}" data-discountn="{{$gift->discountn}}" data-discountnlimit="{{$gift->discountnlimit}}" data-usecountmax="{{$gift->usecountmax}}" data-start_time="{{$gift->start_time}}" data-end_time="{{$gift->end_time}}">
                        <a href="javascript:void(0);">立即领取</a>
                    </p>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
@endsection

@section('script')
    <script>
        $(function(){
            $('.receive').click(function(){
                var layerLoad = layer.load();
                var title = $(this).data('title');
                var discountn = $(this).data('discountn');
                var discountnlimit = $(this).data('discountnlimit');
                var usecountmax = $(this).data('usecountmax');
                var start_time = $(this).data('start_time');
                var end_time = $(this).data('end_time');
                $.get("{{url('gift/receive')}}",
                    { title: title, discountn: discountn, discountnlimit: discountnlimit, usecountmax: usecountmax, start_time: start_time, end_time: end_time },
                    function(result){
                        layer.close(layerLoad);
                        if(!result.stat){
                            layer.msg(result.msg);
                            if(result.url){
                                layer.msg(result.msg, function(){
                                    window.location.href=result.url;
                                });
                            }
                        }else{
                            layer.msg(result.msg);
                        }
                    });
            });

        });
    </script>
@endsection