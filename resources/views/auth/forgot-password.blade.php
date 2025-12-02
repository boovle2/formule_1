<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    @include('header')

    <div class="grid grid-cols-3 align-items-center justify-items-center">
        <div class="bg-white mx-7 p-2 mb-4 rounded-2xl shadow-lg col-start-2 mt-20 w-full h-auto">

            <h1 class="text-2xl font-bold mb-4 mt-10 text-center">Forgot Password</h1>

            <p class="mb-4 text-center">
                Enter your email address and we will email you a password reset link.
            </p>

            <!-- Breeze Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form class="flex flex-col px-8" method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    class="outline-0 border-b-2 border-black pb-2 mb-6 w-full"
                    placeholder="Email"
                    :value="old('email')"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <!-- Submit -->
                <button class="bg-blue-500 text-white rounded-lg p-2 mt-2 mb-8" type="submit">
                    Email Password Reset Link
                </button>

                <p class="text-center mb-6">
                    <a href="{{ route('login') }}" class="text-blue-500">Back to login</a>
                </p>
            </form>

        </div>
    </div>

</body>

</html>