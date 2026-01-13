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

                    <!-- Race results -->
                    @if (isset($raceResults) && $raceResults->count() > 0)
                    <div class="mb-8 pb-8 border-b border-gray-700">
                        <h3 class="text-white font-bold text-xl mb-4">Race Results</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-white">
                                <thead class="bg-gray-900 border-b border-gray-700">
                                    <tr>
                                        <th class="px-6 py-4 text-left">Position</th>
                                        <th class="px-6 py-4 text-left">Driver</th>
                                        <th class="px-6 py-4 text-left">Team</th>
                                        <th class="px-6 py-4 text-right">Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($raceResults as $result)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                        <td class="px-6 py-4 font-bold">
                                            @if ($result->placement == 1)
                                            <span class="text-yellow-500 text-2xl">🥇</span> 1st
                                            @elseif ($result->placement == 2)
                                            <span class="text-gray-300 text-2xl">🥈</span> 2nd
                                            @elseif ($result->placement == 3)
                                            <span class="text-orange-500 text-2xl">🥉</span> 3rd
                                            @else
                                            {{ $result->placement }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($result->driver)
                                            <a href="{{ route('drivers.show', $result->driver->id) }}" class="hover:text-red-500 transition">
                                                {{ $result->driver->Fname }} {{ $result->driver->Lname }}
                                            </a>
                                            @else
                                            <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($result->driver && $result->driver->team)
                                            <a href="{{ route('teams.show', $result->driver->team->id) }}" class="text-red-400 hover:text-red-300">
                                                {{ $result->driver->team->name }}
                                            </a>
                                            @else
                                            <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-2xl text-red-500">{{ $result->points }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Sprint race results (grouped by sprint session) -->
                    @if (isset($sprintResultsBySession) && $sprintResultsBySession->count() > 0)
                    <div class="mb-8 pb-8 border-b border-gray-700">
                        <h3 class="text-white font-bold text-xl mb-4">Sprint Race Results</h3>

                        @foreach ($sprintResultsBySession as $sessionId => $sessionResults)
                        @php $sprint = $sprint_races->firstWhere('id', $sessionId); @endphp
                        <div class="mb-6">
                            <h4 class="text-gray-200 font-semibold mb-2">{{ $sprint ? $sprint->name : 'Sprint' }}</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-white">
                                    <thead class="bg-gray-900 border-b border-gray-700">
                                        <tr>
                                            <th class="px-6 py-4 text-left">Position</th>
                                            <th class="px-6 py-4 text-left">Driver</th>
                                            <th class="px-6 py-4 text-left">Team</th>
                                            <th class="px-6 py-4 text-right">Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sessionResults as $result)
                                        <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                            <td class="px-6 py-4 font-bold">
                                                @if ($result->placement == 1)
                                                <span class="text-yellow-500 text-2xl">🥇</span> 1st
                                                @elseif ($result->placement == 2)
                                                <span class="text-gray-300 text-2xl">🥈</span> 2nd
                                                @elseif ($result->placement == 3)
                                                <span class="text-orange-500 text-2xl">🥉</span> 3rd
                                                @else
                                                {{ $result->placement }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($result->driver)
                                                <a href="{{ route('drivers.show', $result->driver->id) }}" class="hover:text-red-500 transition">
                                                    {{ $result->driver->Fname }} {{ $result->driver->Lname }}
                                                </a>
                                                @else
                                                <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($result->driver && $result->driver->team)
                                                <a href="{{ route('teams.show', $result->driver->team->id) }}" class="text-red-400 hover:text-red-300">
                                                    {{ $result->driver->team->name }}
                                                </a>
                                                @else
                                                <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-2xl text-red-500">{{ $result->points }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    @endif
                </div>
            </div>
        </div>

</body>

</html>
@include('footer')