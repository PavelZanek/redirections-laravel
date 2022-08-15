@extends('redirections-views::layouts.bootstrap5')

@section('headline')
{{ __('redirections-translations::general.infoAboutRedirect') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">

            <div class="row">
                <div class="col-12 col-md-4 mt-3">
                    <div class="card">
                        <div class="card-header font-weight-bold">{{ __('redirections-translations::general.basicInfo') }}</div>
                        <div class="card-body">
                            <p>
                                <strong>{{ __('redirections-translations::general.sourceUrl') }}:</strong> {{ $redirect->source_url }}
                            </p>
                            <p>
                                <strong>{{ __('redirections-translations::general.targetUrl') }}:</strong> {{ $redirect->target_url }}
                            </p>
                            <p>
                                <strong>{{ __('redirections-translations::general.lastHit') }}:</strong> {{ $redirect->last_used?->diffForHumans() ?: __('redirections-translations::general.noHit') }}
                                @if ($redirect->last_used)
                                    <small>({{ $redirect->last_used->format('Y-m-d H:i') }})</small>
                                @endif
                            </p>
                            <p>
                                <strong>{{ __('redirections-translations::general.hits') }}:</strong> {{ count($redirect->redirectData) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-3">
                    <div class="card">
                        <div class="card-header font-weight-bold">{{ __('redirections-translations::general.hits') }} <small>{{ __('redirections-translations::general.last10hits') }}</small></div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('redirections-translations::general.date') }}</th>
                                        <th>{{ __('redirections-translations::general.hits') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($redirectData as $key => $redirectItem)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{ count($redirectItem) }}x</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-3">
                    <div class="card">
                        <div class="card-header font-weight-bold">{{ __('redirections-translations::general.basicChart') }}</div>
                        <div class="card-body">
                            <canvas id="redirectsChart" height="100px"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5">
                    <a class="btn btn-sm btn-secondary" href="{{ route('redirects.index') }}">{{ __('redirections-translations::general.backButton') }}</a>
                    <a href="{{ route('redirects.edit', $redirect->id) }}" class="btn btn-sm btn-secondary">
                        {{ __('redirections-translations::general.editRecord') }}
                    </a>
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

@section('footerScripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
  
    var labels =  {{ Js::from($labels) }};
    var users =  {{ Js::from($data) }};

    const data = {
      labels: labels,
      datasets: [{
        label: 'Hits',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: users,
      }]
    };

    const config = {
      type: 'line',
      data: data,
      options: {}
    };

    const myChart = new Chart(
      document.getElementById('redirectsChart'),
      config
    );

</script>
@endsection