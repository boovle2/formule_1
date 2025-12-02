<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    @include('header')

    <div class="grid grid-cols-3 align-items-center justify-items-center">
        <div class="bg-white mx-7 p-2 mb-4 rounded-2xl shadow-lg col-start-2 mt-20 w-full h-130">

            <h1 class="text-2xl font-bold mb-4 mt-10 text-center">Register</h1>

            <p class="mb-4 text-center">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-500">Login</a>
            </p>

            <form class="flex flex-col px-8" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input
                    id="name"
                    type="text"
                    name="name"
                    class="outline-0 border-b-2 border-black pb-2 mb-4 w-full"
                    placeholder="Name"
                    :value="old('name')"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />

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
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <!-- Password -->
                <x-input-label for="password" :value="__('Password')" class="mt-4" />
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    class="outline-0 border-b-2 border-black pb-2 mb-4 w-full"
                    placeholder="Password"
                    required
                    autocomplete="new-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <!-- Confirm Password -->
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="mt-4" />
                <x-text-input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="outline-0 border-b-2 border-black pb-2 mb-6 w-full"
                    placeholder="Confirm Password"
                    required
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                <!-- Submit -->
                <button class="bg-blue-500 text-white rounded-lg p-2 mt-2" type="submit">
                    Register
                </button>

            </form>

        </div>
    </div>

</body>
</html>