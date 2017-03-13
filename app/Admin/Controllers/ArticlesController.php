<?php

namespace App\Admin\Controllers;

use App\Models\Article;

use App\Models\Catalog;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class ArticlesController extends Controller
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

            $content->header('文章列表');
            $content->description('文章列表');

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

            $content->header('文章修改');
            $content->description('文章修改');

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

            $content->header('文章添加');
            $content->description('文章添加');
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
        return Admin::grid(Article::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->title('标题')->editable();
            $grid->catalog()->title('分类');

            $grid->img('图片')->image('',80,80);

            $states = [
                'on' => ['text' => 'YES'],
                'off' => ['text' => 'NO'],
            ];

            $grid->column('推荐')->switchGroup([
                'recommend' => '推荐', 'hot' => '热门', 'new' => '最新'
            ], $states);

            $grid->column('是否显示')->switchGroup([
                'is_display' => '显示'
            ],$states);

            $grid->author('作者')->editable();
            $grid->browse('浏览量')->editable();

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
        return Admin::form(Article::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('catalog_id','分类')->options(Catalog::selectOptions());
            $form->text('title', '标题');
            $form->editor('content', '内容')->attribute(['style' => 'height:400px;max-height:500px;']);

            $form->image('img', '图片');
            $form->select('content_tpl', '内容模板')->options(Catalog::dirToArray());

            $form->text('author','作者')->default('本站');
            $form->number('browse', '浏览量');
            $form->switch('recommend','推荐');
            $form->switch('hot','热门');
            $form->switch('new','最新');

            $form->switch('is_display','显示')->default(true);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
