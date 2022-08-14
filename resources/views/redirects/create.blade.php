@extends('redirections-views::layouts.redirects')

@section('headline')
{{ __('redirections-translations::general.newRedirect') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">

            <form action="{{ route('redirects.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-12">

                        <div class="form-group">
                            <label for="source_url">{{ __('redirections-translations::general.sourceUrl') }} *</label>
                            <input class="form-control" type="url" name="source_url" id="source_url" value="{{ old('source_url') }}">
                            @error('source_url')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="target_url">{{ __('redirections-translations::general.targetUrl') }} *</label>
                            <input class="form-control" type="url" name="target_url" id="target_url" value="{{ old('target_url') }}">
                            @error('target_url')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status_code">{{ __('redirections-translations::general.statusCode') }} *</label>
                            <select class="form-control" name="status_code" id="status_code">
                                @foreach (\PavelZanek\RedirectionsLaravel\Enums\StatusCode::cases() as $statusCode)
                                    <option value="{{ $statusCode->value }}" {{ old('status_code') !== $statusCode->value ?: 'selected' }}>
                                        {{ __('redirections-translations::general.' . $statusCode->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_code')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="col-12 mt-3">
                        <button class="btn btn-sm btn-primary" type="submit"> {{ __('redirections-translations::general.saveButton') }} *</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection