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
        window.agencies = @json($viewData['agencies']);
        window.dealerships = @json($viewData['dealerships']);
        window.industries = @json($viewData['industries']);
        window.agencySelected = @json($campaign->agency);
        window.dealershipSelected = @json($campaign->dealership);
        window.industrySelected = @json($campaign->industryType);
        window.id = {{$id}};
    </script>
    <script src="{{ asset('js/companies-assign.js') }}"></script>
@endsection

@section('main-content')
    <div class="container" id="customer-create" v-cloak>
        <div class="row">   
            <div class="col-12 col-md-8 offset-md-2 mt-3">
                <a class="btn pm-btn pm-btn-blue mb-3" href="{{ route('campaigns.fb') }}">
                    <i class="fas fa-arrow-circle-left mr-2"></i> Go Back
                </a>
                <div class="card">
                    <div class="card-body">
                        <form action="" @submit.prevent="assignCompanies({{$id}})">
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="agency">Industry Type</label>
                                        <v-select dusk="agency-select" :options="industries" label="name" v-model="industrySelected" class="filter--v-select" ></v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="agency">Agency</label>
                                        <v-select dusk="agency-select" :options="agencies" label="name" v-model="agencySelected" class="filter--v-select" ></v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="Dealership">Dealership</label>
                                        <v-select dusk="dealership-select" :options="dealerships" label="name" v-model="dealershipSelected" class="filter--v-select" ></v-select>
                                    </div>
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
