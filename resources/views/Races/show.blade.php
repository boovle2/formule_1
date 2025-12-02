<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $race->name }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('races.index') }}" class="inline-block text-red-500 hover:text-red-400 font-semibold mb-8">
                ← Back to Races
            </a>

            <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
                <!-- Header with Image -->
                <div class="relative h-80 bg-gray-700 overflow-hidden">
                    @if ($race->image)
                        <img src="{{ asset('storage/' . $race->image) }}" alt="{{ $race->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-600 to-red-800">
                            <span class="text-white text-8xl font-bold opacity-20">🏁</span>
                        </div>
                    @endif
                </div>

                <!-- Race Info -->
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $race->name }}</h1>
                    <p class="text-gray-400 text-lg mb-8">Formula 1 Grand Prix</p>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gray-700 rounded-lg p-6">
                            <p class="text-gray-400 text-sm mb-2">📅 DATE</p>
                            <p class="text-2xl font-bold text-white">
                                {{ $race->date ? \Carbon\Carbon::parse($race->date)->format('d M') : 'TBA' }}
                            </p>
                            <p class="text-gray-500 text-sm">
                                {{ $race->date ? \Carbon\Carbon::parse($race->date)->format('Y') : '' }}
                            </p>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-6">
                            <p class="text-gray-400 text-sm mb-2">📍 LOCATION</p>
                            <p class="text-xl font-bold text-white">{{ $race->location ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-6">
                            <p class="text-gray-400 text-sm mb-2">🔄 LAPS</p>
                            <p class="text-2xl font-bold text-white">{{ $race->laps ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-6">
                            <p class="text-gray-400 text-sm mb-2">📏 DISTANCE</p>
                            <p class="text-2xl font-bold text-white">
                                {{ $race->distance ? number_format($race->distance, 2) . ' km' : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <!-- Sprint Races Section -->
                    @if ($sprint_races && count($sprint_races) > 0)
                    <div class="mb-8 pb-8 border-b border-gray-700">
                        <h3 class="text-white font-bold text-xl mb-4">Sprint Races</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($sprint_races as $sprint)
                            <div class="bg-gray-700 rounded-lg p-4">
                                <h4 class="text-white font-bold mb-2">{{ $sprint->name }}</h4>
                                <div class="space-y-1 text-sm text-gray-300">
                                    <p>📅 {{ $sprint->date ? \Carbon\Carbon::parse($sprint->date)->format('d M Y') : 'TBA' }}</p>
                                    <p>🔄 {{ $sprint->laps ?? 'N/A' }} laps</p>
                                    <p>📏 {{ $sprint->distance ? number_format($sprint->distance, 2) . ' km' : 'N/A' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    @if (Auth::check() && auth()->user()->role === 'admin')
                    <div class="border-t border-gray-700 pt-8 flex gap-4">
                        <a href="{{ route('races.edit', $race->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
                            Edit Race
                        </a>
                        <form action="{{ route('races.destroy', $race->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-900 hover:bg-red-950 text-white font-bold py-3 rounded-lg transition duration-300" onclick="return confirm('Are you sure you want to delete this race?')">
                                Delete Race
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>
</html>
@include('footer')