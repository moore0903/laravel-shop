@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="order_list">
    <div class="land">
        <p class="fhaniu"><a href="{{url('user/info')}}"></a></p>
        我的订单</div>
    <ul class="orderlist lifl clear">
        <li @if($stat === 'all') class="on" @endif><a href="{{url('order/list')}}">全部</a></li>
        <li @if($stat === \App\Models\Order::STAT_NOTPAY) class="on" @endif><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_NOTPAY}}">待付款</a></li>
        <li @if($stat == \App\Models\Order::STAT_PAYED) class="on" @endif><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_PAYED}}">待发货</a></li>
        <li @if($stat == \App\Models\Order::STAT_EXPRESS) class="on" @endif><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_EXPRESS}}">待收货</a></li>
        <li @if($stat == \App\Models\Order::STAT_EVALUATE) class="on" @endif><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_EVALUATE}}">待评价</a></li>
        <li @if($stat == \App\Models\Order::STAT_SERVICE) class="on" @endif><a href="{{url('order/list').'?stat='.\App\Models\Order::STAT_SERVICE}}">退换货</a></li>
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
                @if($order->stat == \App\Models\Order::STAT_EVALUATE && \App\Models\Comment::getCommentCountByOrderDetail(Auth::user()->id,$detail->shop_item_id,$order->id,$detail->id) <= 0)
                    <p class="ljpj"><a href="{{url('order/evaluation').'?detail_id='.$detail->id.'&shop_item_id='.$detail->shop_item_id.'&order_id='.$order->id}}">立即评价</a></p>
                @endif
            </div>
                <?php $orderNum += $detail->product_num?>
            @endforeach
            <p class="jige">共{{$orderNum}}件商品，实付<i>¥{{$order->totalpay}}元</i></p>
            <div class="odkuai clear _order_{{$order->id}}">
                @if($order->stat == \App\Models\Order::STAT_NOTPAY)
                    <?php
                    $inMobile = preg_match('/iPad|iPhone|iPod|iOS|Android|Windows Phone|Mobile/i',$_SERVER['HTTP_USER_AGENT']??'') ;
                    $inWechat = strpos(($_SERVER['HTTP_USER_AGENT']??''),'MicroMessenger')!==FALSE;
                    ?>
                    @if($inWechat)
                        <p class="od1 fr"><a href="{{url('/pay/wechatPay?order_id='.$order->id)}}">立即付款</a></p>
                    @else
                        <p class="od1 fr"><a href="{{url('/pay/aliPay?order_id='.$order->id)}}">立即付款</a></p>
                    @endif
                <p class="od2 fr"><a href="{{url('order/cancel').'?id='.$order->id}}">取消订单</a></p>
                @elseif($order->stat == \App\Models\Order::STAT_EXPRESS)
                    <p class="od1 fr _confirmReceipt" data-order_id="{{$order->id}}"><a href="javascript:void(0);">确认收货</a></p>
                    @if($order->express_company != '' && $order->express_company != '自提')
                        <p class="od2 fr"><a href="{{ 'https://m.kuaidi100.com/index_all.html?type='.\App\Models\Order::express_coding($order->express_company).'&postid='.$order->express_no.'&callbackurl='.url('order/list') }}">查看物流</a></p>
                    @endif
                @elseif($order->stat == \App\Models\Order::STAT_FINISH || $order->stat == \App\Models\Order::STAT_EVALUATE)
                    <p class="od1 fr _confirmService" data-order_id="{{$order->id}}"><a href="javascript:void(0);">申请退货</a></p>
                @else

                @endif
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection

@section('script')
    <script>
        <?php
            $error = '';
            if(isset($errors)){
                $error = $errors->first();
            }
        ?>
        var error = '{{$error}}';
        if(error){
            layer.msg(error);
        }
        $('.f03').addClass('on');
        $('._confirmReceipt').click(function(){
            layer.confirm('确定收货?',function(index){
                layer.close(index);
                var id = $('._confirmReceipt').data('order_id');
                $.ajax({
                    type: "GET",
                    url: "{{ url('order/confirmReceipt') }}",
                    data: "id="+id,
                    success: function(data){
                        layer.msg(data.msg);
                        if(data.stat == 1){
                            window.location.reload();
                        }
                    }
                });
            });
        });

        $('._confirmService').click(function(){
            layer.confirm('确定退货?',function(index){
                layer.close(index);
                var id = $('._confirmService').data('order_id');
                $.ajax({
                    type: "GET",
                    url: "{{ url('order/confirmService') }}",
                    data: "id="+id,
                    success: function(data){
                        layer.msg(data.msg);
                        if(data.stat == 1){
                            window.location.reload();
                        }
                    }
                });
            });
        });

    </script>
@endsection