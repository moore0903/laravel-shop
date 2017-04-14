<?php

namespace App\Admin\Controllers;

use App\Models\Giftcode;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class GiftcodeController extends Controller
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

            $content->header('优惠券管理');
            $content->description('优惠券管理');

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
        return Admin::grid(Giftcode::class, function (Grid $grid) {
            $grid->model()->where('p_id', '=', 0);
            $grid->model()->groupBy('title','discountn','discountnlimit','usecountmax','start_time','end_time');
//            $grid->id('ID')->sortable();
            $grid->title('标题');
            $grid->column('优惠')->display(function(){
                return '满'.$this->discountnlimit.'元减'.$this->discountn.'元';
            });
            $grid->usecountmax('总张数');
            $grid->usecount('已使用');
            $grid->start_time('开始时间');
            $grid->end_time('开始时间');
            $grid->net('使用地址')->display(function($net){
                return '<a href="'.$net.'" target="_blank">'.$net.'</a>';
            });
            $grid->actions(function ($actions){
                $actions->disableDelete();
                $actions->disableEdit();
                $download_url = url('admin/giftcode/download').'?title='.urlencode($actions->row->title).'&discountn='.urlencode($actions->row->discountn).'&discountnlimit='.urlencode($actions->row->discountnlimit).'&usecountmax='.urlencode($actions->row->usecountmax).'&start_time='.urlencode($actions->row->start_time).'&end_time='.urlencode($actions->row->end_time);
                $actions->append('<a href="'.$download_url.'">下载CSV</a>');
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
        return Admin::form(Giftcode::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title','名称');
            $form->number('discountnlimit','满X元减Y元 中的X');
            $form->number('discountn','满X元减Y元 中的Y');
            $form->number('usecountmax','使用次数');
            $form->number('codecount','生成张数');
            $form->datetimeRange('start_time', 'end_time', '可使用时间范围');
            $form->text('net', '使用网址(留空则为首页)');
        });
    }

    /**
     * @param Request $request
     */
    public function download(Request $request){
        $model = Giftcode::where('title',$request['title'])
            ->where('discountn',$request['discountn'])
            ->where('discountnlimit',$request['discountnlimit'])
            ->where('usecountmax',$request['usecountmax'])
            ->where('start_time',$request['start_time'])
            ->where('end_time',$request['end_time'])
            ->get();
        \Excel::create('优惠码_'.$request['title'], function($excel) use ($model) {
            $excel->sheet('Sheetname', function($sheet) use($model) {
                $sheet->fromModel($model);
            });
        })->download('csv');
    }

}
