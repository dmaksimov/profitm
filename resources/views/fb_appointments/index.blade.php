@extends('layouts.base', [
    'hasSidebar' => false
])

@section('head-styles')
    <link href="{{ asset('css/site-admin-user-index.css') }}" rel="stylesheet">
    <style>
        .fc-event {
            background-color : #623d95!important;
            color : white !important;
            border: 1px solid #623d95!important;
            padding : 5px!important;
            font-size: 14px!important;
        }
    </style>
@endsection

@section('body-script')
    <script>
        window.id = "{{$id}}";
    </script>
    <script src="{{ asset('js/appointments-index.js') }}"></script>

@endsection

@section('main-content')
    <div class="container" id="user-index" v-cloak>
        <div class="row align-items-end no-gutters mt-3">
            <div class="col-12">
                <div class="loader-spinner" v-if="isLoading">
                    <spinner-icon></spinner-icon>
                </div>
                <h1 class="page-title">Facebook Appointments - {{$model->title}} - <button class="btn btn-dark scroll"  @click="scrollDown()">Listing View</button></h1>
                <full-calendar class="mt-5 p-5 bg-white" :events="events" ref="fullCalender"></full-calendar>
                <hr>
                <h1 class="page-title" id="listngs-view">Facebook Appointments Listings - {{$model->title}}</h1>
                <appointment v-for="appointment in appointments"  :key="appointment.id" :appointment="appointment"></appointment>
            </div>
        </div>
    </div>
@endsection
