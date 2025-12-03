<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Race Results</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-8">Enter Race Results</h1>

                @if ($errors->any())
                    <div class="mb-6 bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded-lg">
                        <h4 class="font-bold mb-2">Please fix the following errors:</h4>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('standings.store') }}" method="POST" id="resultsForm">
                    @csrf

                    <!-- Select Race -->
                    <div class="mb-8">
                        <label for="race_id" class="block text-white font-semibold mb-2">Select Race *</label>
                        <select name="race_id" id="race_id" required
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                            <option value="">Choose a race...</option>
                            @foreach ($races as $race)
                                <option value="{{ $race->id }}">
                                    {{ $race->name }} - {{ $race->date ? \Carbon\Carbon::parse($race->date)->format('d M Y') : 'TBA' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Results Table -->
                    <div class="mb-8 overflow-x-auto">
                        <h3 class="text-2xl font-bold text-white mb-4">Driver Results <span class="text-sm text-gray-400">(Drag rows to reorder)</span></h3>
                        <table class="w-full text-white">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-4 py-3 text-left w-12">↕️</th>
                                    <th class="px-4 py-3 text-left">Position</th>
                                    <th class="px-4 py-3 text-left">Driver</th>
                                    <th class="px-4 py-3 text-left">Team</th>
                                    <th class="px-4 py-3 text-center">Placement</th>
                                    <th class="px-4 py-3 text-right">Points</th>
                                </tr>
                            </thead>
                            <tbody id="resultsTableBody" class="sortable-list">
                                @php
                                    $shuffledDrivers = $drivers->shuffle();
                                @endphp
                                @for ($i = 1; $i <= 20; $i++)
                                    @php
                                        $driver = $shuffledDrivers->get($i - 1);
                                        $driverId = $driver ? $driver->id : '';
                                        $driverName = $driver ? $driver->Fname . ' ' . $driver->Lname . ' (#' . $driver->number . ')' : '';
                                        $teamName = $driver && $driver->team ? $driver->team->name : '-';
                                    @endphp
                                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition cursor-move draggable-row" draggable="true" data-index="{{ $i-1 }}">
                                        <td class="px-4 py-3 text-gray-400 text-center select-none">⋮⋮</td>
                                        <td class="px-4 py-3 text-gray-400 row-position">{{ $i }}</td>
                                        <td class="px-4 py-3">
                                            <select name="results[{{ $i-1 }}][driver_id]" class="driver-select w-full px-3 py-2 bg-gray-600 text-white rounded border border-gray-500">
                                                <option value="">Select driver...</option>
                                                @foreach ($drivers as $d)
                                                    <option value="{{ $d->id }}" data-team="{{ $d->team ? $d->team->name : '' }}" {{ $d->id == $driverId ? 'selected' : '' }}>
                                                        {{ $d->Fname }} {{ $d->Lname }} (#{{ $d->number }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-4 py-3 text-gray-400">
                                            <div class="team-display w-full px-3 py-2 bg-gray-600 text-gray-300 rounded border border-gray-500">{{ $teamName }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center font-semibold">
                                            <input type="hidden" name="results[{{ $i-1 }}][placement]" value="{{ $i }}" class="placement-value">
                                            {{ $i }}
                                        </td>
                                        <td class="px-4 py-3 text-right font-bold text-red-500">
                                            <span class="points-value">{{ [25, 18, 15, 12, 10, 8, 6, 4, 2, 1][$i-1] ?? 0 }}</span>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
                            Save Race Results
                        </button>
                        <a href="{{ route('standings.index') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const pointsTable = [25, 18, 15, 12, 10, 8, 6, 4, 2, 1];
        
        // Initialize team display on driver select
        document.querySelectorAll('select.driver-select').forEach((select) => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const teamName = selectedOption.getAttribute('data-team') || '-';
                const teamDisplay = this.closest('tr').querySelector('.team-display');
                teamDisplay.textContent = teamName;
            });
        });

        // Initialize SortableJS for drag-and-drop
        const sortable = Sortable.create(document.getElementById('resultsTableBody'), {
            animation: 150,
            ghostClass: 'opacity-50',
            onEnd: function(evt) {
                updatePositions();
            }
        });

        // Update positions and input values after drag
        function updatePositions() {
            const rows = document.querySelectorAll('.draggable-row');
            rows.forEach((row, index) => {
                const position = index + 1;
                row.setAttribute('data-index', index);
                row.querySelector('.row-position').textContent = position;
                row.querySelector('.placement-value').value = position;
                
                // Update name attributes for form submission
                const driverSelect = row.querySelector('.driver-select');
                driverSelect.setAttribute('name', `results[${index}][driver_id]`);
                
                // Update points display
                const pointsValue = row.querySelector('.points-value');
                pointsValue.textContent = pointsTable[index] || 0;
                
                // Update background color for top 3
                row.classList.remove('bg-yellow-900', 'bg-gray-700', 'bg-orange-900');
                if (position === 1) row.classList.add('bg-yellow-900');
                else if (position === 2) row.classList.add('bg-gray-700');
                else if (position === 3) row.classList.add('bg-orange-900');
            });
        }
    </script>
    </script>

</body>
</html>
@include('footer')
