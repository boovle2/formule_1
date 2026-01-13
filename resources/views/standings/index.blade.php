<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standings</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Championship Standings</h1>
                <p class="text-gray-300 text-lg">2025 Formula 1 Season</p>
            </div>


            <!-- Tabs -->
            <div class="flex gap-4 mb-8 border-b border-gray-700">
                <button onclick="showTab('drivers')" id="driversTab" class="px-6 py-3 text-white font-bold border-b-2 border-red-600">
                    Driver Standings
                </button>
                <button onclick="showTab('teams')" id="teamsTab" class="px-6 py-3 text-gray-400 font-bold border-b-2 border-transparent hover:border-gray-600">
                    Team Standings
                </button>
            </div>

            <!-- Driver Standings -->
            <div id="drivers" class="tab-content">
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg">
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
                            @forelse ($driverStandings as $index => $driver)
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 font-bold">
                                        @if ($index == 0)
                                            <span class="text-yellow-500 text-2xl">🥇</span>
                                        @elseif ($index == 1)
                                            <span class="text-gray-300 text-2xl">🥈</span>
                                        @elseif ($index == 2)
                                            <span class="text-orange-500 text-2xl">🥉</span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('drivers.show', $driver->id) }}" class="hover:text-red-500 transition">
                                            {{ $driver->Fname }} {{ $driver->Lname }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($driver->team)
                                            <a href="{{ route('teams.show', $driver->team->id) }}" class="text-red-400 hover:text-red-300">
                                                {{ $driver->team->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-2xl">{{ $driver->total_points }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">No standings data yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Team Standings -->
            <div id="teams" class="tab-content hidden">
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg">
                    <table class="w-full text-white">
                        <thead class="bg-gray-900 border-b border-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left">Position</th>
                                <th class="px-6 py-4 text-left">Team</th>
                                <th class="px-6 py-4 text-left">Principal</th>
                                <th class="px-6 py-4 text-right">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teamStandings as $index => $team)
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 font-bold">
                                        @if ($index == 0)
                                            <span class="text-yellow-500 text-2xl">🥇</span>
                                        @elseif ($index == 1)
                                            <span class="text-gray-300 text-2xl">🥈</span>
                                        @elseif ($index == 2)
                                            <span class="text-orange-500 text-2xl">🥉</span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('teams.show', $team->id) }}" class="hover:text-red-500 transition">
                                            {{ $team->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">{{ $team->team_principal ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-2xl">{{ $team->total_points }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">No standings data yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Points Table Info -->
            <div class="mt-12 bg-gray-800 rounded-xl p-8">
                <h3 class="text-2xl font-bold text-white mb-6">F1 Points System</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-gray-700 rounded p-4 text-center">
                        <p class="text-gray-400 text-sm">1st</p>
                        <p class="text-3xl font-bold text-white">25</p>
                    </div>
                    <div class="bg-gray-700 rounded p-4 text-center">
                        <p class="text-gray-400 text-sm">2nd</p>
                        <p class="text-3xl font-bold text-white">18</p>
                    </div>
                    <div class="bg-gray-700 rounded p-4 text-center">
                        <p class="text-gray-400 text-sm">3rd</p>
                        <p class="text-3xl font-bold text-white">15</p>
                    </div>
                    <div class="bg-gray-700 rounded p-4 text-center">
                        <p class="text-gray-400 text-sm">4th</p>
                        <p class="text-3xl font-bold text-white">12</p>
                    </div>
                    <div class="bg-gray-700 rounded p-4 text-center">
                        <p class="text-gray-400 text-sm">5th</p>
                        <p class="text-3xl font-bold text-white">10</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Show selected tab
            document.getElementById(tabName).classList.remove('hidden');

            // Update button styles
            document.querySelectorAll('[id$="Tab"]').forEach(btn => {
                btn.classList.remove('border-b-2', 'border-red-600');
                btn.classList.add('border-transparent', 'hover:border-gray-600');
                btn.classList.remove('text-white');
                btn.classList.add('text-gray-400');
            });

            document.getElementById(tabName + 'Tab').classList.add('border-b-2', 'border-red-600', 'text-white');
            document.getElementById(tabName + 'Tab').classList.remove('border-transparent', 'hover:border-gray-600', 'text-gray-400');
        }
    </script>

</body>
</html>
@include('footer')
