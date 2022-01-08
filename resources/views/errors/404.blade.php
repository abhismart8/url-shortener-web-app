@extends('layouts.default')

@push('css')
<style>
    .container.error-head {
    padding: 150px 0px;
}
.text-info {
    color: var(--primary-color);
    margin-bottom: 20px;
    font-weight: 600;
}
</style>
@endpush
@section('title')
    @parent
     {{__('Error-404')}}
@endsection

@section('content')
<div class="">
    <!--begin::Content-->
    <div class="container error-head" style="text-align: center; margin-top: 20px;">
        <h1 class="error-title font-weight-boldest text-info mt-10 mt-md-0 mb-12">{{__('We couldn\'t find the page you are looking for!')}}</h1>
        <h5 style="margin-top:10px; font-size: 16px; color: var(--input-text-color);" class="font-weight-boldest display-4">{{__('We\'ve got a 404 error and explored deep and wide, but we can\'t find the page you were looking for.')}}</h5>
        <a href="{{route('index')}}" class="btn btn-primary" style="margin-top: 20px !important; margin-bottom: 20px; background-color: var(--primary-color);padding: 10px 40px;font-size: 18px;">{{__('Go To Home')}}</a>
    </div>
    <!--end::Content-->
</div>
@endsection