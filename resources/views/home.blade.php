<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - PoinQu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Login ke PoinQu</h2>
        @if(session('status'))
            <div class="mb-4 text-green-600">
                {{ session('status') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 text-red-600">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1" for="email">Email</label>
                <input class="w-full px-3 py-2 border rounded" type="email" name="email" id="email" required autofocus>
            </div>
            <div class="mb-6">
                <label class="block mb-1" for="password">Password</label>
                <input class="w-full px-3 py-2 border rounded" type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
        </form>
        <div class="mt-6 text-center">
            <span>Belum punya akun? </span>
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register di sini</a>
        </div>
    </div>
</body>
</html>