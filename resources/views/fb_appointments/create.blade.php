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
        window.customers = @json($customers);
        window.cid = "{{@request()->cid}}"
    </script>
    <script src="{{ asset('js/customer-create.js') }}"></script>
@endsection

@section('main-content')
    <div class="container" id="customer-create" v-cloak>
        <div class="row">   
            <div class="col-12 col-md-8 offset-md-2 mt-3">
                <div class="card">
                    <div class="card-body">
                        <form action="" @submit.prevent="saveCustomer({{$id}})">
                            @if(!@request()->cid)
                            <div class="form-group">
                                <label for="phone">Select Customer</label>
                                <v-select dusk="agency-select" :options="customers" label="name" v-model="customerSelected" class="filter--v-select" ></v-select>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="date">Date</label><br>
                                <date-pick dusk="starts-on-field" v-model="customerForm.date"
                                :has-input-element="true" :input-attributes="datePickInputClasses" type="date"
                                :class="{'is-invalid': customerForm.errors.has('date')}"></date-pick>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="email">Start Time</label><br>
                                    <vue-timepicker drop-direction="up" input-width="330px" format="HH:mm" v-model="customerForm.start_time"></vue-timepicker>  
                                </div>
                                <div class="form-group col">
                                    <label for="phone">End Time</label><br>
                                    <vue-timepicker drop-direction="up" input-width="330px"format="HH:mm"  v-model="customerForm.end_time"></vue-timepicker>  
                                </div>
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
