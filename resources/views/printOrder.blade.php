<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单打印</title>
    <style>
        @charset "utf-8";
        .clear{ overflow:hidden; _height:1px; _overflow:visible; }
        .clean{ font-size:0px; line-height:0px; clear:both;}
        :focus { outline: 0;}
        a{ blr:expression(this.onFocus=this.blur());text-decoration:none;}
        *{ margin:0; padding:0; -webkit-text-size-adjust:none;}
        a{ text-decoration:none; outline:none; cursor:pointer;}
        a:hover,img{ border:none;}
        html{ overflow-x:hidden; background-color:#fff;}
        body,button,input,select,textarea{ font:12px Verdana, Geneva, sans-serif;}
        textarea{ resize:none}
        h1,h2,h3,h4,h5,h6{ font-weight:normal;}
        i{ font-style:normal;}
        p{ text-align:justify; text-justify:inter-ideograph; margin:0px; }
        ul,ol,dl{ list-style-type:none; margin:0px; }
        .fl,.fr,.lifl li,.lifl dd{ float:left; display:inline; list-style:none;}
        .fr{ float:right;}
        .cctable{ width:794px; height:1123px; margin:30px auto 0 auto; }
    </style>
</head>

<body>
<div class="cctable">
    <table width="100%" align="center" bgcolor="#CCCCCC" border="0">
        <tbody>
        <tr>
            <td align="center" bgcolor="#fffcf7" style="valign=&quot;top&quot;">
                <table width="100%" style="line-height:20px;" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
                    <tbody>
                    <tr>
                        <td height="28" align="center" bgcolor="#EFEFEF"><span class="p_c1"><font color="#Ff6600"><b>订单详情</b></font></span></td>
                        <td height="28" align="left" bgcolor="#EFEFEF" style="padding-left:10px;">订货时间：{{ $order->created_at }}</td>
                    </tr>
                    <tr bgcolor="#77B3EE">
                        <td height="28" colspan="2" nowrap="" bgcolor="#F5F5F5">&nbsp;订货详细信息……</td>
                    </tr>
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">订单号：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $order->serial }}</td>
                    </tr>
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">用户账号：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">收货人姓名：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $order->realname }}</td>
                    </tr>
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">性别：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $user->sex ? '女' : '男' }}</td>
                    </tr>
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">联系电话：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $user->tel }}</td>
                    </tr>
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">手机：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">收货人地址：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">邮政编码：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $user->code }}</td>
                    </tr>
                    {{--<tr>--}}
                        {{--<td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">送货方式：</td>--}}
                        {{--<td bgcolor="#FFFCF7" style="padding-left:10px;"></td>--}}
                    {{--</tr>--}}
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">付款方式：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ \App\Models\Order::$pay[$order->paytype] }}</td>
                    </tr>
                    {{--<tr>--}}
                        {{--<td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">订货留言：</td>--}}
                        {{--<td bgcolor="#FFFCF7" style="padding-left:10px;">——备注信息——加急，客户急需！</td>--}}
                    {{--</tr>--}}
                    <tr>
                        <td height="28" width="15%" align="right" nowrap="" bgcolor="#FFFCF7">订货日期：</td>
                        <td bgcolor="#FFFCF7" style="padding-left:10px;">{{ $order->created_at }}</td>
                    </tr>
                    <tr bgcolor="#77B3EE">
                        <td height="28" colspan="2" nowrap="" bgcolor="#F5F5F5">&nbsp;订货商品明细……</td>
                    </tr>
                    </tbody>
                </table>
                <table width="100%" style="line-height:20px;" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
                    <tbody>
                    <tr>
                        <td height="28" width="16%" align="center" nowrap="" bgcolor="#EFEFEF">产品名称</td>
                        <td width="14%" align="center" nowrap="" bgcolor="#EFEFEF">市场价</td>
                        <td width="13%" align="center" nowrap="" bgcolor="#EFEFEF">折扣</td>
                        <td width="19%" align="center" nowrap="" bgcolor="#EFEFEF">供货单价</td>
                        <td width="18%" align="center" nowrap="" bgcolor="#EFEFEF">订购数量</td>
                        <td width="20%" align="center" nowrap="" bgcolor="#EFEFEF">金额小计</td>
                    </tr>
                    @foreach($details as $detail)
                    <tr bgcolor="#D9EAF9">
                        <td align="center" bgcolor="#FFFCF7">{{ $detail->product_title }}</td>
                        <td height="35" align="center" valign="middle" bgcolor="#FFFCF7">￥{{ $detail->product_price }}</td>
                        <td height="35" align="center" valign="middle" bgcolor="#FFFCF7">{{ $user->discount }}折</td>
                        <td align="center" bgcolor="#FFFCF7"><span style="color:#FF0000;">￥{{ $detail->product_price * $user->discount }}</span>&nbsp;元</td>
                        <td align="center" bgcolor="#FFFCF7"><span style="color:#FF0000;">{{ $detail->product_num }}</span>&nbsp;件</td>
                        <td align="center" bgcolor="#FFFCF7"><span style="color:#FF0000;">￥{{ $detail->product_price * $user->discount * $detail->product_num }}&nbsp;</span>元</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td height="35" colspan="6" align="left" style="padding-left:10px;" bgcolor="#F5F5F5">购物车中有商品：<span style="color:#FF0000;">{{ $order->details()->count() }}&nbsp;</span>种&nbsp;&nbsp;&nbsp;<span style="color:#FF0000;">{{ $order->details()->sum('product_num') }}&nbsp;</span>件&nbsp;&nbsp;共计：<span style="color:#FF0000;">￥{{ $order->totalpay }}&nbsp;</span>元<span style="color:#FF0000;">（享受折扣：{{ $user->discount }} 折&nbsp;折后价：<span style="color:#FF0000;">￥{{ $order->totalpay }}&nbsp;</span>元）</span><span style="color: #CCCCCC">（人民币）</span></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
