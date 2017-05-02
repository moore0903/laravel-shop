@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="order_list">
    <div class="land">
        <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
        我的订单</div>
    <ul class="orderlist lifl clear">
        <li class="on"><a href="{{url('order/list')}}">全部</a></li>
        <li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_NOTPAY}}">待付款</a></li>
        <li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_EXPRESS}}">待收货</a></li>
        <li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_PAYED}}">待评价</a></li>
        <li><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_SERVICE}}">退换货</a></li>
    </ul>
    <ul class="odlist lifl clear">
        @foreach($orders as $order)
            <?php $orderNum = 0;?>
        <li>
            <p class="bt"><span class="fr">{{\App\Models\Order::statDescribe($order->stat)}}</span>订单状态：{{\App\Models\Order::statString($order->stat)}}</p>
            @foreach($order->details as $detail)
            <div class="evaxont clear">
                <p class="tu fl"><img width="125px" src="{{asset('upload'.'/'.$detail->thumbnail)}}"></p>
                <p class="name">{{$detail->product_title}}</p>
                <p class="sla">数量 x{{$detail->product_num}}</p>
                <p class="jya">¥{{$detail->product_price}}元</p>
            </div>
                <?php $orderNum += $detail->product_num?>
            @endforeach
            <p class="jige">共{{$orderNum}}件商品，实付<i>¥{{$order->totalpay}}元</i></p>
            <div class="odkuai clear _order_{{$order->id}}">
                @if($order->stat == \App\Models\Order::STAT_NOTPAY)
                <p class="od1 fr"><a href="#">立即付款</a></p>
                <p class="od2 fr"><a href="{{url('order/cancel').'?id='.$order->id}}">取消订单</a></p>
                @elseif($order->stat == \App\Models\Order::STAT_PAYED || $order->stat == \App\Models\Order::STAT_EXPRESS)
                    <p class="od1 fr" data-order_id="{{$order->id}}"><a href="javascript:void(0);">确认收货</a></p>
                    <p class="od2 fr"><a href="#">查看物流</a></p>
                @elseif($order->stat == \App\Models\Order::STAT_FINISH)
                    <p class="od1 fr"><a href="{{url('order/evaluation').'?id='.$order->id}}">立即评价</a></p>
                @endif
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection

@section('script')
    <script>
        $('._confirmReceipt').click(function(){
            layer.confirm('确定收货?',function(index){
                layer.close(index);
                var id = $(this).data('order_id');
                $.ajax({
                    type: "GET",
                    url: "{{ url('order/confirmReceipt') }}",
                    data: "id="+id,
                    success: function(data){
                        layer.msg(data.msg);
                        if(data.stat == 1){
                            var evaluationUrl = '{{url('order/evaluation')}}?id='+id;
                            $('._order_'+id).html('<p class="od1 fr"><a href="'+evaluationUrl+'">立即评价</a></p> ');
                        }
                    }
                });
            });
        });

    </script>
@endsection