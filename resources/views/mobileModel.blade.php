@extends('layouts.app')

@section('content')
    <header class="ui-header ui-header-style">
        <i class="am-icon-angle-left am-icon-fw" onclick="history.back()"></i>
        <h1>您的设备型号是？</h1>
    </header>
    <section class="ui-container">
        <div class="brand-list" id="type_list">
            @foreach($mobileModels as $model)
                <div class="brand-item" data-id="{{ $loop->iteration }}" data-name="{{ $model->model_name }}">
                    <a href="{{ url('mobileProblem/'.'?model_id='.$model->id) }}">{{ $model->model_name }}<i class="am-icon-angle-right am-fr am-margin-right"></i></a>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('script')

@endsection