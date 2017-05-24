<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div style="width: 100%;text-align: center;">
    @if($response->isSuccessful())
        @if($inWechat)
            <?php $jsorderdata =  $response->getJsOrderData();if($jsorderdata && isset($jsorderdata['timeStamp'])){$jsorderdata['timeStamp']=strval($jsorderdata['timeStamp']);}    ?>
            <script>
                function onBridgeReady(){
                    WeixinJSBridge.invoke(
                        'getBrandWCPayRequest', {!! json_encode($jsorderdata) !!},
                        function(res){
                            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                                window.location.href = '{{url('/order/list')}}';
                            }     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                        }
                    );
                }
                if (typeof WeixinJSBridge == "undefined"){
                    if( document.addEventListener ){
                        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                    }else if (document.attachEvent){
                        document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                    }
                }else{
                    onBridgeReady();
                }
            </script>
        @else
            <div class="qrcode" qrcode='{{$response->getCodeUrl()}}' label='微信扫码支付' labelimg="qr_wx" style="margin-top: 20px;margin: 0 auto;"></div>
            <p>
            <p><a class="btn btn-warning" onclick="window.parent.location.href='{{url('/order/list')}}'">已支付完成</a></p>
            <p style="font-size: 12px;color: #cccccc;">若返回后仍显示待支付状态，请过几分钟后再刷新试试。</p>
        @endif
    @else
        {{$response->getData()['return_msg']}}
    @endif
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('/packages/qrcode/jquery.qrcode.min.js')}}"></script>
<script>
    $('.qrcode').each(function () {
        $(this).qrcode({
            render: 'image',
            text: $(this).attr('qrcode'),
            size: 200,
            ecLevel: 'M', //纠错级别，L,M,Q,H，7%,15%,25%,30%,
            radius: 0.2
        });
    });
</script>
</div>
</body>
</html>