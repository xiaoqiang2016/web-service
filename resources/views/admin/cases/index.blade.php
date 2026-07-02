@extends('admin.layouts.master')

@section('title', __('admin.cases.index.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-primary">{{ __('admin.cases.index.header') }}</h3>
            <a href="{{ route('admin.cases.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</a>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">{{ __('admin.common.title') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.client') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.industry') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.show') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cases as $case)
                    <tr>
                        <td class="py-2">{{ get_translated($case, 'title') }}</td>
                        <td class="py-2">{{ $case->client_name ?? '-' }}</td>
                        <td class="py-2">{{ $case->industry ?? '-' }}</td>
                        <td class="py-2">{{ $case->is_show ? __('admin.common.yes') : __('admin.common.no') }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.cases.edit', $case) }}" class="text-secondary hover:underline">{{ __('admin.actions.edit') }}</a>
                            <form action="{{ route('admin.cases.destroy', $case) }}" method="POST" class="inline">
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
