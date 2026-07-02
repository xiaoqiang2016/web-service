@extends('admin.layouts.master')

@section('title', __('admin.banners.index.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-primary">{{ __('admin.banners.index.header') }}</h3>
            <a href="{{ route('admin.banners.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</a>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">{{ __('admin.common.image') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.title') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.position') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.show') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banners as $banner)
                    <tr>
                        <td class="py-2"><img src="{{ asset('storage/' . $banner->image) }}" class="w-24 h-16 object-cover"></td>
                        <td class="py-2">{{ get_translated($banner, 'title') }}</td>
                        <td class="py-2">{{ $banner->position }}</td>
                        <td class="py-2">{{ $banner->is_show ? __('admin.common.yes') : __('admin.common.no') }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="text-secondary hover:underline">{{ __('admin.actions.edit') }}</a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('{{ __('admin.actions.confirm_delete') }}')">{{ __('admin.actions.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $banners->links() }}
        </div>
    </div>
@endsection
