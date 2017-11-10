@extends('layouts.app')


@section('content')
    <div class="vipkuai">
        <div class="wrap fmyh clear">
            <div class="vipnrlist">
                <div class="title">会员登录</div>
                <ul class="lifl clear">
                    <form name="form1" action="{{ url('/login') }}" class="demoform" method="post">
                        <li>
                            <p class="name fl">用户名：</p>
                            <p class="nr fl">
                                <input name="name" type="text" datatype="s2-24" errormsg="用户名至少2个字符,最多24个字符！"/>
                            </p>
                        </li>
                        <li>
                            <p class="name fl">密&nbsp;&nbsp;&nbsp;码：</p>
                            <p class="nr fl">
                                <input name="password" type="password"/>
                            </p>
                        </li>
                        <li>
                            <p class="name fl">验证码</p>
                            <p class="nr fl">
                                <img src="{{ $src }}" id="captcha"/>
                            </p>
                        </li>
                        <li>
                            <p class="name fl">验证码：</p>
                            <p class="nr fl">
                                <input name="captcha" type="text"/>
                            </p>
                        </li>
                        <li>
                            <p class="vipaniu vipaniu1 fl">
                                <input name="" type="submit" value="登 录"/>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            </p>
                            <p class="vipaniu fl">
                                <input name="" type="reset" value="重 置"/>
                            </p>
                        </li>
                    </form>
                </ul>
                <div class="vipcont"> 您无法进入会员，请先登录！如果您不是我们的会员，请立即<a href="{{ url('/message') }}">注册</a><br/>
                    <br/>
                    我们的会员有以下功能：<br/>
                    1、修改您的会员注册资料；<br/>
                    2、主用私人留言簿，您可在此给我们留言和查看我们的回复。<br/>
                    3、可以看到非会员所查看不到的产品信息
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav(1);

        $(".demoform").Validform({
            tiptype: 1,
            ajaxPost: true,
            callback: function (data) {
                if (data.status === 'n') {
                    $.Showmsg(data.info);
                    $('#captcha').trigger('click');
                    return false;
                } else {
                    $.Showmsg('提交成功');
                    window.location.href = "{{ url('/user/info') }}";
                }
            }
        });

        $('#captcha').on("click", function () {
            $.get("{{ url('/captcha_re') }}", function (data) {
                $('#captcha').attr({src: data.src});
            });
        });
    </script>
@endsection