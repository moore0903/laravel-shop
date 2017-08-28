<?php

namespace App\Admin\Controllers;

use App\Models\MobileOrders;

use App\Models\ThirdUser;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Request;

class MobileOrderController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('维修订单');
            $content->description('维修订单');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('维修订单');
            $content->description('维修订单');

            $content->body($this->form($id)->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('维修订单');
            $content->description('维修订单');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(MobileOrders::class, function (Grid $grid) {
            $grid->model()->where('type','=',Request::get('type'));
            $grid->model()->orderBy('id','desc');
            $grid->user_id('用户编号')->sortable();
            $grid->avatar('用户头像')->image('',80,80);
            $grid->realname('真实姓名')->sortable();
            $grid->nick_name('微信名称')->sortable();
            $grid->phone('联系方式')->sortable();
            $grid->address('具体位置')->sortable();
            if(\Request::get('type') == 1){
                $grid->column('手机型号')->display(function(){
                    return $this->brand.' '.$this->model;
                });
                $grid->order_time('预约时间')->sortable();
                $grid->color('手机颜色')->sortable();
                $grid->university('所在学校')->sortable();
                $grid->problem('手机问题')->problemPopover('right');
                $grid->remark('用户备注')->popover('right');
            }else{

                $grid->order_time('预约时间')->sortable();
                $grid->remark('电脑问题')->popover('right');
            }
            $grid->created_at('添加时间')->sortable();
            $grid->stat('订单状态')->editable('select', array_combine(MobileOrders::$stat_keys, MobileOrders::$stat_values));
            $grid->engineer('工程师')->display(function($engineer){
                if(!empty($engineer)){
                    $thirdUser = ThirdUser::where('standard_id','=',$engineer)->first();
                    return $thirdUser->nick_name;
                }else{
                    return '暂无';
                }
            });
            $grid->disableCreation();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=null)
    {
        return Admin::form(MobileOrders::class, function (Form $form) use($id) {
            $form->display('user_id', '用户编号');
            $form->display('realname', '真实姓名');
            $form->display('nick_name', '微信名称');
            $form->display('phone', '联系方式');
            $form->display('address', '具体位置');
            if($id){
                $order = MobileOrders::find($id);
                if($order->type == 1){
                    $form->display('brand', '手机品牌');
                    $form->display('model', '手机型号');
                    $form->display('order_time', '预约时间');
                    $form->display('color', '手机颜色');
                    $form->display('university', '所在学校');
                    $form->display('problem', '手机问题')->with(function($problem){
                        $blem = json_decode($problem,true);
                        return implode(',',$blem);
                    });
                    $form->display('remark', '用户备注');
                }else{
                    $form->display('order_time', '预约时间');
                    $form->display('remark', '电脑问题');
                }
            }

            $form->display('created_at', '添加时间');
            $form->select('stat','订单状态')->options(MobileOrders::$stat);
            $form->select('engineer','工程师')->options(ThirdUser::wxUserTags());
        });
    }
}
