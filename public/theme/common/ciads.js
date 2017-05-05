$(function ($) {

    $(".demore").click(function () {
        $(".detailstitle li").eq(2).addClass("active").siblings().removeClass("active");
        $(".detailscont .box").eq(2).show().siblings().hide();
    });

    $('.cpfllist li').click(function () {
        $(this).addClass('on').siblings('li').removeClass('on');
        var index = $(this).index();
        $('.j-cpfl').eq(index).show().siblings('.j-cpfl').hide();
    });
    $(".sxbt").click(function () {
        $(this).parent().parent().hide();
    });
    $(".sxbt1").click(function () {
        $(this).parent().parent().parent().hide();
    });
    $(".c02").click(function () {
        $('.j-ccgg').show();
    });
    $(".choice").click(function () {
        $(this).toggleClass("on")
    });
    $(".dispslist li .name").click(function () {
        $(this).addClass("on").parent().siblings().find(".name").removeClass("on");
    });
    /*点击弹出搜索层*/
    $(".j-search-input").click(function () {
        $("body").addClass("show-search-div");
        $(".search").css("z-index", "999999");
    });
    /*关闭搜索层*/
    $(".j-close-search").click(function () {
        $("body").removeClass("show-search-div");
    });

    /*数量加减*/
    $(".add").click(function () {
        var t = $(this).parent().find('input[class*=text_box]');
        t.val(parseInt(t.val()) + 1)
        setTotal();
    });
    $(".min").click(function () {
        var t = $(this).parent().find('input[class*=text_box]');
        t.val(parseInt(t.val()) - 1)
        if (parseInt(t.val()) < 0) {
            t.val(0);
        }
        setTotal();
    });
    function setTotal() {
        var s = 0;
        $("#tab li").each(function () {
            s += parseInt($(this).find('input[class*=text_box]').val()) * parseFloat($(this).find('span[class*=price]').text());
        });
        $("#total").html(s.toFixed(2));
    }

    setTotal();
    /*删除订单*/
    var that;
    $('.delete_box').on('click', function () {
        $(this).children('.delete_up').css(
            {
                transition: 'all 1s',
                'transformOrigin': "0 5px",
                transform: 'rotate(-30deg) translateY(2px)'
            }
        )
        $('.jd_win').show();
        that = $(this);
    });
    $('.cancle').on('click', function () {
        $('.jd_win').hide();
        $('.delete_up').css('transform', 'none')
    });

    $('.submit1').on('click', function () {
        that.parent().parent().parent().parent().remove();
        $('.jd_win').hide();
    });
    /*全选订单*/
    $(".fschoice").click(function () {
        if ($(this).find("input[name=all-sec]").prop("checked")) {
            $("input[name=cartpro]").each(function () {
                $(this).prop("checked", true);
            });

        }
        else {
            $("input[name=cartpro]").each(function () {
                if ($(this).prop("checked")) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }
    });


    $(".fschoice").click(function () {
        var nums = $(".shoplist li div").length;
        if ($(this).hasClass("on")) {
            $(this).addClass("on");
            //全选选中时，需要选中所有商品列表
            for (var i = 0; i < nums; i++) {
                $(".shoplist").children().eq(i).find(".choice").addClass("on");
            }

        } else {
            $(this).removeClass("on");

            //全选选中时，需要选中所有商品列表
            for (var i = 0; i < nums; i++) {
                $(".shoplist").children().eq(i).find(".choice").removeClass("on");
            }

        }

    });


});

function tabs(tabTit, on, tabCon) {
    $(tabCon).each(function () {
        $(this).children().eq(0).show();
    });
    $(tabTit).each(function () {
        $(this).children().eq(0).addClass(on);
    });
    $(tabTit).children().click(function () {
        $(this).addClass(on).siblings().removeClass(on);
        var index = $(tabTit).children().index(this);
        $(tabCon).children().eq(index).show().siblings().hide();
    });
}

tabs(".tab-hd,", "active", ".tab-bd");
