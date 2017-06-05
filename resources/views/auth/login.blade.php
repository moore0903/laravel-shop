@extends('layouts.app')

@section('content')
<div class="wrap fmyh" id="login">
    <div class="land">
        <p class="fhaniu"><a href="javascript:window.history.go(-1)"></a></p>
        登陆</div>
    <ul class="landlist lifl clear">
        <form method="post" action="{{url('bindphone')}}">
            <li>
                <input type="text" name="phone" :value="verifykey?verifykey:''" placeholder="请输入手机号码">
            </li>
            <li>
                <input type="text" name="verifycode" :value="verifycode?verifycode:''" placeholder="请输入手机验证码">
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
                'verifycode':'',
                'verifykey':'',
            },
            methods:{
                sendSmsVerify:function(is_send){
                    var phone = $('input[name="phone"]').val();
                    this.verifykey = phone;
                    if(phone == null || phone == ''){
                        layer.msg('<span style="font-size: 30px;">请填写手机号</span>');
                        return;
                    }
                    if(is_send){
                        $.ajax({
                            type: "GET",
                            url: "{{ url('sendSmsVerify') }}",
                            data: "phone="+phone,
                            success: function(data){
                                if(data.stat == 1){
                                    layer.msg('<span style="font-size: 30px;">发送成功</span>');
                                    console.log(data.code);
                                    login.verifycode = data.code;
                                }else{
                                    layer.msg('<span style="font-size: 30px;">'+data.msg+'</span>');
                                }
                            }
                        });
                    }
                    var obj = $('input[name="Verify"]');
                    countdown(obj);
                }
            }
        });

        $(function(){
            <?php
                $error = $verifycode = $verifykey = '';
                if(isset($errors)){
                    $error = $errors->first();
                }
                $input = session()->get('_old_input')??'';
                if(!empty($input)){
                    $verifycode = $input['verifycode'];
                    $verifykey = $input['phone'];
                }
            ?>
            var error = '{{$error}}';
            var verifycode = '{{$verifycode}}';
            var verifykey = '{{$verifykey}}';
            if(error){
                layer.msg('<span style="font-size: 30px;">'+error+'</span>');
            }
            if(verifycode){
                login.verifycode = verifycode;
            }
            if(verifykey){
                login.verifykey = verifykey;
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