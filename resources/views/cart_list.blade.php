@extends('layouts.app')


@section('content')
    <div class="hydhbanner" style="background:url({{ asset('images/img9.jpg') }}) no-repeat center top;"></div>
    <div class="wrap">
        <div class="vipside fl">
            <div class="vipdhtitle">会员订货系统<i class="ttuc">Member order system</i></div>
            <div class="pro_case protop">
                <div class="title">会员功能</div>
                <ul class="lifl clear">
                    <li><a href="{{ url('/product_search') }}">在线订购</a></li>
                    <li class="on"><a href="{{ url('/cart/list') }}">查看购物车</a></li>
                    <li><a href="{{ url('/order/list') }}">查看我的订单</a></li>
                    <li><a href="{{ url('/notice') }}">会员公告</a></li>
                    <li><a href="{{ url('/reset_password') }}">修改密码</a></li>
                    <li><a href="{{ url('/logout') }}">安全退出</a></li>
                </ul>
            </div>
            <div class="series">
                <div class="title">产品系列<i class="ttuc">Product series</i></div>
                <ul class="lifl clear">
                    @foreach(\App\Models\Catalog::parentCatalog(32) as $catalog)
                        <li><a href="{{ url('/catalog/'.$catalog->id) }}">{{ $catalog->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="search clear">
                <form method="post" action="{{ url('/product_search') }}">
                    <p class="name fl">
                        <input type="text" name="search_title" id="userId" placeholder="请输入产品关键词">
                    </p>
                    <p class="nr fl">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input name="" type="submit" value="" />
                    </p>
                </form>

            </div>
        </div>
        <div class="vipmain fr">
            <div class="ny_title"><i class="fr">你所在位置：会员中心</i> 您好 <span>{{ $user->user_name??$user->name }}</span> 您是我们的 <span>经销商</span>，您目前有 <span>{{ \App\Models\Order::NotHandleOrder() }}</span> 个待处理订单。</div>
            <div class="gwckuai">
                <table class="gwclist">
                    <tr>
                        <th width="20%">产品名称</th>
                        <th width="14%">市场价</th>
                        <th width="14%">折扣</th>
                        <th width="14%">供货价</th>
                        <th width="13%">数量</th>
                        <th width="13%">小计</th>
                        <th width="12%">删除</th>
                    </tr>
                    @foreach($cart_lists as $cart)
                    <tr class="gwblist">
                        <td width="20%">{{ $cart->title }}</td>
                        <td width="14%">￥{{ $cart->product_price }}</td>
                        <td width="14%">{{ $cart->discount }}折</td>
                        <td width="14%">￥{{ $cart->price }}元</td>
                        <td width="13%"><input name="qty" type="text" value="{{ $cart->qty }}"/></td>
                        <td width="13%">￥{{ $cart->total }}元</td>
                        <td width="12%"><p class="xx" data-raw_id="{{ $cart->__raw_id }}"></p></td>
                        <input name="raw" type="hidden" value="{{ $cart->__raw_id }}"/>
                    </tr>
                    @endforeach
                </table>
                <div class="gwcnr">购物车中有商品：<i>{{ $cart_raw_count }}</i>种     总数：<i>{{ $cart_count }}</i>件    共计：￥<i>{{ $cart_totalPrice }}</i>元（人民币）</div>
                <ul class="gwcgmlist lifl clear">
                    <li><a href="{{ url('/product_search') }}">继续购买商品</a></li>
                    <li><a href="javascript:void(0);" id="edit_cart">修改购物清单</a></li>
                    <li><a href="{{ url('/order/add') }}">去收银台结算</a></li>
                    <li class="g1"><a href="javascript:void(0);" id="empty_cart">清空购物清单</a></li>
                </ul>
                <div class="gwcdg"> 如果您想继续购物，请点选继续购物<br />
                    如果您想更新已在购物车内的产品，请先修改，然后点选修改数量<br />
                    如果您想删除购物车内的单一产品，请单击该产品后面的<i><img src="{{ asset('images/bg13.gif') }}" /></i>图标<br />
                    如果您想全部取消已订购在购物车中的产品，请点选清空购物车<br />
                    如果您满意您所购买的产品，请点选去收银台 </div>
            </div>
        </div>
        <div class="clean"></div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(1);
        $('#edit_cart').on('click',function(){
            var arr = new Array();
            $('.gwblist').each(function(){
                var raw = $(this).children('input[name="raw"]').val();
                var qty = $(this).children('td').children('input[name="qty"]').val();
                arr.push(raw+'|'+qty);
            });
            var _token = "{{ csrf_token() }}";
            $.post("{{ url('/cart/update') }}", {arr:arr, _token:_token},
                function(data){
                    if(data.stat == 1){
                        layer.msg('修改购物车成功');
                        window.location.href = "{{ url('/cart/list') }}";
                    }else{
                        layer.msg('修改购物车失败');
                    }
                });
        });

        $('.xx').on('click',function(){
            var raw_id = $(this).data('raw_id');
            $.get("{{ url('/cart/del') }}", {raw_id:raw_id},
                function(data){
                    if(data.stat == 1){
                        layer.msg('删除购物车成功');
                        window.location.href = "{{ url('/cart/list') }}";
                    }else{
                        layer.msg('删除购物车失败');
                    }
                });
        });

        $('#empty_cart').on('click',function(){
            $.get("{{ url('/cart/empty') }}",
                function(data){
                    if(data.stat == 1){
                        layer.msg('删除购物车成功');
                        window.location.href = "{{ url('/cart/list') }}";
                    }else{
                        layer.msg('删除购物车失败');
                    }
                });
        });
    </script>
@endsection