@extends('layouts.app')

@section('content')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $js->config(array('getLocation'), false) ?>);
        wx.ready(function(){
            wx.getLocation({
                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res) {
                    $.get("{{ url('ajaxGetGeocoder/') }}", { latitude: res.latitude, longitude: res.longitude },
                        function(data){
                            $('input[name="s_user_site"]').val(data);
                        });
                },
                cancel: function (res) {
                    alert('用户拒绝授权获取地理位置');
                }
            });
        });
    </script>
    <header class="ui-header ui-header-style">
        <i class="am-icon-angle-left am-icon-fw" onclick="history.back()"></i>
        <h1>确认订单</h1>
    </header>
    <section class="ui-container">
        <div class="problem-info">
            品牌：<span id="phone-brand-name">{{ $mobileModel->brand->brand_name }}</span>
            机型：<span id="phone-type-name">{{ $mobileModel->model_name }}</span>
        </div>
        <div class="problem-list" id="problem_list">
            @foreach($problems as $problem)
            <div class="problem-item">{{ $problem }}</div>
            @endforeach
        </div>
        <form action="{{ url('mobileAddOrder') }}" method="post" class="am-form am-form-horizontal order_form" id="order_form">
            <div class="am-form-group">
                <input type="text" name="s_user_name" placeholder="姓名" required>
            </div>
            <div class="am-form-group">
                <input type="text" name="s_user_tel" placeholder="联系电话" required>
            </div>
            <div class="am-form-group">
                <input type="text" name="s_phone_color" placeholder="手机颜色" required>
            </div>
            <div class="am-form-group school-form-group">
                <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#my-schools'}">
                    <i class="am-icon-map-marker am-fl"></i>
                    <span>请选择学校</span>
                </button>
                <input type="hidden" name="s_user_school" value="武汉理工" placeholder="请输入选择学校" required>
            </div>
            <div class="am-form-group site-form-group">
                <i class="am-icon-map-marker am-fl"></i>
                <input type="text" name="s_user_site" placeholder="您的位置" required>
            </div>
            <div class="am-form-group house-form-group">
                <i class="am-icon-building am-fl"></i>
                <input type="text" name="s_house_number" placeholder="请填写您的门牌号（具体地址）" required>
            </div>
            <div class="am-form-group time-form-group">
                <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#my-date'}">
                    <span id="s_date">选择上门时间</span>
                    <span id="s_date_time"></span>
                    <i class="am-icon-angle-right am-fr am-margin-right"></i>
                </button>
                <input type="hidden" name="s_date" value="2017-08-09" placeholder="请选择上门时间" required>
                <input type="hidden" name="s_date_time" value="9:00-11:00" placeholder="请选择上门时间" required>
            </div>
            <div class="form-desc-box">
                <input type="hidden" name="problem" value="{{ json_encode($problems) }}"/>
                <textarea type="text" name="s_phone_desc" rows="4" class="s_phone_desc" placeholder="更多需求（最多只能输入50个字）"></textarea>
            </div>
            <div>
                <div class="am-u-sm-12 form-tips">
                    请您知晓：软件问题免费上门解决，若硬件损坏，则需要您支付更换硬件的成本费用。
                </div>
                <div class="am-u-sm-12">
                    <input type="hidden" name="model_id" value="{{ $mobileModel->id }}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button class="am-btn am-btn-danger form-submit-btn am-round" id="orderSubmit">立即预约</button>
                </div>
            </div>
        </form>
        <!--order-form end-->

        <!--表单提示框-->
        <div class="am-modal am-modal-alert" tabindex="-1" id="order_form-modal">
            <div class="am-modal-dialog">
                <div class="am-modal-bd" id="order-modal-tips"></div>
                <div class="am-modal-footer">
                    <span class="am-modal-btn">确定</span>
                </div>
            </div>
        </div>
        <!--order_form-modal end-->
        <div class="am-modal am-modal-no-btn am-modal-list" id="my-schools">
            <div class="am-modal-dialog">
                <div class="am-modal-hd">请选择学校
                    <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                </div>
                <div class="sel-action-list">
                    <ul class="am-list">
                        @foreach($universities as $university)
                        <li class="sel-item"><a>{{ $university->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--my-schools end-->
        <!-- 上门日期选择 -->
        <div class="am-modal am-modal-no-btn am-modal-list" id="my-date">
            <div class="am-modal-dialog">
                <div class="am-modal-hd">请选择日期
                    <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                </div>
                <div class="sel-action-list">
                    <ul class="am-list">
                        @foreach(\App\Models\MobileOrders::datatime() as $time)
                        <li class="sel-item"><a>{{ $time }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--my-date end-->
        <div class="am-modal am-modal-no-btn am-modal-list" id="my-time">
            <div class="am-modal-dialog">
                <div class="am-modal-hd">
                    <span>2017-08-03（今天）</span>
                    <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                </div>
                <div class="sel-action-list">
                    <ul class="am-list">
                        <li class="sel-item"><a>09:00-11:00</a></li>
                        <li class="sel-item"><a>11:00-13:00</a></li>
                        <li class="sel-item"><a>13:00-15:00</a></li>
                        <li class="sel-item"><a>15:00-17:00</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--my-date end-->

    </section>
@endsection

@section('script')
    <script>
        var $order_checkBtn = $('#orderSubmit');
        var $order_alert_modal = $('#order_form-modal');
        var $order_school_modal = $('#my-schools');
        var $order_date_modal = $('#my-date');
        var $order_time_modal = $('#my-time');
        var $order_form= $('#order_form');

        $order_form.validator({
            H5validation: false,
            validateOnSubmit: false,
            ignore: ''
        });

        /* 表单元素 */
        var $user_name = $order_form.find('input[name=s_user_name]');
        var $user_tel = $order_form.find('input[name=s_user_tel]');
        var $phone_color = $order_form.find('input[name=s_phone_color]');
        var $user_school = $order_form.find('input[name=s_user_school]');
        var $user_site = $order_form.find('input[name=s_user_site]');
        var $house_number = $order_form.find('input[name=s_house_number]');
        var $s_date = $order_form.find('input[name=s_date]');
        var $s_date_time = $order_form.find('input[name=s_date_time]');
        var $s_desc = $order_form.find('.s_phone_desc');
        var $order_alert_tips = $('#order-modal-tips');

        $order_checkBtn.bind('click', function(e){
            e.preventDefault();
            // console.log($order_form);
            if(!$user_name.val() || !$user_tel.val() || !$phone_color.val() || !$house_number.val()){
                if(!$user_name.val()){
                    $order_alert_tips.html('请先完善您的信息（姓名）');
                }else if(!$user_tel.val()){
                    $order_alert_tips.html('请先完善您的信息（联系电话）')
                }else if(!$phone_color.val()){
                    $order_alert_tips.html('请先完善您的信息（手机颜色）')
                }else if(!$house_number.val()){
                    $order_alert_tips.html('请先完善您的信息（门牌号码）')
                }
                $order_alert_modal.modal();
                return false;
            }
            if(!$user_school.val()){
                $order_alert_tips.html('请先选择您的学校');
                $order_alert_modal.modal();
                return false;
            }
            if(!$user_site.val()){
                $order_alert_tips.html('请先选择您的地址');
                $order_alert_modal.modal();
                return false;
            }
            if(!$s_date.val() || !$s_date_time.val()){
                $order_alert_tips.html('请先选择您的上门具体日期和时间段');
                $order_alert_modal.modal();
                return false;
            }
            if($s_desc.val()){
                if($s_desc.val().length > 50){
                    $order_alert_tips.html('需求描述的文本长度不超过50个字');
                    $order_alert_modal.modal();
                    return false;
                }
            }

            $order_alert_tips.html("您已成功预约'+ <br/> +'如有疑问请拨打客服电话18627763575");
            $order_alert_modal.modal();

            $order_alert_modal.on('closed.modal.amui', function(){
                $("#order_form").submit();
            });

        });

        /* 手机 选择学校 */
        $order_school_modal.find('.sel-item').click(function(e){
            $user_school.val($(this).text());
            $user_school.siblings('button').find('span').text($(this).text());
            /* 关闭模态框 */
            $order_school_modal.modal('close');
        });

        /* 手机 选择时间 */
        $order_date_modal.find('.sel-item').click(function(e){
            $s_date.val($(this).text());
            $('#my-time').find('.am-modal-hd span').text($(this).text());
            $s_date.siblings('button').find('#s_date').text($(this).text());
            /* 关闭日期模态框 */
            $order_date_modal.modal('close');
            /* 打开时间 */
            $order_time_modal.modal();
        });

        /* 手机 选择具体时间段 */
        $order_time_modal.find('.sel-item').click(function(e){
            // console.log($(this).text());
            $s_date_time.val($(this).text());
            $s_date.siblings('button').find('#s_date_time').text($(this).text());

            /* 关闭时间模态框 */
            $order_time_modal.modal('close');
        })
    </script>
@endsection