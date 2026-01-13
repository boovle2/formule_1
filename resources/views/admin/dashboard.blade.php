<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')

    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-6">Admin Dashboard</h1>

                @if(session('success'))
                    <div class="mb-4 px-4 py-3 bg-green-800 text-green-200 rounded">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-4 px-4 py-3 bg-red-800 text-red-200 rounded">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Quick Links -->
                <div class="mb-8 bg-gray-900 rounded p-4">
                    <h3 class="text-white font-bold mb-3">Management</h3>
                    <div class="flex gap-3 flex-wrap">
                        <a href="{{ route('standings.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-white font-semibold">📊 Enter Results</a>
                        <a href="{{ route('standings.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded text-white">View Standings</a>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="mb-6 flex border-b border-gray-700 gap-4 flex-wrap">
                    <button onclick="showTab('races')" class="tab-btn text-white px-4 py-2 border-b-2 border-red-600 font-semibold active">🏁 Races</button>
                    <button onclick="showTab('drivers')" class="tab-btn text-gray-400 px-4 py-2 border-b-2 border-transparent hover:text-white">👤 Drivers</button>
                    <button onclick="showTab('teams')" class="tab-btn text-gray-400 px-4 py-2 border-b-2 border-transparent hover:text-white">🏢 Teams</button>
                    <button onclick="showTab('sprint')" class="tab-btn text-gray-400 px-4 py-2 border-b-2 border-transparent hover:text-white">⚡ Sprint Races</button>
                </div>

                <!-- Races Tab -->
                <div id="races-tab" class="tab-content grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Create Race -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Create Race</h2>
                        <form action="{{ route('admin.race.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input name="name" placeholder="Race Name" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" required />
                            <input name="date" type="date" class="w-full px-3 py-2 rounded bg-gray-600 text-white" />
                            <input name="location" placeholder="Location" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <input name="laps" type="number" placeholder="Laps" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <input name="distance" type="number" step="0.01" placeholder="Distance (km)" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <input name="image" type="file" class="w-full text-gray-300 px-3 py-2" />
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Create Race</button>
                        </form>
                    </div>

                    <!-- Races List -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Races</h2>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @forelse($races as $race)
                                <div class="bg-gray-600 p-3 rounded flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">{{ $race->name }}</p>
                                        <p class="text-gray-300 text-sm">{{ $race->date ? \Carbon\Carbon::parse($race->date)->format('d M Y') : 'TBA' }} • {{ $race->location }}</p>
                                    </div>
                                    <div class="flex gap-2 ml-2">
                                        <form action="{{ route('admin.race.delete', $race->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm" onclick="return confirm('Delete this race?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400">No races yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Drivers Tab -->
                <div id="drivers-tab" class="tab-content hidden grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Create Driver -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Create Driver</h2>
                        <form action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input name="Fname" placeholder="First Name" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" required />
                            <input name="Lname" placeholder="Last Name" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" required />
                            <input name="number" type="number" placeholder="Number" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <select name="team_id" class="w-full px-3 py-2 rounded bg-gray-600 text-white">
                                <option value="">-- No Team --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <input name="image" type="file" class="w-full text-gray-300 px-3 py-2" />
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Create Driver</button>
                        </form>
                    </div>

                    <!-- Drivers List -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Drivers</h2>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @forelse($drivers as $driver)
                                <div class="bg-gray-600 p-3 rounded flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">{{ $driver->Fname }} {{ $driver->Lname }} #{{ $driver->number }}</p>
                                        <p class="text-gray-300 text-sm">{{ $driver->team ? $driver->team->name : 'No Team' }} • {{ $driver->points }} pts</p>
                                    </div>
                                    <div class="flex gap-2 ml-2">
                                        <form action="{{ route('admin.driver.delete', $driver->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm" onclick="return confirm('Delete this driver?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400">No drivers yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Teams Tab -->
                <div id="teams-tab" class="tab-content hidden grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Create Team -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Create Team</h2>
                        <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input name="name" placeholder="Team Name" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" required />
                            <input name="team_principal" placeholder="Team Principal" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <input name="championships" type="number" placeholder="Championships" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <input name="logo" type="file" class="w-full text-gray-300 px-3 py-2" />
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Create Team</button>
                        </form>
                    </div>

                    <!-- Teams List -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Teams</h2>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @forelse($teams as $team)
                                <div class="bg-gray-600 p-3 rounded flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">{{ $team->name }}</p>
                                        <p class="text-gray-300 text-sm">{{ $team->team_principal ?? 'N/A' }} • {{ $team->points }} pts</p>
                                    </div>
                                    <div class="flex gap-2 ml-2">
                                        <form action="{{ route('admin.team.delete', $team->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm" onclick="return confirm('Delete this team?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400">No teams yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sprint Races Tab -->
                <div id="sprint-tab" class="tab-content hidden grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Create Sprint Race -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Create Sprint Race</h2>
                        <form action="{{ route('admin.sprint.store') }}" method="POST" class="space-y-3">
                            @csrf
                            <select name="race_id" class="w-full px-3 py-2 rounded bg-gray-600 text-white" required>
                                <option value="">-- Select Main Race --</option>
                                @foreach($races as $race)
                                    <option value="{{ $race->id }}">{{ $race->name }} ({{ $race->date ? \Carbon\Carbon::parse($race->date)->format('d M Y') : 'TBA' }})</option>
                                @endforeach
                            </select>
                            <input name="name" placeholder="Sprint Race Name" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" required />
                            <input name="date" type="date" class="w-full px-3 py-2 rounded bg-gray-600 text-white" />
                            <input name="location" placeholder="Location" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <input name="laps" type="number" placeholder="Laps" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <input name="distance" type="number" step="0.01" placeholder="Distance (km)" class="w-full px-3 py-2 rounded bg-gray-600 text-white placeholder-gray-400" />
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Create Sprint Race</button>
                        </form>
                    </div>

                    <!-- Sprint Races List -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Sprint Races</h2>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @forelse($sprintRaces as $sprint)
                                <div class="bg-gray-600 p-3 rounded flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">{{ $sprint->name }}</p>
                                        <p class="text-gray-300 text-sm">Race: {{ $sprint->race->name }} • {{ $sprint->date ? \Carbon\Carbon::parse($sprint->date)->format('d M Y') : 'TBA' }}</p>
                                    </div>
                                    <div class="flex gap-2 ml-2">
                                        <form action="{{ route('admin.sprint.delete', $sprint->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm" onclick="return confirm('Delete this sprint race?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400">No sprint races yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

    <script>
        function showTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(tab + '-tab').classList.remove('hidden');
            
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('border-red-600', 'text-white');
                el.classList.add('border-transparent', 'text-gray-400');
            });
            event.target.classList.add('border-red-600', 'text-white');
            event.target.classList.remove('border-transparent', 'text-gray-400');
        }
    </script>

</body>
</html>
@include('footer')
