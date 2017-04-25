@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="login">
    <div class="land">
        <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
        登陆</div>
    <ul class="landlist lifl clear">
        <form method="post" action="{{url('bindphone')}}">
            <li>
                <input type="text" name="phone" placeholder="请输入手机号码">
            </li>
            <li>
                <input type="text" name="verifycode" placeholder="请输入手机验证码">
                <p class="annniu">
                    <input name="Verify" type="button" value="获取验证码" @click="sendSmsVerify(true)">
                </p>
            </li>
            <li class="anniuland">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input name="" type="submit" value="登录">
            </li>
        </form>
    </ul>
</div>
@endsection

@section('script')
    <script>
        var login = new Vue({
            el:'#login',
            data:{
                'countdown':60,
            },
            methods:{
                sendSmsVerify:function(is_send){
                    var phone = $('input[name="phone"]').val();
                    if(phone == null || phone == ''){
                        layer.msg('请填写手机号');
                        return;
                    }
                    if(is_send){
                        $.ajax({
                            type: "GET",
                            url: "{{ url('sendSmsVerify') }}",
                            data: "phone="+phone,
                            success: function(data){
                                if(data.stat == 1){
                                    layer.msg('发送成功')
                                }else{
                                    layer.msg(data.msg);
                                }
                            }
                        });
                    }
                    var obj = $('input[name="Verify"]');
                    countdown(obj);
                }
            }
        });

        function countdown(obj){
            if(login.countdown == 0){
                obj.attr("disabled",false);
                obj.val("获取验证码");
                login.countdown = 60;
                return;
            } else {
                obj.attr("disabled", true);
                obj.val("重新发送(" + login.countdown + "s)");
                login.countdown--;
            }
            setTimeout(function() {
                countdown(obj)
            },1000);
        }


    </script>
@endsection