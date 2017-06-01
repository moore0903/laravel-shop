<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Chart\Bar;
use Encore\Admin\Widgets\Chart\Doughnut;
use Encore\Admin\Widgets\Chart\Line;
use Encore\Admin\Widgets\Chart\Pie;
use Encore\Admin\Widgets\Chart\PolarArea;
use Encore\Admin\Widgets\Chart\Radar;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row(function ($row) {
                $row->column(3, new InfoBox('New Users', 'users', 'aqua', '/admin/users', '1024'));
                $row->column(3, new InfoBox('New Orders', 'shopping-cart', 'green', '/admin/orders', '150%'));
                $row->column(3, new InfoBox('Articles', 'book', 'yellow', '/admin/articles', '2786'));
                $row->column(3, new InfoBox('Documents', 'file', 'red', '/admin/files', '698726'));
            });

            $content->row(function (Row $row) {

                $row->column(6, function (Column $column) {

                    $tab = new Tab();

                    $pie = new Pie([
                        ['Stracke Ltd', 450], ['Halvorson PLC', 650], ['Dicki-Braun', 250], ['Russel-Blanda', 300],
                        ['Emmerich-O\'Keefe', 400], ['Bauch Inc', 200], ['Leannon and Sons', 250], ['Gibson LLC', 250],
                    ]);

                    $tab->add('Pie', $pie);
                    $tab->add('Table', new Table());
                    $tab->add('Text', 'blablablabla....');

                    $tab->dropDown([['Orders', '/admin/orders'], ['administrators', '/admin/administrators']]);
                    $tab->title('Tabs');

                    $column->append($tab);

                    $collapse = new Collapse();

                    $bar = new Bar(
                        ["January", "February", "March", "April", "May", "June", "July"],
                        [
                            ['First', [40,56,67,23,10,45,78]],
                            ['Second', [93,23,12,23,75,21,88]],
                            ['Third', [33,82,34,56,87,12,56]],
                            ['Forth', [34,25,67,12,48,91,16]],
                        ]
                    );
                    $collapse->add('Bar', $bar);
                    $collapse->add('Orders', new Table());
                    $column->append($collapse);

                    $doughnut = new Doughnut([
                        ['Chrome', 700],
                        ['IE', 500],
                        ['FireFox', 400],
                        ['Safari', 600],
                        ['Opera', 300],
                        ['Navigator', 100],
                    ]);
                    $column->append((new Box('Doughnut', $doughnut))->removable()->collapsable()->style('info'));
                });

                $row->column(6, function (Column $column) {

                    $column->append(new Box('Radar', new Radar()));

                    $polarArea = new PolarArea([
                        ['Red', 300],
                        ['Blue', 450],
                        ['Green', 700],
                        ['Yellow', 280],
                        ['Black', 425],
                        ['Gray', 1000],
                    ]);
                    $column->append((new Box('Polar Area', $polarArea))->removable()->collapsable());

                    $column->append((new Box('Line', new Line()))->removable()->collapsable()->style('danger'));
                });

            });

            $headers = ['Id', 'Email', 'Name', 'Company', 'Last Login', 'Status'];
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 'Goodwin-Watsica', '1997-08-13 13:59:21', 'open'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 'Murphy, Koepp and Morar', '1988-07-19 03:19:08', 'blocked'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 'Kihn LLC', '1978-06-19 11:12:57', 'blocked'],
                [4, 'xet@yahoo.com', 'William Koss', 'Becker-Raynor', '1988-09-07 23:57:45', 'open'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 'Braun Ltd', '2013-10-16 10:00:01', 'open'],
            ];

            $content->row((new Box('Table', new Table($headers, $rows)))->style('info')->solid());
        });
    }

    /**
     * 网站更新
     * @return Content
     */
    public function updateSite() {
        set_time_limit(1800);
        ini_set('memory_limit','1024M');
        return Admin::content(function (Content $content) {

            $content->header('代码更新');
            $content->description('代码更新');

            $headers = ['记录'];
            $out = [];
            $stat = null;
            $s = DIRECTORY_SEPARATOR=="\\"? 'cmd /c "'.base_path('update.bat').'"2>&1' : 'sudo -u root "'.base_path('update.sh').'"2>&1';
            $last = exec($s,$out,$stat);
            \Log::debug($s);
            \Log::debug($out);
            \Log::debug($stat);
            \Log::debug($last);
            foreach($out as $line){
                if(empty($line)) continue;
                $rows[] = [$line];
            }

            $content->row((new Box('Table', new Table($headers, $rows)))->style('info')->solid());
        });
    }

    /**
     * 网站配置更新
     * @param Request $request
     * @return Content|\Illuminate\Http\RedirectResponse
     */
    public function updateConfig(Request $request){
        if($request->method() == 'GET'){
            return Admin::content(function (Content $content) {
                $content->header('网站配置');
                $form = new Form();
                $configs = Config::all();
                $form->action(url(config('admin.prefix').'/updateConfig'));
                $post_price = $configs->where('key','post_price')->first();
                $include_postage = $configs->where('key','include_postage')->first();
                $since_address = $configs->where('key','since_address')->first();
                $since_realname = $configs->where('key','since_realname')->first();
                $since_phone = $configs->where('key','since_phone')->first();
                $search_key = $configs->where('key','search_key')->first();
                $form->currency('key[post_price]', '运费')->symbol('￥')->default(!empty($post_price)? $post_price->value : '0.00');
                $form->currency('key[include_postage]', '满X包邮')->symbol('￥')->default(!empty($include_postage)? $include_postage->value : '0.00');
                $form->text('key[since_address]', '自提点')->default(!empty($since_address)? $since_address->value : '');
                $form->text('key[since_realname]', '自提点联系人')->default(!empty($since_realname)? $since_realname->value : '');
                $form->mobile('key[since_phone]', '自提点电话')->default(!empty($since_phone)? $since_phone->value : '');
                $form->text('key[search_key]', '搜索关键字以,隔开')->default(!empty($search_key)? $search_key->value : '');
                $content->row(new Box('网站配置', $form));
            });
        }elseif($request->method() == 'POST'){
            $keys = $request['key'];
            foreach($keys as $key=>$value){
                $configInfo = Config::where('key','=',$key)->first();
                if(!empty($configInfo->value)){
                    \DB::table('configs')->where('key','=',$key)->update(['value'=>$value]);
                }else{
                    Config::insert(['key'=>$key,'value'=>$value]);
                }
            }
            $success = new MessageBag([
                'title'   => '保存成功',
                'message' => '更新成功',
            ]);

            return back()->with(compact('success'));
        }

    }

    public function imageUpload(Request $request){
        if(!$request->hasFile('wangEditorH5File')) return 'error|失败原因为：找不到文件';
        $path = \Storage::putFile('public/editor', $request->file('wangEditorH5File'));
        return \Storage::url($path);
    }
}
