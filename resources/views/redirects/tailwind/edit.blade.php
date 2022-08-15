@extends('redirections-views::layouts.tailwind')

@section('headline')
{{ __('redirections-translations::general.editRedirect') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">

            <form action="{{ route('redirects.update', $redirect) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="w-full mt-5">
                    <div class="">

                        <div class="mb-4">
                            <label for="source_url" class="block text-gray-700 text-sm font-bold mb-2">{{ __('redirections-translations::general.sourceUrl') }} *</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="url" name="source_url" id="source_url" value="{{ old('source_url') ?? $redirect->source_url }}" disabled>
                            @error('source_url')
                                <div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="target_url" class="block text-gray-700 text-sm font-bold mb-2">{{ __('redirections-translations::general.targetUrl') }} *</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="url" name="target_url" id="target_url" value="{{ old('target_url') ?? $redirect->target_url }}">
                            @error('target_url')
                                <div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status_code" class="block text-gray-700 text-sm font-bold mb-2">{{ __('redirections-translations::general.statusCode') }} *</label>
                            <select class="form-select appearance-none
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding bg-no-repeat
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"  name="status_code" id="status_code">
                                @foreach (\PavelZanek\RedirectionsLaravel\Enums\StatusCode::cases() as $statusCode)
                                    <option value="{{ $statusCode->value }}" {{ old('status_code', $redirect->status_code->value) !== $statusCode->value ?: 'selected' }}>
                                        {{ __('redirections-translations::general.' . $statusCode->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_code')
                                <div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="w-full mt-5">
                        <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" href="{{ route('redirects.index') }}"> {{ __('redirections-translations::general.backButton') }}</a>
                        <button class="px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400" type="submit"> {{ __('redirections-translations::general.saveButton') }}</button>
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