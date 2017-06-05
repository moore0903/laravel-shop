@extends('layouts.app')

@section('content')
<div class="wrap fmyh">
    <div class="land">
        <p class="fhaniu"><a href="javascript:" onclick="self.location=document.referrer;"></a></p>
        发布评价</div>
    <div class="ecvkuai">
    <form method="post" action="{{url('order/evaluation')}}">
    <div class="evakuai">
        <div class="evaxont clear">
            <p class="tu fl"><img src="{{asset('upload'.'/'.$detail->thumbnail)}}" width="127" height="127"/></p>
            <p class="name">{{$detail->product_title}}</p>
            <p class="sla">数量 x{{$detail->product_num}}</p>
            <p class="jya"><span class="fr">交易完成</span>¥{{$detail->product_num * $detail->product_price}}元</p>
        </div>
        <div class="order-list-Below clear">
            <h1 class="fl">商品评价</h1>
            <ul class="lifl fl clear">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </div>
    <div class="evapja">
        <div class="evatex">
            <textarea name="content" rows="" id="Content" onfocus="if(this.value=='评价长度为10-500字之间，写下评价可以为其他淘友提供参考哦。') {this.value='';}" onblur="if(this.value=='') {this.value='评价长度为10-500字之间，写下评价可以为其他淘友提供参考哦。';}"maxlength="1500">评价长度为10-500字之间，写下评价可以为其他淘友提供参考哦。</textarea>
        </div>
    </div>
    <div class="evaanniu">
        <input type="hidden" name="images" value=""/>
        <input type="hidden" name="star" value="0"/>
        <input type="hidden" name="detail_id" value="{{$detail->id}}"/>
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input name="" type="submit" value="确认提交">
    </div>
    </form>
    <div class="evform">
    <div class="fileUpload btn btn-primary">
        <form action="{{url('order/commentUpload')}}" class="_commentUpload" method="post" enctype="multipart/form-data">
            <img class="preview" src="" width="95"/>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="file" name="image" class="upload" />
        </form>
    </div>
    </div>
    </div>
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

        $('.upload').change(function(){
            layer.load(1);
            $('._commentUpload').ajaxForm(function(data){
                layer.closeAll('loading');
                if(data.stat == 1){
                    $( 'img.preview' ).attr( 'src', data.imgUrl );
                    $('input[name="images"]').val(data.path);
                    $('.upload').hide();
                    $('.fileUpload').removeClass('btn-primary');
                }else{
                    layer.msg(data.msg);
                }
            }).submit();
        });

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
                            window.location.reload();
                        }
                    }
                });
            });
        });

        function star(star){
            $('input[name="star"]').val(Number(star)+Number(1));
        }

        /*商品评价*/
        $(".order-list-Below ul li").click(
            function () {
                star($(".order-list-Below ul li").index(this));
                var num = $(this).index() + 1;
                var len = $(this).index();
                var thats = $(this).parent(".order-list-Below ul").find("li");
                if ($(thats).eq(len).attr("class") == "on") {
                    if ($(thats).eq(num).attr("class") == "on") {
                        $(thats).removeClass();
                        for (var i = 0; i < num; i++) {
                            $(thats).eq(i).addClass("on");
                        }
                    } else {
                        $(thats).removeClass();
                        for (var k = 0; k < len; k++) {
                            $(thats).eq(k).addClass("on");
                        }
                    }
                } else {
                    $(thats).removeClass();
                    for (var j = 0; j < num; j++) {
                        $(thats).eq(j).addClass("on");
                    }
                }
            }
        );

    </script>
@endsection