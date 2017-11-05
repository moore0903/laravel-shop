<?php

namespace App\Admin\Controllers;

use App\Models\Catalog;
use App\Models\Page;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PagesController extends Controller
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

            $content->header('单页列表');
            $content->description('单页列表');

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

            $content->header('单页修改');
            $content->description('单页修改');

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

            $content->header('单页添加');
            $content->description('单页添加');

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
        return Admin::grid(Page::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->title('标题');
//            $grid->en_title('英文标题');
            $grid->catalog()->title('分类');

            $grid->created_at('创建时间');
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
        return Admin::form(Page::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('catalog_id','分类')->options(Catalog::selectOptions());

            $form->text('title', '标题');
//            $form->text('en_title', '英文标题');

            $form->editor('content', '内容')->attribute(['style' => 'height:400px;max-height:500px;']);
//
//            $form->display('created_at', 'Created At');
//            $form->display('updated_at', 'Updated At');
        });
    }
}
