@extends('layouts.app')

@section('content')
<div class="wrap fmyh">
    <div class="land">
        <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
        个人设置</div>
    <ul class="personal lifl clear">
        <li><span class="tu fr" onclick="$('input[name=image]').click();"><img class="_headimage" src="{{Auth::user()->headimage}}"/></span>头像</li>
        <li><span class="fr">{{Auth::user()->phone}}</span>手机号码</li>
        <li><span class="fr">小蜜蜂9214</span>昵称</li>
        <li>性别<form>
        <div class="xbqujian xbmod clear">
          <p class="name fl">男</p>
          <p class="xbnr fl">
            <input name="cc" type="radio" value="">
          </p>
        </div>
        <div class="xbqujian1 xbmod clear">
          <p class="name fl">女</p>
          <p class="xbnr fl">
            <input name="cc" type="radio" value="">
          </p>
        </div>
      </form></li>
        {{--<li>修改密码</li>--}}
    </ul>
</div>

<form action="{{url('user/upload')}}" class="_upload" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <input type="file" name="image" class="upload" accept="image/png,image/jpg" style="display: none;"/>
</form>
@section('script')
    <script>
        $('.upload').change(function(){
            layer.load(1);
            $('._upload').ajaxForm(function(data){
                layer.closeAll('loading');
                if(data.stat == 1){
                    $( 'img._headimage' ).attr( 'src', data.imgUrl );
                }else{
                    layer.msg(data.msg);
                }
            }).submit();
        });
    </script>
@endsection