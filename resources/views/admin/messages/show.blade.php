@extends('admin.layouts.master')

@section('title', __('admin.messages.show.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.messages.show.title') }}</h3>
        <div class="space-y-4">
            <div class="border-b pb-4">
                <div class="text-gray-cool">{{ __('admin.common.name') }}</div>
                <div class="font-semibold text-primary">{{ $message->name }}</div>
            </div>
            <div class="border-b pb-4">
                <div class="text-gray-cool">{{ __('admin.common.email') }}</div>
                <div class="font-semibold text-primary">{{ $message->email }}</div>
            </div>
            <div class="border-b pb-4">
                <div class="text-gray-cool">{{ __('admin.common.phone') }}</div>
                <div class="font-semibold text-primary">{{ $message->phone ?? '-' }}</div>
            </div>
            <div class="border-b pb-4">
                <div class="text-gray-cool">{{ __('admin.common.company') }}</div>
                <div class="font-semibold text-primary">{{ $message->company ?? '-' }}</div>
            </div>
            <div class="border-b pb-4">
                <div class="text-gray-cool">{{ __('admin.common.subject') }}</div>
                <div class="font-semibold text-primary">{{ $message->subject ?? '-' }}</div>
            </div>
            <div class="border-b pb-4">
                <div class="text-gray-cool">{{ __('admin.common.content') }}</div>
                <div class="text-gray-700">{{ $message->content }}</div>
            </div>
        </div>
    </div>
@endsection
