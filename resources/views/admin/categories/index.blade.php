@extends('admin.layouts.master')

@section('title', __('admin.categories.index.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-primary">{{ __('admin.categories.index.header') }}</h3>
            <a href="{{ route('admin.categories.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</a>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">{{ __('admin.common.name') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.type') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.parent') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.show') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    @if($category->parent_id == 0)
                        <tr>
                            <td class="py-2 font-semibold">{{ get_translated($category, 'name') }}</td>
                            <td class="py-2">{{ $category->type }}</td>
                            <td class="py-2">-</td>
                            <td class="py-2">{{ $category->is_show ? __('admin.common.yes') : __('admin.common.no') }}</td>
                            <td class="py-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-secondary hover:underline">{{ __('admin.actions.edit') }}</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('{{ __('admin.actions.confirm_delete') }}')">{{ __('admin.actions.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                        @foreach($category->children as $child)
                            <tr>
                                <td class="py-2 pl-8">└─ {{ get_translated($child, 'name') }}</td>
                                <td class="py-2">{{ $child->type }}</td>
                                <td class="py-2">{{ get_translated($category, 'name') }}</td>
                                <td class="py-2">{{ $child->is_show ? __('admin.common.yes') : __('admin.common.no') }}</td>
                                <td class="py-2">
                                    <a href="{{ route('admin.categories.edit', $child) }}" class="text-secondary hover:underline">{{ __('admin.actions.edit') }}</a>
                                    <form action="{{ route('admin.categories.destroy', $child) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('{{ __('admin.actions.confirm_delete') }}')">{{ __('admin.actions.delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @foreach($child->children as $grandchild)
                                <tr>
                                    <td class="py-2 pl-16">&nbsp;&nbsp;&nbsp;&nbsp;└─ {{ get_translated($grandchild, 'name') }}</td>
                                    <td class="py-2">{{ $grandchild->type }}</td>
                                    <td class="py-2">{{ get_translated($child, 'name') }}</td>
                                    <td class="py-2">{{ $grandchild->is_show ? __('admin.common.yes') : __('admin.common.no') }}</td>
                                    <td class="py-2">
                                        <a href="{{ route('admin.categories.edit', $grandchild) }}" class="text-secondary hover:underline">{{ __('admin.actions.edit') }}</a>
                                        <form action="{{ route('admin.categories.destroy', $grandchild) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('{{ __('admin.actions.confirm_delete') }}')">{{ __('admin.actions.delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
