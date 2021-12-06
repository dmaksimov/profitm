@extends('layouts.base', [
    'hasSidebar' => false
])

@section('head-styles')
    <link href="{{ asset('css/site-admin-user-index.css') }}" rel="stylesheet">
@endsection

@section('body-script')
    <script>
        window.id = "{{$id}}";
    </script>
    <script src="{{ asset('js/customers-index.js') }}"></script>
@endsection

@section('main-content')
    <div class="container" id="user-index" v-cloak>
        <div class="row align-items-end no-gutters mt-3">
            <div class="col-12">
                <div class="loader-spinner" v-if="isLoading">
                    <spinner-icon></spinner-icon>
                </div>
                <div class="row">
                    <div class="col-10">
                        <h1 class="page-title">Facebook Recipients - {{$model->title}}</h1>
                    </div>
                    <div class="col text-right">
                        <a class="btn btn-primary" href="/create-recipients/{{$id}}"><i class="fas fa-plus mr-3"></i>Add recipients</a>
                    </div>
                </div>
                <customer v-for="customer in customers"  :key="customer.id" :customer="customer"></customer>
            </div>
        </div>
    </div>
@endsection
