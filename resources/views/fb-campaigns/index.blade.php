@extends('layouts.base', [
    'hasSidebar' => false
])

@section('head-styles')
    <link href="{{ asset('css/campaign-index.css') }}" rel="stylesheet">
@endsection

@section('body-script')
    <script>
        window.getCompanyUrl = @json(route('company.for-dropdown'));
        window.industries = @json($industries);
    </script>
    <script src="{{ asset('js/fb-campaign-index.js') }}"></script>
@endsection

@section('main-content')
    <div class="container" id="campaign-index" v-cloak>
            <div class="row align-items-end no-gutters">
            <div class="col-12 col-sm-5 col-lg-3 mb-3">
                <div class="form-group filter--form-group">
                    <label>Filter By Company</label>
                    <v-select :options="companies" label="name" v-model="companySelected" class="filter--v-select" @input="onCompanySelected"></v-select>
                </div>
            </div>
            <div class="col-none col-sm-2 col-lg-6"></div>
            <div class="col-12 col-sm-5 col-lg-3 mb-3">
                <input type="text" v-model="searchForm.q" class="form-control filter--search-box" aria-describedby="search"
                       placeholder="Search" @keyup.enter="fetchData">
            </div>
        </div>
        <div class="row align-items-end no-gutters">
            <div class="col-12 col-sm-5 col-lg-3 mb-3">
                <div class="form-group filter--form-group">
                    <label>Filter By Industry</label>
                    <v-select :options="industries" label="name" v-model="industrySelected" class="filter--v-select" @input="onCompanySelected"></v-select>
                </div>
            </div>
        </div>
        <div class="row align-items-end no-gutters mt-3">
            <div class="col-12">
                <div class="loader-spinner" v-if="isLoading">
                    <spinner-icon></spinner-icon>
                </div>
                <h1 class="page-title">Facebook Campaigns</h1>
                <div class="campaign-group-label" >ACTIVE</div>
                <fb-campaign v-for="campaign in campaigns" :key="campaign.id" :campaign="campaign" v-if="campaign.status == 'ACTIVE'"></fb-campaign>
                <div class="campaign-group-label" >INACTIVE</div>
                <fb-campaign v-for="campaign in campaigns" v-if="campaign.status == 'PAUSED'" :key="campaign.id" :campaign="campaign"></fb-campaign>
                {{-- <pm-pagination :pagination="pagination" @page-changed="onPageChanged"></pm-pagination> --}}
            </div>
        </div>
    </div>
@endsection
