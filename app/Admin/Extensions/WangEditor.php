<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 2017/3/8
 * Time: 20:23
 */

namespace App\Admin\Extensions;


use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    protected $view = 'admin::form.editor';

    protected static $css = [
        '/packages/wangEditor-2.1.23/dist/css/wangEditor.min.css',
    ];

    protected static $js = [
        '/packages/wangEditor-2.1.23/dist/js/wangEditor.js',
    ];

    public function render()
    {
        $token = csrf_token();
        $uploadUrl = url('admin/imageUpload');
        $this->script = <<<EOT

var editor = new wangEditor('{$this->id}');
    editor.config.uploadImgUrl = '{$uploadUrl}';
    editor.config.uploadParams = {
        _token: '{$token}',
    };
    editor.create();

EOT;
        return parent::render();

    }

}