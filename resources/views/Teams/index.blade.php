<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Formula 1 Teams</h1>
                <p class="text-gray-300 text-lg">Discover all the teams competing in the championship</p>
            </div>

            

            <!-- Teams Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                @forelse ($teams as $team)
                    <div class="group relative bg-gray-800 rounded-xl overflow-visible shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <!-- Logo/Image Section -->
                        <div class="relative h-48 bg-gray-700 overflow-hidden">
                            @if ($team->logo)
                                <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-600 to-red-800">
                                    <span class="text-white text-6xl font-bold opacity-20">{{ substr($team->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Team Info Section -->
                        <div class="p-4 relative z-10">
                            <!-- Team Name -->
                            <h3 class="text-xl font-bold text-white mb-3 truncate">
                                <a href="{{ route('teams.show', $team->id) }}" class="hover:text-red-500 transition">
                                    {{ $team->name }}
                                </a>
                            </h3>

                            <!-- Stats -->
                            <div class="space-y-2 text-sm text-gray-300 mb-4">
                                <div class="flex justify-between">
                                    <span>Points:</span>
                                    <span class="font-bold text-white">{{ $team->points }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Championships:</span>
                                    <span class="font-bold text-white">{{ $team->championships ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Principal:</span>
                                    <span class="font-bold text-white">{{ $team->team_principal ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="pt-4 border-t border-gray-700 space-y-2">
                                <a href="{{ route('teams.show', $team->id) }}" class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-semibold py-2 rounded-lg transition duration-300">
                                    View Details
                                </a>
                                
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-400 text-lg">No teams found. <a href="{{ route('admin.index') }}" class="text-red-500 hover:text-red-400">Create one now</a></p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
 
</body>
</html>
@include('footer')      