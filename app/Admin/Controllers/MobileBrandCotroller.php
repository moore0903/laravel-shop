<?php

namespace App\Admin\Controllers;

use App\Models\MobileBrand;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class MobileBrandCotroller extends Controller
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

            $content->header('手机品牌');
            $content->description('手机品牌');

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

            $content->header('手机品牌');
            $content->description('手机品牌');

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

            $content->header('手机品牌');
            $content->description('手机品牌');

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
        return Admin::grid(MobileBrand::class, function (Grid $grid) {
            $grid->brand_name('品牌名')->sortable();
            $grid->created_at('添加时间')->sortable();
            $grid->sort('排序')->editable()->sortable();
            $grid->column('型号')->display(function(){
                return '<a href="'.url('admin/model').'?brand_id='.$this->id.'">查看型号</a>';
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
        return Admin::form(MobileBrand::class, function (Form $form) {

//            $form->display('id', 'ID');

            $form->text('brand_name','品牌名称');

            $form->number('sort', '排序')->default(0);

//            $form->display('created_at', 'Created At');
//            $form->display('updated_at', 'Updated At');
        });
    }
}
