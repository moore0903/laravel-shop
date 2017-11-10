<?php

namespace App\Admin\Controllers;

use App\Models\Article;

use App\Models\Cases;
use App\Models\Catalog;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class CasesController extends Controller
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

            $content->header('案例列表');
            $content->description('案例列表');

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

            $content->header('案例修改');
            $content->description('案例修改');

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

            $content->header('案例添加');
            $content->description('案例添加');
//            $form1 = new Form();
//            $form1->action('example');
//            $form1->editor('content', '内容')->attribute(['style' => 'height:400px;max-height:500px;']);
//            $content->->attribute(['style' => 'height:400px;max-height:500px;'])

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
        return Admin::grid(Cases::class, function (Grid $grid) {
            $grid->model()->orderBy('created_at', 'desc');

            $grid->id('ID')->sortable();
            $grid->title('标题')->editable();
            $grid->catalog()->title('分类');

            $grid->img('图片')->image('',80,80);

            $states = [
                'on' => ['text' => 'YES'],
                'off' => ['text' => 'NO'],
            ];

            $grid->sort('排序号')->editable();

            $grid->column('是否显示')->switchGroup([
                'is_display' => '显示'
            ],$states);

            $grid->column('是否推荐')->switchGroup([
                'recommend' => '推荐'
            ],$states);

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Cases::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('catalog_id','分类')->options(Catalog::selectOptions());
            $form->text('title', '标题');
            $form->editor('content', '内容')->attribute(['style' => 'height:400px;max-height:500px;']);

            $form->image('img', '图片');


            $form->switch('recommend','推荐');

            $form->number('sort', '排序号')->default('100');

            $form->switch('is_display','显示')->default(true);

        });
    }
}
