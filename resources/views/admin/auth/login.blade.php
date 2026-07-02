<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('admin.login.title') }} - Enterprise CMS</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-light min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-8 w-96">
        <h1 class="text-2xl font-bold text-primary text-center mb-6">{{ __('admin.login.title') }}</h1>
        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4">
                {{ $errors->first() }}
            </div>
        @endif
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.login.username') }}</label>
                <input type="text" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-secondary" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">{{ __('admin.login.password') }}</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-secondary" required>
            </div>
            <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90">{{ __('admin.login.submit') }}</button>
        </form>
    </div>
</body>
</html>
