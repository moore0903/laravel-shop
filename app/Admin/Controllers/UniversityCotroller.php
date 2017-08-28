<?php

namespace App\Admin\Controllers;

use App\Models\Universities;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UniversityCotroller extends Controller
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

            $content->header('高校管理');
            $content->description('高校管理');

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

            $content->header('高校管理');
            $content->description('高校管理');

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

            $content->header('高校管理');
            $content->description('高校管理');

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
        return Admin::grid(Universities::class, function (Grid $grid) {

            $grid->name('高校名称')->sortable();

            $grid->created_at('添加时间')->sortable();

            $grid->sort('排序')->editable()->sortable();

            $grid->filter(function($filter){
                // 禁用id查询框
                $filter->disableIdFilter();

                // sql: ... WHERE `user.name` LIKE "%$name%";
                $filter->like('name', 'name');

            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Universities::class, function (Form $form) {

            $form->text('name','高校名称');

            $form->number('sort', '排序')->default(0);
        });
    }
}
