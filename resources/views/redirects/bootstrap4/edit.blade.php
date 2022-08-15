@extends('redirections-views::layouts.bootstrap4')

@section('headline')
{{ __('redirections-translations::general.editRedirect') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">

            <form action="{{ route('redirects.update', $redirect) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12">

                        <div class="form-group">
                            <label for="source_url" class="form-label">{{ __('redirections-translations::general.sourceUrl') }} *</label>
                            <input class="form-control" type="url" name="source_url" id="source_url" value="{{ old('source_url') ?? $redirect->source_url }}" disabled>
                            @error('source_url')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" class="form-label">
                            <label for="target_url">{{ __('redirections-translations::general.targetUrl') }} *</label>
                            <input class="form-control" type="url" name="target_url" id="target_url" value="{{ old('target_url') ?? $redirect->target_url }}">
                            @error('target_url')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" class="form-label">
                            <label for="status_code">{{ __('redirections-translations::general.statusCode') }} *</label>
                            <select class="form-control" name="status_code" id="status_code">
                                @foreach (\PavelZanek\RedirectionsLaravel\Enums\StatusCode::cases() as $statusCode)
                                    <option value="{{ $statusCode->value }}" {{ old('status_code', $redirect->status_code->value) !== $statusCode->value ?: 'selected' }}>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('redirects.index') }}"> {{ __('redirections-translations::general.backButton') }}</a>
                        <button class="btn btn-sm btn-primary" type="submit"> {{ __('redirections-translations::general.saveButton') }}</button>
                    </div>

                </div>
            </form>

            <div class="row mt-5">
                <div class="col-12">
                    <form action="{{ route('redirects.destroy', $redirect->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit"
                            onclick="return confirm('{{ __('redirections-translations::general.areYouSure') }}')"> {{ __('redirections-translations::general.deleteRecord') }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection