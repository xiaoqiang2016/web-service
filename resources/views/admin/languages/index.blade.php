@extends('admin.layouts.master')

@section('title', __('admin.languages.index.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-primary">{{ __('admin.languages.index.header') }}</h3>
            <a href="{{ route('admin.languages.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</a>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">{{ __('admin.common.id') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.locale') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.name') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.is_default') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.is_active') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($languages as $language)
                    <tr>
                        <td class="py-2">{{ $language->id }}</td>
                        <td class="py-2">{{ $language->locale }}</td>
                        <td class="py-2">{{ $language->name }}</td>
                        <td class="py-2">{{ $language->is_default ? __('admin.common.yes') : __('admin.common.no') }}</td>
                        <td class="py-2">{{ $language->is_active ? __('admin.common.yes') : __('admin.common.no') }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.languages.edit', $language) }}" class="text-secondary hover:underline">{{ __('admin.actions.edit') }}</a>
                            <form action="{{ route('admin.languages.destroy', $language) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('{{ __('admin.actions.confirm_delete') }}')">{{ __('admin.actions.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
