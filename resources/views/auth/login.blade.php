<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    @include('header')

    <div class="grid grid-cols-3 align-items-center justify-items-center">
        <div class="bg-white mx-7 p-2 mb-4 rounded-2xl shadow-lg col-start-2 mt-20 w-full h-auto">

            <h1 class="text-2xl font-bold mb-4 mt-10 text-center">Login</h1>

            <p class="mb-4 text-center">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-500">Register here</a>
            </p>

            <!-- Breeze Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form class="flex flex-col px-8" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    class="outline-0 border-b-2 border-black pb-2 mb-4 w-full"
                    placeholder="Email"
                    :value="old('email')"
                    required
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <!-- Password -->
                <x-input-label for="password" :value="__('Password')" class="mt-4" />
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    class="outline-0 border-b-2 border-black pb-2 mb-6 w-full"
                    placeholder="Password"
                    required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <!-- Remember Me -->
                <label for="remember_me" class="inline-flex items-center mb-4">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                <!-- Forgot password? -->
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 mb-3 text-right"
                    href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
                @endif

                <!-- Submit -->
                <button class="bg-blue-500 text-white rounded-lg p-2 mt-2" type="submit">
                    Log in
                </button>

            </form>

        </div>
    </div>

</body>

</html>


