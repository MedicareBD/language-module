@extends('core::layouts.admin.app')

@section('title', __('Edit Phrases'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __("Edit :name phrases", ['name' => $language->native_name]) }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.languages.index') }}" class="btn btn-primary">
                            <i class="fas fa-language"></i> {{ __('Language List') }}
                        </a>

                        @if(config('googletranslate.api_key'))
                            <a
                                href="{{ route('admin.languages.sync', $language->id) }}"
                                class="btn btn-danger confirm-action"
                                data-icon="fas fa-sync"
                                data-content="{{ __("All Phrases will be replaced.") }}"
                            >
                                <i class="fas fa-sync"></i> {{ __('Translate From Google') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.languages.update', $language->id) }}" method="post" class="instant_reload_form">
                        @method('PUT')
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{{ __("Phrase Key") }}</th>
                                <th>{{ __("Value") }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($phrases as $key => $value)
                                <tr>
                                    <th>{{ $key }}</th>
                                    <td>
                                        <input type="text" name="phrases[{{ $key }}]" class="form-control" value="{{ $value }}" placeholder="{{ $value }}" aria-label="">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <button class="btn btn-primary waves-effect waves-light float-right submit-button mt-3">
                            <i class="fas fa-save"></i>
                            {{ __("Update") }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pageScripts')
    <script>
        $('.table').DataTable({
            stateSave: true,
        });
    </script>
@endpush
