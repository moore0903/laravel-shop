<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 2017/4/18
 * Time: 14:05
 */

namespace App\Admin\Extensions\Column;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class ViewExpress extends AbstractDisplayer
{
    public function display(\Closure $callback = null, $btn = '')
    {
        $callback = $callback->bindTo($this->row);

        list($express_company, $express_no) = call_user_func($callback);

        $key = $this->getKey();

        $name = $this->column->getName();

        Admin::script($this->script());

        if(empty($btn)) $btn = $express_company.':'.$express_no;

        return <<<EOT
<button class="btn btn-xs btn-default grid-open-express" data-key="{$key}" data-company="$express_company" data-no="$express_no" data-toggle="modal" data-target="#grid-modal-{$name}-{$key}">
    <i class="fa fa-map-marker"></i> $btn
</button>

<div class="modal" id="grid-modal-{$name}-{$key}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">$btn</h4>
      </div>
      <div class="modal-body">
        <div style="height:450px;">
            <iframe src="" id="grid-express-$key" width="100%" height="450px" frameborder="0"></iframe>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
EOT;
    }

    protected function script()
    {
        return <<<EOT

$('.grid-open-express').on('click', function() {

    var key = $(this).data('key');
    var company = $(this).data('company');
    var no = $(this).data('no');

    var center = 'https://m.kuaidi100.com/index_all.html?type='+encodeURIComponent(company)+'&postid='+encodeURIComponent(no)+'&callbackurl='+encodeURIComponent('javascript:window.top.postMessage("closeExpress","*");');
    $('#grid-express-'+key).attr('src',center);

});

EOT;
    }
}