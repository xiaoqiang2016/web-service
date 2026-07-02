@extends('admin.layouts.master')

@section('title', __('admin.dashboard.title'))

@section('content')
    <div class="grid grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-primary">{{ $stats['articles'] }}</div>
            <div class="text-gray-cool">{{ __('admin.dashboard.articles') }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-primary">{{ $stats['products'] }}</div>
            <div class="text-gray-cool">{{ __('admin.dashboard.products') }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-primary">{{ $stats['cases'] }}</div>
            <div class="text-gray-cool">{{ __('admin.dashboard.cases') }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-secondary">{{ $stats['messages'] }}</div>
            <div class="text-gray-cool">{{ __('admin.dashboard.messages') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-primary mb-4">{{ __('admin.dashboard.recent_messages') }}</h3>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left py-2">{{ __('admin.common.name') }}</th>
                        <th class="text-left py-2">{{ __('admin.common.email') }}</th>
                        <th class="text-left py-2">{{ __('admin.common.subject') }}</th>
                        <th class="text-left py-2">{{ __('admin.common.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentMessages as $message)
                        <tr>
                            <td class="py-2"><a href="{{ route('admin.messages.show', $message) }}">{{ $message->name }}</a></td>
                            <td class="py-2">{{ $message->email }}</td>
                            <td class="py-2">{{ $message->subject }}</td>
                            <td class="py-2">{{ $message->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-primary mb-4">{{ __('admin.dashboard.recent_articles') }}</h3>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left py-2">{{ __('admin.common.title') }}</th>
                        <th class="text-left py-2">{{ __('admin.common.status') }}</th>
                        <th class="text-left py-2">{{ __('admin.common.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentArticles as $article)
                        <tr>
                            <td class="py-2">{{ get_translated($article, 'title') }}</td>
                            <td class="py-2">{{ $article->status == 1 ? __('admin.dashboard.published') : __('admin.dashboard.draft') }}</td>
                            <td class="py-2">{{ $article->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
