@extends('admin.layouts.master')

@section('title', __('admin.articles.index.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-primary">{{ __('admin.articles.index.header') }}</h3>
            <a href="{{ route('admin.articles.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</a>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">{{ __('admin.common.title') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.category') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.status') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.date') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td class="py-2">{{ get_translated($article, 'title') }}</td>
                        <td class="py-2">{{ get_translated($article->category, 'name') ?? '-' }}</td>
                        <td class="py-2">{{ $article->status == 1 ? __('admin.dashboard.published') : __('admin.dashboard.draft') }}</td>
                        <td class="py-2">{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('Y-m-d') : '-' }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="text-secondary hover:underline">{{ __('admin.actions.edit') }}</a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline">
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
            {{ $articles->links() }}
        </div>
    </div>
@endsection
