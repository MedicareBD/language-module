@extends('core::layouts.admin.app')

@section('title', __('Create Language'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __("Add Language") }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.languages.index') }}" class="btn btn-primary">
                            <i class="fas fa-language"></i> {{ __('Language List') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.languages.store') }}" method="post" class="instant_reload_form">
                        <div class="form-group">
                            <label for="language" class="required">{{ __("Language Name") }}</label>
                            <select name="language" id="language" data-control="select2" data-placeholder="{{ __("Select Language") }}" required>
                                <option></option>
                                @foreach($languages as $code => $language)
                                    <option value="{{ $code }}">{{ $language['name'] }} - {{ $language['nativeName'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary waves-effect waves-light float-right submit-button">
                            <i class="fas fa-save"></i>
                            {{ __("Save") }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
