@extends('layouts.app')

@section('header')

@endsection

@section('banner')

@endsection

@section('search')

@endsection

@section('content')
    <div class="membertitle fmyh">
        <p class="fh"><a href="javascript:window.history.go(-1)"></a></p>
        购物车</div>
    <form method="post" action="{{url('/order/add')}}" onsubmit="return check()">
        <ul class="memberlist fmyh lifl clear">
            <li class="me1">
                <p class="name fl">填写姓名</p>
                <p class="nr fl"><input name="realname" value="{{$address->realname}}" type="text"></p>
            </li>
            <li class="me2">
                <p class="name fl">联系电话</p>
                <p class="nr fl"><input name="phone" value="{{$address->phone}}" type="text"></p>
            </li>
            <li class="me3">
                <p class="name fl">公司名称</p>
                <p class="nr fl"><input name="company_name" value="{{$address->company_name}}" type="text"></p>
            </li>
            <li class="me4">
                <p class="name fl">配送地址</p>
                <p class="nr fl"><input name="address" value="{{$address->address}}" type="text"></p>
            </li>
        </ul>
        <div class="memberbottom">
            <input type="submit" value="点击保存">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
    </form>
    <script>
        function check(){
            $realname = $('input[name="realname"]').val()
            $phone = $('input[name="phone"]').val()
            $company_name = $('input[name="company_name"]').val()
            $address = $('input[name="address"]').val()
            if($realname == null || $realname == ''){
                alert('请填写姓名');
            }else if($phone == null || $phone == ''){
                alert('请填写电话');
            }else if($company_name == null || $company_name == ''){
                alert('请填写公司名称');
            }else if($address == null || $address == ''){
                alert('请填写配送地址');
            }
        }
    </script>
@endsection

@section('bottom_bar')

@endsection