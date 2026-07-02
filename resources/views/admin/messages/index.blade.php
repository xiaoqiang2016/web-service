@extends('admin.layouts.master')

@section('title', __('admin.messages.index.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.messages.index.header') }}</h3>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">{{ __('admin.common.name') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.email') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.subject') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.status') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.date') }}</th>
                    <th class="text-left py-2">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td class="py-2">{{ $message->name }}</td>
                        <td class="py-2">{{ $message->email }}</td>
                        <td class="py-2">{{ $message->subject }}</td>
                        <td class="py-2">
                            @if($message->status == 0)
                                <span class="text-yellow-500">{{ __('admin.messages.unread') }}</span>
                            @elseif($message->status == 1)
                                <span class="text-blue-500">{{ __('admin.messages.read') }}</span>
                            @else
                                <span class="text-green-500">{{ __('admin.messages.replied') }}</span>
                            @endif
                        </td>
                        <td class="py-2">{{ $message->created_at->format('Y-m-d') }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.messages.show', $message) }}" class="text-secondary hover:underline">{{ __('admin.actions.show') }}</a>
                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline">
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
            {{ $messages->links() }}
        </div>
    </div>
@endsection
