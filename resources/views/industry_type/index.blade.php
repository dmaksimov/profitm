@extends('layouts.base', [
    'hasSidebar' => false
])

@section('head-styles')
    <link href="{{ asset('css/company-index.css') }}" rel="stylesheet">
@endsection

@section('body-script')
    <script>
        window.searchFormUrl = "{{ route('industry_types.for-industry_type-display') }}";
        window.industryTypeEdit = @json(route('industry_types.edit', ['industryType' => ':industryTypeId']));

        // window.industryTypeEdit = "{{ route('industry_types.edit', ['industryType' => ':industryTypeId']) }}";
        window.industryTypeDelete = "{{ route('industry_types.destroy', ['industryType' => ':industryTypeId']) }}";
        window.q = @json($q);
    </script>
    <script src="{{ asset('js/industry_type-index.js') }}"></script>
@endsection

@section('main-content')
    <div class="container mt-3" id="company-index" v-cloak>
        <div class="row align-items-end no-gutters">
            <div class="col-12 col-sm-5 col-lg-3 mb-3">
                <a dusk="create-company-button" href="{{ route('industry_types.create') }}" class="btn pm-btn pm-btn-blue">
                    <i class="fa fa-plus mr-2"></i>
                    Add Industry Type
                </a>
            </div>
            <div class="col-none col-sm-2 col-lg-6"></div>
        </div>
        <h1 class="page-title">Industry Types</h1>
        <div class="row no-gutters company-component inactive" v-for="(industry_type, index) in industry_types" :key="industry_type.id">
            <div class="col-12 col-md-5 company-header">
                <div class="company-header--title">
                    <strong>@{{ industry_type.title }}</strong>
                </div>
            </div>
            <div class="col-4 col-md-2 company-postcard"><span class="company-icon fas fa fa-industry" no-label=""></span></div>
            <div class="col-4 col-md-2 company-date">
                <span>Created On</span>
                <span>@{{ industry_type.created_at | amDateFormat('MM.DD.YY') }}</span>
            </div>
            <div class="col-4 col-md-3 company-links">
                <a class="btn pm-btn pm-btn-blue pm-btn-md justify-content-center" :href="'/industry-template/'+industry_type.id">
                    <span class="pm-font-templates-icon"></span> Template
                </a>
                <a class="btn pm-btn pm-btn-purple pm-btn-md justify-content-center" :href="generateRoute(industryTypeEdit, {'industryTypeId': industry_type.id})">
                    <span class="fa fa-edit"></span> Edit
                </a>
                <a href="#" @click="deleteIndustryType(industry_type.id, index)" class="btn pm-btn pm-btn-danger pm-btn-md justify-content-center">
                    <span class="fa fa-trash"></span> Delete
                </a>
            </div>
        </div>
        {{-- <pm-pagination v-if="industry_types.length > 0" :pagination="pagination" @page-changed="onPageChanged"></pm-pagination> --}}
    </div>
@endsection
