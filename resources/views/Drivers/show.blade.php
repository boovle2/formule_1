<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $driver->Fname }} {{ $driver->Lname }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('drivers.index') }}" class="inline-block text-red-500 hover:text-red-400 font-semibold mb-8">
                ← Back to Drivers
            </a>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column - Photo -->
                <div class="md:col-span-1">
                    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden h-full">
                        <div class="relative h-96 bg-gray-700 flex items-center justify-center">
                            @if ($driver->image)
                                <img src="{{ asset('storage/' . $driver->image) }}" alt="{{ $driver->Fname }} {{ $driver->Lname }}" class="w-full h-full object-cover object-top">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-600 to-red-800">
                                    <span class="text-white text-7xl font-bold opacity-20">#{{ $driver->number ?? '?' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Info -->
                <div class="md:col-span-2">
                    <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                        <!-- Name and Number -->
                        <div class="mb-6">
                            <div class="flex items-center gap-4 mb-4">
                                <h1 class="text-4xl font-bold text-white">{{ $driver->Fname }} {{ $driver->Lname }}</h1>
                                <span class="bg-red-600 text-white font-bold px-4 py-2 rounded-full text-2xl">
                                    #{{ $driver->number ?? 'N/A' }}
                                </span>
                            </div>
                            <p class="text-gray-400 text-lg">Formula 1 Driver</p>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-8 pb-8 border-b border-gray-700">
                            <div class="bg-gray-700 rounded-lg p-4">
                                <p class="text-gray-400 text-sm mb-2">CHAMPIONSHIP POINTS</p>
                                <p class="text-3xl font-bold text-white">{{ $driver->points }}</p>
                            </div>
                            <div class="bg-gray-700 rounded-lg p-4">
                                <p class="text-gray-400 text-sm mb-2">DRIVER NUMBER</p>
                                <p class="text-3xl font-bold text-red-500">#{{ $driver->number ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Team Info -->
                        <div class="mb-8">
                            <h3 class="text-white font-bold text-lg mb-4">Team Information</h3>
                            @if ($driver->team_id)
                                @php
                                    $team = \App\Models\TeamModel::find($driver->team_id);
                                @endphp
                                @if ($team)
                                    <div class="bg-gray-700 rounded-lg p-4">
                                        <h4 class="text-white font-bold text-xl mb-2">
                                            <a href="{{ route('teams.show', $team->id) }}" class="hover:text-red-500 transition">
                                                {{ $team->name }}
                                            </a>
                                        </h4>
                                        <div class="space-y-2 text-gray-300 text-sm">
                                            <div>
                                                <span class="text-gray-400">Team Principal:</span>
                                                <span class="font-semibold">{{ $team->team_principal ?? 'N/A' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-400">Team Points:</span>
                                                <span class="font-semibold">{{ $team->points }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="bg-gray-700 rounded-lg p-4 text-gray-400">
                                    <p>Not currently part of any team</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
@include('footer')
