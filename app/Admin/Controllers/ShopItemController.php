<?php

namespace App\Admin\Controllers;

use App\Models\Catalog;
use App\Models\ShopItem;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ShopItemController extends Controller
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

            $content->header('商品列表');
            $content->description('商品列表');

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

            $content->header('商品添加');
            $content->description('商品添加');

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

            $content->header('商品修改');
            $content->description('商品修改');

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
        return Admin::grid(ShopItem::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->title('标题')->editable();
            $grid->catalog()->title('分类');
            $grid->count('库存')->editable();
            $grid->price('现价')->editable();

            $states = [
                'on' => ['text' => 'YES'],
                'off' => ['text' => 'NO'],
            ];

            $grid->column('是否显示')->switchGroup([
                'show' => '显示'
            ],$states);

            $grid->column('是否推荐')->switchGroup([
                'recommend' => '推荐'
            ],$states);

            $grid->sort('排序号')->editable();

            $grid->created_at('添加时间');
            $grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ShopItem::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', '标题');
            $form->text('short_title', '简短介绍');
            $form->select('catalog_id','分类')->options(Catalog::selectOptions());
            $form->number('count', '库存')->default('100');
//            $form->currency('original_price', '原价')->symbol('￥');
            $form->currency('price', '现价')->symbol('￥');
            $form->number('unit_number','单位数量');
            $form->select('units','计量单位')->options(ShopItem::$units);
//            $form->currency('shipping', '运费')->symbol('￥')->default('0.00');
            $form->image('img', '图片');
            $form->editor('detail', '内容')->attribute(['style' => 'height:400px;max-height:500px;']);

            $form->number('sort', '排序')->default(100);
//            $form->multipleImage('images', '图片集合');

            $form->switch('recommend','推荐')->default(false);

            $form->switch('show','显示')->default(true);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
