@extends('layouts.base', [
    'hasSidebar' => false
])

@section('head-styles')
    <link href="{{ asset('css/campaigns-create.css') }}" rel="stylesheet">
    <style>
        .vdpWithInput{
            width: 100%!important;
        }
    </style>
@endsection

@section('body-script')
    <script>
        window.id = "{{$id}}";
    </script>
    <script src="{{ asset('js/customer-create.js') }}"></script>
@endsection

@section('main-content')
    <div class="container" id="customer-create" v-cloak>
        <div class="row">   
            <div class="col-12 col-md-8 offset-md-2 mt-3">
                <a class="btn pm-btn pm-btn-blue mb-3" href="{{url()->previous()}}">
                    <i class="fas fa-arrow-circle-left mr-2"></i> Go Back
                </a>
                <div class="card">
                    <div class="card-body">
                        <form action="" @submit.prevent="saveNewCustomer({{$id}})">
                            <div class="form-group">
                                <label for="name">Customer Name</label>
                                <input type="text" name="name" class="form-control"  v-model="customerForm.name">
                            </div>
                            <div class="form-group">
                                <label for="email">Customer Email</label>
                                <input type="text" name="email" class="form-control"  v-model="customerForm.email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Customer Phone No</label>
                                <input type="text" name="phone_no" class="form-control"  v-model="customerForm.phone_no">
                            </div>
                            <button dusk="save-user-button" type="submit" :disabled="loading" class="btn btn-md text-right pm-btn-submit pm-btn pm-btn-purple pm-btn-md mt-4">
                                <span v-if="!loading">Submit</span>
                                <div class="loader-spinner" v-if="loading">
                                    <spinner-icon></spinner-icon>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
