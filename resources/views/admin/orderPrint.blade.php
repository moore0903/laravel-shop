<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>武汉金土地后勤服务有限公司</title>
</head>
<style type="text/css">
    *{margin: 0; padding: 0; list-style: none;}
    .wrapper{
        width: 960px;
        margin: 20px auto;

    }
    .wrapper h1{
        text-align: center;
        margin-bottom: 30px;
    }
    .content {
        border: 1px solid #999;
        margin-top: 20px;
    }
    .content > ul{
        border-bottom: 1px solid #999;
    }
    .content .tite{
        border-bottom: 1px solid #999;
    }
    .content .tite li{
        float: left;
        width: 19.85%;
        text-align: center;
        padding: 10px 0;
        border-right: 1px solid #999;
    }
    .content .products li{
        float: left;
        width: 20%;
        text-align: center;
        padding: 5px 0;
    }
    .content .tite li:last-child{
        border: none;
    }
    .clearfix:after{
        content:".";
        display:block;
        height:0;
        clear:both;
        visibility:hidden
    }
    .wrapper .top p{
        float: left;
        width: 33%;
    }
    .wrapper .top span{
        border-bottom: 1px solid #999;
    }

    .content .footer p{
        float: left;
        width: 28%;
        border-right: 1px solid #999;
        padding: 20px 0;
        padding: 20px;
    }
    .content .footer p:last-child{
        border: none;
    }
</style>
<body>
<div class="wrapper">
    <h1>武汉金土地后勤服务有限公司产品配送单</h1>
    <div class="top clearfix">
        <p>客户名称: <span> {{ $order->realname }}</span></p>
        <p>送货地址: <span> {{ $order->address }}</span></p>
        <p>下单时间: <span> {{ $order->created_at }}</span></p>
    </div>
    <div class="content">
        <ul>
            <li>
                <ul class="tite clearfix">
                    <li>商品名称</li>
                    <li>单价</li>
                    <li>数量</li>
                    <li>单位</li>
                    <li>总价</li>
                </ul>
            </li>
            @foreach($order->details as $detail)
            <li>
                <ul class="products clearfix">
                    <li>{{ $detail->product_title }}</li>
                    <li>{{ $detail->product_price }}</li>
                    <li>{{ $detail->product_num }}</li>
                    <li>{{ \App\Models\ShopItem::getUnitsById($detail->shop_item_id) }}</li>
                    <li>{{ $detail->product_price * $detail->product_num }}</li>
                </ul>
            </li>
            @endforeach
        </ul>
        <div class="footer clearfix">
            <p>总金额: <span>{{ $order->totalpay }}元</span></p>
            <p>配送人:</p>
            <p>签收人:</p>
        </div>
    </div>

</div>
</body>
</html>