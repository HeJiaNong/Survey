@extends('admin.layouts.default')

@section('title','后台管理页')

@section('title-2','后台管理页')
{{-- 传入欢迎页的链接 --}}
@section('content',route('admin_desktop'))