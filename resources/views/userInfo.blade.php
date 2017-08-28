@extends('layouts.app')

@section('content')
    <header class="ui-header ui-header-style">
        <i class="am-icon-angle-left am-icon-fw" onclick="history.back()"></i>
        <h1>个人中心</h1>
    </header>
    <section class="ui-container">
        <div class="user-center-box">
            <div class="user-info-box">
                <div class="user-header-pic">
                    <img src="{{ $thirdUser->avatar }}" alt="头像">
                </div><!--user-header-pic end-->
                <div class="user-name">{{ $thirdUser->nick_names }}</div>
            </div>
            <!--user-info-box end-->
            <div class="user-repair-logs">
                @foreach($orders as $order)
                <div class="repair-item">
                    <div class="am-g doc-am-g repair-info">
                        <div class="am-u-sm-2">
                            <div class="am-icon-btn am-danger am-icon-mobile-phone font-size34"></div>
                        </div>
                        <div class="am-u-sm-10">
                            <p><span class="txt-gray9">业务类型：</span> {{ $order->type == 1 ? '手机报修' : '电脑报修' }}</p>
                            @if($order->type == 1)
                            <p><span class="txt-gray9">手机型号：</span> {{ $order->brand.' '.$order->model }}</p>
                            @endif
                            <p><span class="txt-gray9">出现问题：</span> {{ $order->type == 1 ? implode(',',json_decode($order->problem,true)).' '.$order->remark : $order->remark }}</p>
                        </div>
                    </div><!--am-g doc-am-g end-->
                    <div class="logs-list-box">
                        <ul class="logs-list">
                            <?php
                                Log::debug($order->progress);
                                $processes = explode('|',$order->progress);
                                $processes = array_reverse($processes);
                            ?>
                            @foreach($processes as $process)
                                <?php
                                    $pro = explode(' ',$process);
                                ?>
                                <li class="log-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                                    <span class="am-icon-circle"></span>
                                    {{ \App\Models\MobileOrders::$stat[$pro[2]] }}
                                    <span class="txt-gray9 am-fr">{{ $pro[0].' '.$pro[1] }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tips">如有疑问请拨打客服电话44130028</div>
                        <div class="toggle-show-logs-btn">
                            <i class="am-icon-angle-down am-animation-rotateIn"></i>
                        </div>
                    </div>
                    <!--logs-list-box end-->
                </div>
                @endforeach

            </div>
            <!--user-repair-logs end-->
        </div>
    </section>
@endsection

@section('script')
    <script>
        $('.toggle-show-logs-btn').bind('click', function(e){
            var _this = $(this);

            _this.find('i').toggleClass('active');
            _this.siblings('.tips').slideToggle(1);
            _this.siblings('.logs-list').find('.log-item').toggleClass('open');

        })
    </script>
@endsection