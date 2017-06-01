<?php

namespace App\Admin\Controllers;

use App\Models\SecKill;

use App\Models\ShopItem;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class SecKillController extends Controller
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

            $content->header('秒杀管理');
            $content->description('秒杀管理');

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

            $content->header('秒杀管理');
            $content->description('秒杀管理');

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

            $content->header('秒杀管理');
            $content->description('秒杀管理');

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
        return Admin::grid(SecKill::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->shop_item_id('商品名称')->value(function($shop_item_id){
                return ShopItem::find($shop_item_id)->title;
            });
            $grid->start_time('开始时间');
            $grid->start_time('结束时间');
            $grid->sec_kill_price('秒杀价');

//            $grid->created_at();
//            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(SecKill::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->number('shop_item_id', '商品id');
            $form->datetimeRange('start_time', 'end_time', '秒杀时间选择');
            $form->currency('sec_kill_price', '秒杀价')->symbol('￥');

//            $form->display('created_at', 'Created At');
//            $form->display('updated_at', 'Updated At');
        });
    }
}
