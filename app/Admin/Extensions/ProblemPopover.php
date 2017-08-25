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

class ProblemPopover extends AbstractDisplayer
{
    public function display($placement = 'left')
    {
        Admin::script("$('[data-toggle=\"popover\"]').popover()");

        $content = json_decode($this->value,true);
        $content = implode(',',$content);

        return <<<EOT
<button type="button"
    class="btn btn-secondary"
    title="手机问题"
    data-container="body"
    data-toggle="popover"
    data-placement="$placement"
    data-content="{$content}"
    >
  点击查看
</button>

EOT;

    }
}