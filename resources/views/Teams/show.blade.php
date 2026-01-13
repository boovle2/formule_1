<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $team->name }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('teams.index') }}" class="inline-block text-red-500 hover:text-red-400 font-semibold mb-8">
                ← Back to Teams
            </a>

            <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
                <!-- Header with Logo -->
                <div class="relative h-64 bg-gray-700 overflow-hidden">
                    @if ($team->logo)
                        <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-600 to-red-800">
                            <span class="text-white text-9xl font-bold opacity-20">{{ substr($team->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Team Info -->
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $team->name }}</h1>
                    <p class="text-gray-400 text-lg mb-8">Formula 1 Team</p>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gray-700 rounded-lg p-6">
                            <p class="text-gray-400 text-sm mb-2">POINTS</p>
                            <p class="text-4xl font-bold text-white">{{ $team->points }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-6">
                            <p class="text-gray-400 text-sm mb-2">CHAMPIONSHIPS</p>
                            <p class="text-4xl font-bold text-white">{{ $team->championships ?? 0 }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-6">
                            <p class="text-gray-400 text-sm mb-2">TEAM PRINCIPAL</p>
                            <p class="text-white font-semibold">{{ $team->team_principal ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
@include('footer')
