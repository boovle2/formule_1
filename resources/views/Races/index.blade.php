<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Races</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Formula 1 Races</h1>
                <p class="text-gray-300 text-lg">2025 Championship Calendar</p>
            </div>


            <!-- Races Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($races as $race)
                    <div class="group relative bg-gray-800 rounded-xl overflow-visible shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <!-- Race Image Section -->
                        <div class="relative h-48 bg-gray-700 overflow-hidden flex items-center justify-center">
                            @if ($race->image)
                                <img src="{{ asset('storage/' . $race->image) }}" alt="{{ $race->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-600 to-red-800">
                                    <span class="text-white text-5xl font-bold opacity-20">🏁</span>
                                </div>
                            @endif
                        </div>

                        <!-- Race Info Section -->
                        <div class="p-6 relative z-10">
                            <!-- Race Name -->
                            <h3 class="text-2xl font-bold text-white mb-2 truncate">
                                <a href="{{ route('races.show', $race->id) }}" class="hover:text-red-500 transition">
                                    {{ $race->name }}
                                </a>
                            </h3>

                            <!-- Race Details -->
                            <div class="space-y-3 text-sm text-gray-300 mb-6">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">📅 Date:</span>
                                    <span class="font-bold text-white">
                                        {{ $race->date ? \Carbon\Carbon::parse($race->date)->format('d M Y') : 'TBA' }}
                                    </span>
                                </div>
                                
                                @if ($race->location)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">📍 Location:</span>
                                    <span class="font-bold text-white">{{ $race->location }}</span>
                                </div>
                                @endif

                                @if ($race->laps)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">🔄 Laps:</span>
                                    <span class="font-bold text-white">{{ $race->laps }}</span>
                                </div>
                                @endif

                                @if ($race->distance)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">📏 Distance:</span>
                                    <span class="font-bold text-white">{{ number_format($race->distance, 2) }} km</span>
                                </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="pt-6 border-t border-gray-700 space-y-2">
                                <a href="{{ route('races.show', $race->id) }}" class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-semibold py-2 rounded-lg transition duration-300 text-sm">
                                    View Details
                                </a>
                                
                                
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-400 text-lg">No races found. <a href="{{ route('admin.index') }}" class="text-red-500 hover:text-red-400">Add one now</a></p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</body>
</html>
@include('footer')