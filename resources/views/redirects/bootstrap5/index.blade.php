@extends('redirections-views::layouts.bootstrap5')

@section('headline')
{{ __('redirections-translations::general.redirectsHeadline') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">


            <div class="row">
                <div class="col-12 col-md-6">
                    <p>
                        <a href="{{ route('redirects.create') }}" class="btn btn-primary btn-sm">
                            {{ __('redirections-translations::general.newRedirectButton') }}
                        </a>
                        <a href="{{ route('redirects.export') }}" class="btn btn-primary btn-sm">
                            {{ __('redirections-translations::general.exportButton') }}
                        </a>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                            {{ __('redirections-translations::general.importButton') }}
                        </button>
                    </p>
                </div>
                <div class="col-12 col-md-6">
                    <form action="{{ route('redirects.index') }}" class="">
                        <div class="form-group d-flex flex-row justify-content-end align-items-center">
                            <input class="form-control" type="text" id="search" name="search" placeholder="{{ __('redirections-translations::general.searchPlaceholder') }}" value="{{ request()->get('search') }}">
                            <button type="submit" class="btn btn-secondary">
                                {{ __('redirections-translations::general.searchButton') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('redirects.import') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importModalLabel">{{ __('redirections-translations::general.importModalHeadline') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                                    <div class="custom-file text-left">
                                        <label class="custom-file-label" for="customFile">{{ __('redirections-translations::general.chooseFileButton') }}</label>
                                        <input type="file" name="csv" class="custom-file-input" id="customFile">
                                        <p>
                                            <small>{{ __('redirections-translations::general.chooseFileInfo') }}</small>
                                        </p>
                                        @error('csv')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('redirections-translations::general.closeButton') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('redirections-translations::general.importRedirectsButton') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (count($redirects) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>{{ __('redirections-translations::general.sourceUrl') }}</th>
                                            <th>{{ __('redirections-translations::general.targetUrl') }}</th>
                                            <th>{{ __('redirections-translations::general.statusCode') }}</th>
                                            <th>{{ __('redirections-translations::general.lastHit') }}</th>
                                            <th>{{ __('redirections-translations::general.hits') }}</th>
                                            <th>{{ __('redirections-translations::general.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($redirects as $redirect)
                                            <tr>
                                                <td>{{ $redirect->source_url }}</td>
                                                <td>{{ $redirect->target_url }}</td>
                                                <td>{{ __('redirections-translations::general.' . $redirect->status_code->name) }}</td>
                                                <td>
                                                    {{ $redirect->last_used?->diffForHumans() }}<br />
                                                    <small>{{ $redirect->last_used?->format('Y-m-d H:i') }}</small>
                                                </td>
                                                <td>{{ $redirect->redirect_data_count }}</td>
                                                <td>
                                                    <a href="{{ route('redirects.show', $redirect->id) }}" class="btn btn-sm btn-primary">
                                                        {{ __('redirections-translations::general.showRecord') }}
                                                    </a>
                                                    <a href="{{ route('redirects.edit', $redirect->id) }}" class="btn btn-sm btn-secondary">
                                                        {{ __('redirections-translations::general.editRecord') }}
                                                    </a>
                                                    <form action="{{ route('redirects.destroy', $redirect->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" type="submit"
                                                            onclick="return confirm('{{ __('redirections-translations::general.areYouSure') }}')"> {{ __('redirections-translations::general.deleteRecord') }}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $redirects->links('pagination::bootstrap-5') }}

                            </div>
                        </div>
                    </div>
                </div>

            @else

                <div class="row">
                    <div class="col-12">
                        <p>
                            {{ __('redirections-translations::general.noRedirects') }}
                        </p>
                    </div>
                </div>

            @endif

        </div>
    </div>
@endsection

@if($errors->has('csv'))
    @section('footerScripts')
        <script>
            var importModal = new bootstrap.Modal(document.getElementById("importModal"), {});
            document.onreadystatechange = function () {
                importModal.show();
            };
        </script>
    @endsection
@endif