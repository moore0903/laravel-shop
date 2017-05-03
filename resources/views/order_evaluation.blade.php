@extends('layouts.app')

@section('content')
<div class="wrap fmyh">
    <div class="land">
        <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
        发布评价</div>
    <div class="evakuai">
        <div class="evaxont clear">
            <p class="tu fl"><img src="images/img12.jpg"/></p>
            <p class="name">{{$detail->product_title}}</p>
            <p class="sla">数量 x{{$detail->product_num}}</p>
            <p class="jya"><span class="fr">交易完成</span>¥{{$detail->product_num * $detail->product_price}}元</p>
        </div>
        <div class="order-list-Below clear">
            <h1 class="fl">商品评价</h1>
            <ul class="lifl fl clear">
                <li class="on"></li>
                <li class="on"></li>
                <li class="on"></li>
                <li class="on"></li>
                <li class="on"></li>
            </ul>
        </div>
    </div>
    <div class="evapja">
        <div class="evatex">
            <textarea name="content" rows="" id="Content" onfocus="if(this.value=='评价长度为10-500字之间，写下评价可以为其他淘友提供参考哦。') {this.value='';}" onblur="if(this.value=='') {this.value='评价长度为10-500字之间，写下评价可以为其他淘友提供参考哦。';}"maxlength="1500">评价长度为10-500字之间，写下评价可以为其他淘友提供参考哦。</textarea>
        </div>
        <div class="fileUpload btn btn-primary">
            <img class="preview"src=""/>
            <input type="file" name="image" class="upload" />
        </div>
    </div>
    <div class="evaanniu">
        <input name="" type="button" value="确认提交">
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

        $('.upload').change(function(){
            var _token = '{{ csrf_token() }}';
            $.post( "{{url('order/commentUpload')}}", {file: $(this).val(),_token: _token } )
                .done(function( data )
                {
                    $( 'img.preview' ).attr( 'src', data.path );
                });
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
                            var evaluationUrl = '{{url('order/evaluation')}}?id='+id;
                            window.location.reload();
                        }
                    }
                });
            });
        });

    </script>
@endsection