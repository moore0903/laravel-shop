var phoneBrandList = [
    {
        name: 'iPhone',
        id: 1,
    },{
        name: 'iPad',
        id: 2,
    },{
        name: '三星',
        id: 3,
    },{
        name: '华为',
        id: 4,
    },{
        name: 'OPPO',
        id: 5,
    },{
        name: 'Vivo',
        id: 6,
    },{
        name: '小米',
        id: 7,
    },{
        name: '魅族',
        id: 8,
    }
];
var phone_typeList = [
    {
        name: 'iPhone6',
        id: 1,
    },{
        name: 'iPhone6 Plus',
        id: 2,
    },{
        name: 'iPhone6s',
        id: 3,
    },{
        name: 'iPhone6s Plus',
        id: 4,
    },{
        name: 'iPhone7',
        id: 5,
    },{
        name: 'iPhone7 Plus',
        id: 6,
    },{
        name: 'iPhoneSE',
        id: 7,
    },{
        name: 'iPhone5s',
        id: 8,
    },{
        name: 'iPhone5s',
        id: 8,
    }
];

var phoneTypeList = [];

var barndLi_html = '', typeLi_html = '';
var sel_phone_brandId, sel_phone_brandName, sel_phone_typeId, sel_phone_typeName;

/* 手机品牌点击 */
function brandClick(){
    var $this = $(this);
    var jump_url = $this.find('a').attr('href');
    sel_phone_brandId = $this.attr('data-id');
    sel_phone_brandName = $this.attr('data-name');
    window.location.href = jump_url;
    sessionStorage.setItem("phone_brandId", sel_phone_brandId);
    sessionStorage.setItem("phone_brandName", sel_phone_brandName);
}

/* 手机类型点击 */
function phoneTypeClick(){
    var $this = $(this);
    var jump_url = $this.find('a').attr('href');
    sel_phone_typeId = $this.attr('data-id');
    sel_phone_typeName = $this.attr('data-name');
    window.location.href = jump_url;
    sessionStorage.setItem("phone_typeId", sel_phone_typeId);
    sessionStorage.setItem("phone_typeName", sel_phone_typeName);
}


/* 加载手机品牌的数据 */
var current_path = window.location.pathname;
console.log(current_path);
if(current_path.indexOf('/gaoxiaoxiu/views/phone/index.html') >=0){
    if(phoneBrandList && phoneBrandList.length > 0) {
        phoneBrandList.forEach(function(item, index){
            barndLi_html += '<div class="brand-item" data-id="'+item.id+'" data-name="'+item.name+'">' +
                '<a href="views/phone/type.html">' +
                ''+item.name+'<i class="am-icon-angle-right am-fr am-margin-right"></i>' +
                '</a>' +
                '</div>'
        });
        $('#brand_list').append(barndLi_html);
        $('.brand-item').bind('click',brandClick)
    }
} else {
    barndLi_html = '';
}

/* 加载手机类型的数据 */
if(current_path.indexOf('/gaoxiaoxiu/views/phone/type.html')>=0){
    if(sessionStorage.phone_brandId){
        sel_phone_brandId = parseInt(sessionStorage.getItem('phone_brandId'));
    }
    // console.log(typeof sel_phone_brandId);
    switch (sel_phone_brandId){
            case 1:
                phoneTypeList = phone_typeList;
                break;
            case 2:
                phone_typeList.forEach(function(item, index){
                    item.name = 'iPad'+ item.id;
                });
                phoneTypeList = phone_typeList;
                break;
            case 3:
                phone_typeList.forEach(function(item, index){
                    item.name = '三星Glaxy'+ item.id;
                });
                phoneTypeList = phone_typeList;
                break;
            case 4:
                phone_typeList.forEach(function(item, index){
                    item.name = '华为 荣耀'+ item.id;
                });
                phoneTypeList = phone_typeList;
                break;
            case 5:
                phone_typeList.forEach(function(item, index){
                    item.name = 'OPPO R'+ item.id;
                });
                phoneTypeList = phone_typeList;
                break;
            case 6:
                phone_typeList.forEach(function(item, index){
                    item.name = 'Vivo Xplay'+ item.id;
                });
                phoneTypeList = phone_typeList;
                break;
            case 7:
                phone_typeList.forEach(function(item, index){
                    item.name = '小米'+ item.id;
                });
                phoneTypeList = phone_typeList;
                break;
            case 8:
                phone_typeList.forEach(function(item, index){
                    item.name = '魅族X'+ item.id;
                });
                phoneTypeList = phone_typeList;
                break;
        }
    if(phoneTypeList.length > 0){
        phoneTypeList.forEach(function(item, index){
            typeLi_html += '<div class="brand-item" data-id="'+item.id+'" data-name="'+item.name+'">' +
                '<a href="views/phone/problem.html">' +
                ''+item.name+'<i class="am-icon-angle-right am-fr am-margin-right"></i>' +
                '</a>' +
                '</div>'
        });
        $('#type_list').append(typeLi_html);
        $('.brand-item').bind('click',phoneTypeClick)
    } else {

    }
} else {
    typeLi_html = '';
}

/* 手机 出了什么问题的数据页面 */
if(current_path.indexOf('/gaoxiaoxiu/views/phone/problem.html')>= 0){
    var $problems_modal = $('#problems-modal');
    var $problems_form= $('#problem_form');

    $problems_form.validator({
        H5validation: false,
        validateOnSubmit: false,
        submit: function() {
            // console.log(this);
            var formValidity = this.isFormValid();
            if(!formValidity){
                $problems_modal.modal();
                return false;
            }
        }
    });
}

/* 手机 确认订单页面 */
if(current_path.indexOf('/gaoxiaoxiu/views/phone/order.html')>=0){
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
    var $s_desc = $order_form.find('input[name=s_desc]');
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

        if(true){
            $order_alert_tips.html("您已成功预约'+ <br/> +'如有疑问请拨打客服电话44130028");
            $order_alert_modal.modal();
        }

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
}

/* 电脑确认报修问题  */
if(current_path.indexOf('/gaoxiaoxiu/views/PC/index.html')>=0){
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
    var $pc_desc = $pc_order_form.find('input[name=pc_desc]');
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
}

/* 个人中心页面 */
if(current_path.indexOf('views/usercenter/index.html')>=0){
    $('.toggle-show-logs-btn').bind('click', function(e){
        var _this = $(this);

        _this.find('i').toggleClass('active');
        _this.siblings('.tips').slideToggle(1);
        _this.siblings('.logs-list').find('.log-item').toggleClass('open');

    })
}

