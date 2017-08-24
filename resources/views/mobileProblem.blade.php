@extends('layouts.app')

@section('content')
    <header class="ui-header ui-header-style">
        <i class="am-icon-angle-left am-icon-fw" onclick="history.back()"></i>
        <h1>出现了什么问题？</h1>
    </header>
    <section class="ui-container">
        <div class="problem-info">
            品牌：<span id="phone-brand-name">{{ $mobileModel->brand->brand_name }}</span>
            机型：<span id="phone-type-name">{{ $mobileModel->model_name }}</span>
        </div>
        <form action="{{ url('mobileConfirm/') }}" method="post" class="am-form problems_form" id="problem_form" data-am-validator>
            @foreach(\App\Models\MobileModel::$problems as $problem)
            <div class="am-form-group">
                <label class="am-checkbox-inline">
                    <input type="checkbox" value="{{ $problem }}" data-am-ucheck name="problem[]" minchecked="1" required> {{ $problem }}
                </label>
            </div>
            @endforeach
            <input type="hidden" name="model_id" value="{{ $mobileModel->id }}"/>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <button class="am-btn am-btn-danger form-submit-btn am-round">下一步</button>
        </form>
        <div class="am-modal am-modal-alert" tabindex="-1" id="problems-modal">
            <div class="am-modal-dialog">
                <div class="am-modal-bd">
                    请选择故障原因
                </div>
                <div class="am-modal-footer">
                    <span class="am-modal-btn">确定</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        var $problems_modal = $('#problems-modal');
        var $problems_form= $('#problem_form');

        $problems_form.validator({
            H5validation: false,
            validateOnSubmit: false,
            submit: function() {
                // console.log(this);
                var formValidity = this.isFormValid();
                if(!formValidity){
                    $problems_modal.modal();
                    return false;
                }
            }
        });
    </script>
@endsection