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

            $content->body($this->form('edit')->edit($id));
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

            $content->body($this->form('create'));
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
//            $grid->model()->where('phone',\DB::raw('REGEXP'),\DB::raw('"[1][35678][0-9]{9}"'));
            $grid->id('ID')->sortable();
            $grid->name('用户名');
            $grid->email('邮箱');
            $grid->phone('手机');

            $grid->user_name('真实姓名');
            $grid->sex('性别')->display(function ($sex) {
                return $sex ? '女' : '男';
            });
            $grid->column('address','通讯地址');
            $grid->tel('电话');
            $grid->qq('QQ/MSN');

            $grid->disableRowSelector();
//            $grid->disableActions();
            
        });
    }

    /**
 * Make a form builder.
 *
 * @return Form
 */
    protected function form($type='create')
    {
        return Admin::form(User::class, function (Form $form) use($type){
            if($type == 'create'){
                $form->display('id', 'ID');
                $form->text('name','用户名')->rules('required|unique:users,name');
                $form->email('email','邮箱')->rules('required');
                $form->password('password','密码')->rules('required');
                $form->mobile('phone','手机')->rules('required');

                $form->divide();

                $form->text('user_name','真实姓名');
                $form->radio('sex', '性别')->options(['0' => '男', '1'=> '女'])->default('0');
                $form->text('address','通讯地址');
                $form->text('code','邮政编码');
                $form->text('tel','电话');
                $form->text('qq','QQ/MSN');
            }else{
                $form->display('id', 'ID');
                $form->display('name','用户名');
                $form->email('email','邮箱');
                $form->hidden('password');
                $form->mobile('phone','手机');

                $form->divide();

                $form->text('user_name','真实姓名');
                $form->radio('sex', '性别')->options(['0' => '男', '1'=> '女'])->default('0');
                $form->text('address','通讯地址');
                $form->text('code','邮政编码');
                $form->text('tel','电话');
                $form->text('qq','QQ/MSN');
            }


        });
    }

}
