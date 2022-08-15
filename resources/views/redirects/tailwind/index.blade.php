@extends('redirections-views::layouts.tailwind')

@section('headline')
{{ __('redirections-translations::general.redirectsHeadline') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">

            <div class="flex flex-column md:flex-row justify-center md:justify-between items-center">
                <div class="">
                    <a href="{{ route('redirects.create') }}" class="mr-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('redirections-translations::general.newRedirectButton') }}
                    </a>
                    <a href="{{ route('redirects.export') }}" class="mr-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('redirections-translations::general.exportButton') }}
                    </a>
                    <button class="modal-open bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('redirections-translations::general.importButton') }}
                    </button>
                </div>
                <div class="">
                    <form action="{{ route('redirects.index') }}" class="">
                        <div class="form-group d-flex flex-row justify-content-end align-items-center">
                            <input class="form-control" type="text" id="search" name="search" placeholder="{{ __('redirections-translations::general.searchPlaceholder') }}" value="{{ request()->get('search') }}">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('redirections-translations::general.searchButton') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal -->

            <!--Modal-->
            <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
                <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                    
                        <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                            <span class="text-sm">(Esc)</span>
                        </div>

                        <!-- Add margin if you want to see some of the overlay behind the modal-->
                        <div class="modal-content py-4 text-left px-6">
                            <form action="{{ route('redirects.import') }}" method="POST" enctype="multipart/form-data">
                                <!--Title-->
                                <div class="flex justify-between items-center pb-3">
                                    <p class="text-2xl font-bold">{{ __('redirections-translations::general.importModalHeadline') }}</p>
                                    <div class="modal-close cursor-pointer z-50">
                                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!--Body-->
                                @csrf
                                <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                                    <div class="custom-file text-left">
                                        <div class="flex justify-center">
                                            <div class="mb-3">
                                                <label for="customFile" class="form-label inline-block mb-2 text-gray-700">{{ __('redirections-translations::general.chooseFileButton') }}</label>
                                                <input name="csv" class="form-control
                                                block
                                                w-full
                                                px-3
                                                py-1.5
                                                text-base
                                                font-normal
                                                text-gray-700
                                                bg-white bg-clip-padding
                                                border border-solid border-gray-300
                                                rounded
                                                transition
                                                ease-in-out
                                                m-0
                                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="customFile">
                                            </div>
                                        </div>
                                        <p>
                                            <small>{{ __('redirections-translations::general.chooseFileInfo') }}</small>
                                        </p>
                                        @error('csv')
                                            <div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!--Footer-->
                                <div class="flex justify-end pt-2">
                                    <a href="{{ route('redirects.index') }}" class="modal-close px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">{{ __('redirections-translations::general.closeButton') }}</a>
                                    <button type="submit" class="px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">{{ __('redirections-translations::general.importRedirectsButton') }}</button>
                                </div>
                            </form>
                            
                        </div>

                    </div>
            </div>

            @if (count($redirects) > 0)

                <div>
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="bg-white border-b">
                                            <tr>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ __('redirections-translations::general.sourceUrl') }}</th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ __('redirections-translations::general.targetUrl') }}</th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ __('redirections-translations::general.statusCode') }}</th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ __('redirections-translations::general.lastHit') }}</th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ __('redirections-translations::general.hits') }}</th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ __('redirections-translations::general.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($redirects as $redirect)
                                                <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $redirect->source_url }}</td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $redirect->target_url }}</td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ __('redirections-translations::general.' . $redirect->status_code->name) }}</td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $redirect->last_used?->diffForHumans() }}<br />
                                                        <small>{{ $redirect->last_used?->format('Y-m-d H:i') }}</small>
                                                    </td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $redirect->redirect_data_count }}</td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        <a href="{{ route('redirects.show', $redirect->id) }}" class="mr-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('redirections-translations::general.showRecord') }}
                                                        </a>
                                                        <a href="{{ route('redirects.edit', $redirect->id) }}" class="mr-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('redirections-translations::general.editRecord') }}
                                                        </a>
                                                        <form action="{{ route('redirects.destroy', $redirect->id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit"
                                                                onclick="return confirm('{{ __('redirections-translations::general.areYouSure') }}')"> {{ __('redirections-translations::general.deleteRecord') }}</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{ $redirects->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else

                <div class="w-full mt-5">
                    <p>
                        {{ __('redirections-translations::general.noRedirects') }}
                    </p>
                </div>

            @endif

        </div>
    </div>
@endsection

@if($errors->has('csv'))
    @section('footerScripts')
        <script>
            toggleModal();
        </script>
    @endsection
@endif