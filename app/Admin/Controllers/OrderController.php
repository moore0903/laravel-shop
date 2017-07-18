<?php

namespace App\Admin\Controllers;

use App\Models\Order;

use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Table;

class OrderController extends Controller
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

            $content->header('订单管理');
            $content->description('订单管理');

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

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
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

            $content->header('header');
            $content->description('description');

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
        return Admin::grid(Order::class, function (Grid $grid) {
            $grid->model()->orderBy('id','desc');
            $grid->filter(function($filter) {
                $filter->between('created_at', '下单时间')->datetime();
            });
            $grid->id('ID');
            $grid->serial('订单编号')->editable();
            $grid->realname('收货人')->editable();
            $grid->phone('联系电话')->editable()->prependIcon('phone');
            $grid->address('收货地址')->editable('textarea');
//            $grid->stat('当前状态')->editable('select', array_combine(Order::$stat_keys, Order::$stat_values));
//            $grid->total('原价');
//            $grid->discount('优惠')->editable();
            $grid->totalpay('现价')->editable();
//            $grid->paytype('支付类型');
//            $grid->totalget('支付金额')->editable();
            $grid->column('订单详情')->expand(function () {
                $details = $this->details;
                $details = $details->map(function($item){
                    $data = ['product_title'=>$item['product_title'],'product_num'=>$item['product_num'],'product_price'=>$item['product_price']];
                    foreach(array_diff_assoc($item->toArray(),$data) as $key => $value){
                        unset($item[$key]);
                    }
                    return $item;
                })->prepend(['商品名称','购买数量','商品价格'])->toArray();
                return new Table([], $details);
            }, '查看详情');

            $grid->created_at('下单时间');
//            $grid->column('物流信息')->express(function(){
//                return [$this->express_company, $this->express_no];
//            });
//            $grid->filter(function ($filter) {
//                $filter->like('realname','收货人');
//                $filter->like('phone','收货电话');
//                $filter->is('stat', '状态')->select(Order::$stat);
//            });
            $grid->disableCreation();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Order::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('user_id','用户')->with(function($user_id){
                return User::find($user_id)->name;
            });
            $form->text('serial','编号');
            $form->text('address','收货地址');
            $form->text('realname','收货人');
            $form->mobile('phone','联系人电话');
//            $form->select('stat','订单状态')->options(Order::$stat);
//            $form->display('total', '原价');
//            $form->currency('discount','优惠');
            $form->currency('totalpay','现价');
//            $form->display('paytype','支付类型');
//            $form->display('trade_no','支付编号');
//            $form->display('notify_time','支付时间');
//            $form->display('totalget','支付金额');
//            $form->textarea('remark','用户备注');
            $form->textarea('memo','管理员备注');
//            $form->select('express_company','快递公司')->options(Order::$express_company);
//            $form->text('express_no','快递单号');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
