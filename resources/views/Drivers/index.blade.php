<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drivers</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    @include('header')

    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Formula 1 Drivers</h1>
                <p class="text-gray-300 text-lg">Meet the world's best drivers</p>
            </div>



            <!-- Drivers Grid (4 columns - up to 20 drivers) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($drivers as $driver)
                <div class="group relative bg-gray-800 rounded-xl overflow-visible shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                    <!-- Driver Image Section -->
                    <div class="relative h-56 bg-gray-700 overflow-hidden flex items-center justify-center">
                        @if ($driver->image)
                        <img src="{{ asset('storage/' . $driver->image) }}" alt="{{ $driver->Fname }} {{ $driver->Lname }}" class="w-full h-full object-cover object-top group-hover:scale-110 transition duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-600 to-red-800">
                            <div class="text-center">
                                <span class="text-white text-6xl font-bold opacity-30">#{{ $driver->number ?? '?' }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Driver Info Section -->
                    <div class="p-4 relative z-10">
                        <!-- Driver Number Badge -->
                        <div class="mb-3">
                            <span class="inline-block bg-red-600 text-white font-bold px-3 py-1 rounded-full text-sm">
                                #{{ $driver->number ?? 'N/A' }}
                            </span>
                        </div>

                        <!-- Driver Name -->
                        <h3 class="text-2xl font-bold text-white mb-1 truncate">
                            <a href="{{ route('drivers.show', $driver->id) }}" class="hover:text-red-500 transition">
                                {{ $driver->Fname }} {{ $driver->Lname }}
                            </a>
                        </h3>

                        <!-- Stats -->
                        <div class="space-y-2 text-sm text-gray-300 mb-4">
                            <div class="flex justify-between">
                                <span>Points:</span>
                                <span class="font-bold text-white">{{ $driver->points }}</span>
                            </div>

                            <!-- Team Info -->
                            @if ($driver->team_id)
                            @php
                            $team = \App\Models\TeamModel::find($driver->team_id);
                            @endphp
                            @if ($team)
                            <div class="flex justify-between">
                                <span>Team:</span>
                                <a href="{{ route('teams.show', $team->id) }}" class="font-bold text-red-400 hover:text-red-300 transition">
                                    {{ $team->name }}
                                </a>
                            </div>
                            @endif
                            @else
                            <div class="flex justify-between">
                                <span>Team:</span>
                                <span class="font-bold text-gray-400">No Team</span>
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="pt-4 border-t border-gray-700 space-y-2">
                            <a href="{{ route('drivers.show', $driver->id) }}" class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-semibold py-2 rounded-lg transition duration-300 text-sm">
                                View Profile
                            </a>

                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400 text-lg">No drivers found. <a href="{{ route('admin.index') }}" class="text-red-500 hover:text-red-400">Add one now</a></p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</body>

</html>
@include('footer')