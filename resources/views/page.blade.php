@extends('layouts.app')

@section('header')

@endsection

@section('banner')

@endsection

@section('search')

@endsection

@section('content')
    <div class="membertitle fmyh">
        <p class="fh"><a href="javascript:window.history.go(-1)"></a></p>
        {{ $page->title }}</div>
    <div class="about">
        {{ $page->content }}
    </div>
@endsection

@section('bottom_bar')

@endsection