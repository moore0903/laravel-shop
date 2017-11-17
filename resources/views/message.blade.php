@extends('layouts.app')


@section('content')
    <div class="nfdm">
        <div class="nbanner scroll">
            <ul>
                @foreach($banners as $banner)
                    <li><a href="#" style=" background:url({{ asset('upload/'.$banner->img) }}) no-repeat center top;"></a></li>
                @endforeach
            </ul>
        </div>
        <div class="wrap" style="position:relative; z-index:999;">
            <div class="nphone"></div>
        </div>
    </div>
    <div class="wrap fmyh clear">
        <div class="side fl">
            <div class="pro_case">
                <div class="title">{{ $top_catalog->title }}</div>
                <ul class="lifl clear">
                    @foreach($catalog_set as $item)
                        <li @if($item->id == $catalog->id)  class="on" @endif><a href="{{ url('/catalog/'.$item->id) }}">{{ $item->title }}</a></li>
                    @endforeach
                    @if($top_catalog->id == 29)
                        <li @if(Route::currentRouteNamed('message')) class="on" @endif><a href="{{ url('/message') }}">在线留言</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="main fr">
            <div class="ny_case">
                <div class="title">在线留言<i class="ttuc">contact us </i></div>
                <ul class="msglist lifl clear">
                    <form name="form1" action="{{ url('/message_submit') }}" class="demoform" method="post">
                        <li>
                            <p class="name fl">您的姓名</p>
                            <p class="nr fl">
                                <input type="text" name="name" datatype="s2-8" errormsg="姓名至少2个字符,最多8个字符！"/>
                            </p>
                        </li>
                        <li>
                            <p class="name fl">联系电话</p>
                            <p class="nr fl">
                                <input type="text" name="phone" datatype="m" errormsg="请填写正确的手机号" />
                            </p>
                        </li>
                        <li>
                            <p class="name fl">所在城市</p>
                            <p class="nr fl">
                                <input type="text" name="city" datatype="s2-8" errormsg="城市至少2个字符,最多8个字符！"/>
                            </p>
                        </li>
                        <li>
                            <p class="name fl">面积大小</p>
                            <p class="nr fl">
                                <input type="text" name="area" datatype="*2-8" errormsg="面积至少2个字符,最多8个字符！"/>
                            </p>
                        </li>
                        <li>
                            <p class="name fl">验证码</p>
                            <p class="nr fl">
                                <img src="{{ $src }}" id="captcha"/>
                            </p>
                        </li>
                        <li>
                            <p class="name fl">验证码</p>
                            <p class="nr fl">
                                <input type="text" name="captcha"/>
                            </p>
                        </li>
                        <li>
                            <p class="name fl">留言内容</p>
                            <p class="nr1 fl">
                                <textarea name="contents" cols="" rows=""></textarea>
                            </p>
                        </li>
                        <li class="msg">
                            <p class="anniulbg fl"><input name="Submit" type="submit" value="提交留言" /></p>
                            <p class="anniulbg fl"><input name="" type="reset" value="重置留言" /></p>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        </li>
                    </form>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        setNav({{ $set_nev }});
        $(".demoform").Validform({
            tiptype:1,
            ajaxPost:true,
            callback:function(data){
                if(data.status === 'n'){
                    $.Showmsg(data.info);
                    return false;
                }else{
                    $.Showmsg('提交成功');
                    location.reload(true);
                }
            }
        });

        $('#captcha').on("click",function(){
            $.get("{{ url('/captcha_re') }}", function(data){
                $('#captcha').attr({src:data.src});
            });
        });

    </script>
@endsection