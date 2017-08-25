@extends('layouts.app')

@section('content')
    <header class="ui-header ui-header-style">
        <i class="am-icon-angle-left am-icon-fw" onclick="history.back()"></i>
        <h1>确认订单</h1>
    </header>
    <section class="ui-container">
        <form action="{{ url('pcAddOrder') }}" method="post" class="am-form am-form-horizontal order_form" id="pc_order_form">
            <div class="form-desc-box pb-12">
                <textarea type="text" name="pc_desc" rows="7" class="pc_desc" placeholder="请详细描述您的电脑问题" required></textarea>
            </div>
            <div class="am-form-group">
                <input type="text" name="pc_user_name" placeholder="姓名" required>
            </div>
            <div class="am-form-group">
                <input type="text" name="pc_user_tel" placeholder="联系电话" required>
            </div>
            <div class="am-form-group school-form-group">
                <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#pc-schools'}">
                    <i class="am-icon-map-marker am-fl"></i>
                    <span>请选择学校</span>
                </button>
                <input type="hidden" name="pc_user_school" value="武汉理工" placeholder="请输入选择学校" required>
            </div>
            <div class="am-form-group site-form-group">
                <i class="am-icon-map-marker am-fl"></i>
                <input type="text" name="pc_user_site" placeholder="您的位置" required>
            </div>
            <div class="am-form-group house-form-group">
                <i class="am-icon-building am-fl"></i>
                <input type="text" name="pc_house_number" placeholder="请填写您的门牌号（具体地址）" required>
            </div>
            <div class="am-form-group time-form-group">
                <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#pc-date'}">
                    <span id="pc_date">选择上门时间</span>
                    <span id="pc_date_time"></span>
                    <i class="am-icon-angle-right am-fr am-margin-right"></i>
                </button>
                <input type="hidden" name="pc_date" value="2017-08-09" placeholder="请选择上门时间" required>
                <input type="hidden" name="pc_date_time" value="9:00-11:00" placeholder="请选择上门时间" required>
            </div>
            <div>
                <div class="am-u-sm-12 form-tips">
                    请您知晓：软件问题免费上门解决，若硬件损坏，则需要您支付更
                    换硬件和维修的成本费用。
                </div>
                <div class="am-u-sm-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button class="am-btn am-btn-danger form-submit-btn am-round" id="pc_orderSubmit">立即预约</button>
                </div>
            </div>
        </form>
        <!--order-form end-->

        <!--表单提示框-->
        <div class="am-modal am-modal-alert" tabindex="-1" id="pc_form_alert_modal">
            <div class="am-modal-dialog">
                <div class="am-modal-bd" id="pc_order-modal-tips"></div>
                <div class="am-modal-footer">
                    <span class="am-modal-btn">确定</span>
                </div>
            </div>
        </div>
        <!--order_form-modal end-->
        <div class="am-modal am-modal-no-btn am-modal-list" id="pc-schools">
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
        <div class="am-modal am-modal-no-btn am-modal-list" id="pc-date">
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
        <div class="am-modal am-modal-no-btn am-modal-list" id="pc-time">
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
        var $pc_order_checkBtn = $('#pc_orderSubmit');
        var $pc_order_alert_modal = $('#pc_form_alert_modal');
        var $pc_order_school_modal = $('#pc-schools');
        var $pc_order_date_modal = $('#pc-date');
        var $pc_order_time_modal = $('#pc-time');
        var $pc_order_form= $('#pc_order_form');

        $pc_order_form.validator({
            H5validation: false,
            validateOnSubmit: false,
            ignore: ''
        });

        /* 表单元素 */
        var $pc_user_name = $pc_order_form.find('input[name=pc_user_name]');
        var $pc_user_tel = $pc_order_form.find('input[name=pc_user_tel]');
        var $pc_user_school = $pc_order_form.find('input[name=pc_user_school]');
        var $pc_user_site = $pc_order_form.find('input[name=pc_user_site]');
        var $pc_house_number = $pc_order_form.find('input[name=pc_house_number]');
        var $pc_date = $pc_order_form.find('input[name=pc_date]');
        var $pc_date_time = $pc_order_form.find('input[name=pc_date_time]');
        var $pc_desc = $pc_order_form.find('.pc_desc');
        var $pc_order_alert_tips = $('#pc_order-modal-tips');

        $pc_order_checkBtn.bind('click', function(e){
            e.preventDefault();
            // console.log($order_form);
            if(!$pc_desc.val()){
                $pc_order_alert_tips.html('请详细描述您的电脑问题');
                $pc_order_alert_modal.modal();
                return false;
            }
            if(!$pc_user_name.val() || !$pc_user_tel.val() || !$pc_house_number.val()){
                if(!$pc_user_name.val()){
                    $pc_order_alert_tips.html('请先完善您的信息（姓名）');
                }else if(!$pc_user_tel.val()){
                    $pc_order_alert_tips.html('请先完善您的信息（联系电话）')
                }else if(!$pc_house_number.val()){
                    $pc_order_alert_tips.html('请先完善您的信息（门牌号码）')
                }
                $pc_order_alert_modal.modal();
                return false;
            }
            if(!$pc_user_school.val()){
                $pc_order_alert_tips.html('请先选择您的学校');
                $pc_order_alert_modal.modal();
                return false;
            }
            if(!$pc_user_site.val()){
                $pc_order_alert_tips.html('请先选择您的地址');
                $pc_order_alert_modal.modal();
                return false;
            }
            if(!$pc_date.val() || !$pc_date_time.val()){
                $pc_order_alert_tips.html('请先选择您的上门具体日期和时间段');
                $pc_order_alert_modal.modal();
                return false;
            }

            $pc_order_alert_tips.html("您已成功预约'+ <br/> +'如有疑问请拨打客服电话18627763575");
            $pc_order_alert_modal.modal();

            $pc_order_alert_modal.on('closed.modal.amui', function(){
                $("#pc_order_form").submit();
            });

        });

        /* 电脑 选择学校 */
        $pc_order_school_modal.find('.sel-item').click(function(e){
            $pc_user_school.val($(this).text());
            $pc_user_school.siblings('button').find('span').text($(this).text());
            /* 关闭模态框 */
            $pc_order_school_modal.modal('close');
        });

        /* 电脑 选择时间 */
        $pc_order_date_modal.find('.sel-item').click(function(e){
            $pc_date.val($(this).text());
            $pc_order_time_modal.find('.am-modal-hd span').text($(this).text());
            $pc_date.siblings('button').find('#pc_date').text($(this).text());
            /* 关闭日期模态框 */
            $pc_order_date_modal.modal('close');
            /* 打开时间 */
            $pc_order_time_modal.modal();
        });

        /* 电脑 选择具体时间段 */
        $pc_order_time_modal.find('.sel-item').click(function(e){
            // console.log($(this).text());
            $pc_date_time.val($(this).text());
            $pc_date.siblings('button').find('#pc_date_time').text($(this).text());

            /* 关闭时间模态框 */
            $pc_order_time_modal.modal('close');
        })
    </script>
@endsection