@extends('layouts.base', [
    'hasSidebar' => false
])

@section('head-styles')
    <link href="{{ asset('css/campaign-index.css') }}" rel="stylesheet">
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
    <script src="{{ asset('js/events-index.js') }}"></script>
@endsection

@section('main-content')
    <div class="container" id="events-index">
        <full-calendar class="mt-5 p-5 bg-white" :events="events" ref="fullCalender"></full-calendar>
    </div>
@endsection
