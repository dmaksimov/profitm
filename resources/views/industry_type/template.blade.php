@extends('layouts.base', [
    'hasSidebar' => false
])
@section('head-styles')
    <link href="{{ asset('css/company-create.css') }}" rel="stylesheet">
    <style>
        .v-select .selected-tag ,.input-tag{
            background-color: #572e8d!important;;
            color : white!important;
            margin: auto!important;
            display: flex!important;
            align-items: center!important;
            border: 1px solid #ccc!important;
            border-radius: 4px!important;
            line-height: 1.42857143!important;
            font-size: medium !important;
            padding: 0 .25em!important;
            transition: opacity .25s!important;
        }
        .vue-input-tag-wrapper {
            padding-top: 0px!important;
            font-size: medium !important;
        }
        .close {
            color : white!important;
        }
    </style>
@endsection

@section('body-script')
    <script>
        window.createUrl = "{{ route('industry_types.store') }}";
        window.indexUrl = "{{ route('industry_types.index') }}";
        window.id = "{{$id}}";
        window.dbfields = @json($data);
        window.defaultFields = @json($default);
    </script>
    <script src="{{ asset('js/industry_type-create.js') }}"></script>
@endsection

@section('main-content')
    <div class="container" id="company-create" v-cloak>
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2 mb-3">
                <a class="btn pm-btn pm-btn-blue go-back" href="{{ route('industry_types.index') }}">
                    <i class="fas fa-arrow-circle-left mr-2"></i> Go Back
                </a>
            </div>

            <div class="col-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="saveTemplate">
                            <div class="row align-items-end no-gutters">
                                <div class="col-12">
                                    <div class="form-group filter--form-group">
                                        <label class="font-weight-bold">Select PM field</label>
                                        <v-select dusk="db-field-select" :options="dbFields" label="name" v-model="templateForm.dbFields" class="filter--v-select mb-3" multiple></v-select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group filter--form-group">
                                        <label class="font-weight-bold">Add Custom PM field</label>
                                        <input-tag v-model="templateForm.fields" class="form-control mb-3"></input-tag>
                                    </div>
                                </div>
                            </div>

                            <button dusk="save-user-button" type="submit" :disabled="isLoading" class="btn btn-md text-right pm-btn-submit pm-btn pm-btn-purple pm-btn-md ">
                                <span v-if="!isLoading">Submit</span>
                                <div class="loader-spinner" v-if="isLoading">
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
