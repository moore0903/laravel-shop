@extends('layouts.app')

@section('content')
    <div class="wrap fmyh">
        <div class="land">
            <p class="fhaniu"><a href="{{url('user/info')}}"></a></p>
            个人设置
        </div>
        <ul class="personal lifl clear">
            <form action="{{url('user/editUserInfo')}}" method="post">
                <li>
                    <span class="tu fr" onclick="$('input[name=image]').click();">
                    <img class="_headimage" src="{{$user->headimage}}"/>
                    </span>头像
                </li>
                <li><span class="fr">{{$user->phone}}</span>手机号码</li>
                {{--<li><span class="fr">小蜜蜂9214</span>昵称</li>--}}
                <li>性别
                    <div class="xbqujian xbmod clear @if($user->sex == 1) on @endif">
                        <p class="name fl">男</p>
                        <p class="xbnr fl">
                            <input name="sex" type="radio" value="1" @if($user->sex == 1) checked="checked" @endif>
                        </p>
                    </div>
                    <div class="xbqujian1 xbmod clear @if($user->sex == 2) on @endif">
                        <p class="name fl">女</p>
                        <p class="xbnr fl">
                            <input name="sex" type="radio" value="2" @if($user->sex == 2) checked="checked" @endif>
                        </p>
                    </div>
                </li>
                <li class="anniuland">
                    <input name="headimage" type="hidden" value="{{$user->headimage}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input name="" type="submit" value="提交">
                </li>
            </form>
            {{--<li>修改密码</li>--}}
        </ul>
    </div>

    <form action="{{url('user/upload')}}" class="_upload" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="file" name="image" class="upload" accept="image/png,image/jpg" style="display: none;"/>
    </form>
@section('script')
    <script>
        $('.upload').change(function () {
            layer.load(1);
            $('._upload').ajaxForm(function (data) {
                layer.closeAll('loading');
                if (data.stat == 1) {
                    $('img._headimage').attr('src', data.imgUrl);
                    $('input[name="headimage"]').val(data.imgUrl);
                } else {
                    layer.msg(data.msg);
                }
            }).submit();
        });
        $('.f04').addClass('on');
    </script>
@endsection