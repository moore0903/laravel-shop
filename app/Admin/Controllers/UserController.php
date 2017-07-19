<?php

namespace App\Admin\Controllers;

use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Table;

class UserController extends Controller
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

            $content->header('会员列表');
            $content->description('会员列表');

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

            $content->header('header');
            $content->description('description');

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
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->model()->orderBy('id','desc');
            $grid->id('ID')->sortable();
            $grid->name('名称');
            $grid->headimage('头像')->image('',80,80);

            $grid->created_at('注册时间');

            $states = [
                'on' => ['value'=>'1','text' => 'YES'],
                'off' => ['value'=>'0','text' => 'NO'],
            ];

            $grid->is_buy('是否可购买')->switch($states);

//            $grid->column('收货地址')->expand(function () {
//                $address = $this->address;
//                $address = $address->map(function($item){
//                    $data = ['realname'=>$item['realname'],'address'=>$item['address'],'phone'=>$item['phone']];
//                    foreach(array_diff_assoc($item->toArray(),$data) as $key => $value){
//                        unset($item[$key]);
//                    }
//                    return $item;
//                })->prepend(['收货人','收货地址','收货电话'])->toArray();
//                return new Table([], $address);
//            }, '点击查看');

            $grid->disableCreation();
            $grid->disableRowSelector();
            $grid->disableActions();
            
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
