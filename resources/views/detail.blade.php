@extends('layouts.app')

@section('banner')

@endsection
@section('search')
    <div class="spxqtitle fmyh">
        <div class="spxqnrkuai clear">
            <p class="name fl">
                <input type="text" name="text" placeholder="请输入你想要的菜品！">
            </p>
            <p class="nr fl">
                <input name="" type="button">
            </p>
        </div>
    </div>
@endsection

@section('content')
    <div class="detail fmyh">
        <div class="dtu"><img src="{{ asset('upload/'.$item->img) }}" /></div>
        <div class="dtitle fmyh">
            <p class="name">{{ $item->title }}({{ $item->unit_number }}{{ $item->units }})</p>
            <p class="nr">￥{{ $item->price }}</p>
        </div>
        <div class="sqxzkuai clear">
            <p class="name fl">选择数量：</p>
            <div class="gwsl fl">
                <input class="min" name="" type="button" value="-" />
                <input class="text_box" name="qty" type="text" value="1" />
                <input class="add" name="" type="button" value="+" />
            </div>
            <p class="jrgwc fr">
                <input name="" type="button" value="加入购物车">
            </p>
        </div>
        <div class="sqdetail">
            <div class="title clear">
                <h3>商品介绍</h3>
            </div>
            <div class="cont">{!! $item->detail !!}</div>
        </div>
    </div>
@endsection

<script>
var vm = new Vue({

});
</script>