@extends('redirections-views::layouts.redirects')

@section('headline')
{{ __('redirections-translations::general.redirectsHeadline') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">


            <div class="row">
                <div class="col-12">
                    <p>
                        <a href="{{ route('redirects.create') }}" class="btn btn-primary btn-sm">
                            {{ __('redirections-translations::general.newRedirectButton') }}
                        </a>
                    </p>
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