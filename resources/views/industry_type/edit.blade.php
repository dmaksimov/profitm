@extends('layouts.base', [
    'hasSidebar' => false
])
@section('head-styles')
    <link href="{{ asset('css/company-create.css') }}" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet"> --}}
    
@endsection

@section('body-script')
{{-- <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script> --}}
   <script>
        window.createUrl = "{{ route('industry_types.store') }}";
        window.indexUrl = "{{ route('industry_types.index') }}";
        window.title = @json($viewData['title']);
        window.status = @json($viewData['status']);
        window.id = @json($id);
    </script>
    <script src="{{ asset('js/industry_type-edit.js') }}"></script>
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
                        <form  action="" @submit.prevent="saveIndustryType({{$id}})">
                        <div class="form-group">
                            <label for="title" class="form-label">Industry Type Name</label>
                            <input id="title" type="text" class="form-control" v-model="createForm.title" placeholder="Industry Type" required>
                        </div>
                        <div class="form-group">
                            <label for="title" class="form-label">Status</label>
                            <br>
                            <toggle-button v-model="createForm.status" color="#572E8D"/>
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
