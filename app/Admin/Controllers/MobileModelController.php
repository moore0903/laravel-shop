<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\MobileModelCreate;
use App\Models\MobileBrand;
use App\Models\MobileModel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Request;

class MobileModelController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content){

            $content->header('手机型号');
            $content->description('手机型号');

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

            $content->header('手机型号');
            $content->description('手机型号');

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

            $content->header('手机型号');
            $content->description('手机型号');

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
        return Admin::grid(MobileModel::class, function (Grid $grid) {
            $grid->model()->where('brand_id','=',Request::get('brand_id'));
            $grid->brand()->brand_name('品牌名')->sortable();
            $grid->model_name('型号')->sortable();
            $grid->created_at('添加时间')->sortable();
            $grid->sort('排序')->sortable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(MobileModel::class, function (Form $form) {
            $brands = [];
            $mobileBrand = MobileBrand::all();
            foreach($mobileBrand as $brand){
                $brands[$brand->id] = $brand->brand_name;
            }

            $form->select('brand_id', '品牌')->options($brands);

            $form->text('model_name','型号');

            $form->number('sort', '排序')->default(0);


//            $form->display('id', 'ID');
//
//            $form->display('created_at', 'Created At');
//            $form->display('updated_at', 'Updated At');
        });
    }
}
