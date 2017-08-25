<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 2017/8/25
 * Time: 9:37
 */

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class Popover extends AbstractDisplayer
{
    public function display($placement = 'left')
    {
        Admin::script("$('[data-toggle=\"popover\"]').popover()");


        return <<<EOT
<button type="button"
    class="btn btn-secondary"
    title="问题"
    data-container="body"
    data-toggle="popover"
    data-placement="$placement"
    data-content="{$this->value}"
    >
  点击查看
</button>

EOT;

    }
}