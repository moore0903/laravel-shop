<?php

namespace App\Admin\Controllers;

use App\Models\Catalog;

use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CatalogsController extends Controller
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

            $content->header('分类管理');
            $content->description('分类管理');

            $content->body(Catalog::tree());
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

            $content->header('创建分类目录');
            $content->description('创建分类目录');


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
        return Admin::grid(Catalog::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Catalog::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', '标题');
            $form->number('order', '排序');
            $form->select('parent_id', '上级栏目')->options(Catalog::selectOptions());
            $form->text('url', '链接地址')->placeholder('选填 直接跳转地址');

            $form->select('catalog_tpl', '栏目模板')->options(Catalog::dirToArray());
            $form->select('content_tpl', '内容模板')->options(Catalog::dirToArray());

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
