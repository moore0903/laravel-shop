<?php

namespace App\Admin\Controllers;

use App\Models\OrderDetail;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Request $request)
    {
        return Admin::content(function (Content $content) use($request) {

            $content->header('订单详情');
            $content->description('订单详情');

            $content->body($this->grid($request));
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

            $content->header('订单详情');
            $content->description('订单详情');

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

            $content->header('订单详情');
            $content->description('订单详情');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($request)
    {
        return Admin::grid(OrderDetail::class, function (Grid $grid) use($request){
            $grid->model()->where('order_id',$request['order_id']);
            $grid->product_title('商品名称');
            $grid->product_num('商品数量')->editable();
            $grid->product_price('商品价格')->editable();
            $grid->shop_item_catalog('所在分类');
            $grid->units('商品单位')->editable();
            $grid->disableExport();
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
        return Admin::form(OrderDetail::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('product_title', '商品名称');
            $form->text('product_num', '商品数量');
            $form->currency('product_price','现价');
            $form->text('units', '商品单位');

//            $form->display('created_at', 'Created At');
//            $form->display('updated_at', 'Updated At');
        });
    }
}
