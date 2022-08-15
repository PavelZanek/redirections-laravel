@extends('redirections-views::layouts.tailwind')

@section('headline')
{{ __('redirections-translations::general.infoAboutRedirect') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">

            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="px-3">
                    <div class="card">
                        <div class="card-header font-bold text-2xl">{{ __('redirections-translations::general.basicInfo') }}</div>
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
                <div class="px-3">
                    <div class="card">
                        <div class="card-header font-bold text-2xl">{{ __('redirections-translations::general.hits') }} <small>{{ __('redirections-translations::general.last10hits') }}</small></div>
                        <div class="card-body">
                            <div class="flex flex-col">
                                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full">
                                                <thead class="bg-white border-b">
                                                    <tr>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ __('redirections-translations::general.date') }}</th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ __('redirections-translations::general.hits') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($redirectData as $key => $redirectItem)
                                                        <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $key }}</td>
                                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ count($redirectItem) }}x</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-3">
                    <div class="card">
                        <div class="card-header font-bold text-2xl">{{ __('redirections-translations::general.basicChart') }}</div>
                        <div class="card-body">
                            <canvas id="redirectsChart" height="100px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full mt-5">
                <a class="mr-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" href="{{ route('redirects.index') }}">{{ __('redirections-translations::general.backButton') }}</a>
                <a href="{{ route('redirects.edit', $redirect->id) }}" class="mr-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('redirections-translations::general.editRecord') }}
                </a>
                <form action="{{ route('redirects.destroy', $redirect->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit"
                        onclick="return confirm('{{ __('redirections-translations::general.areYouSure') }}')"> {{ __('redirections-translations::general.deleteRecord') }}</button>
                </form>
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