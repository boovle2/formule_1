<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Results</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-2">Enter Results</h1>
                <p class="text-gray-300 mb-6">Race • Sprint • Qualifying</p>

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

                <!-- Tabs -->
                <div class="mb-6 flex border-b border-gray-700 gap-4 flex-wrap">
                    <button type="button" onclick="showResultsTab('session')" class="tab-btn text-white px-4 py-2 border-b-2 border-red-600 font-semibold active">🏁 Race & Sprint</button>
                    <button type="button" onclick="showResultsTab('qualifying')" class="tab-btn text-gray-400 px-4 py-2 border-b-2 border-transparent hover:text-white">🎯 Qualifying</button>
                </div>

                <!-- Race/Sprint Tab -->
                <div id="session-tab" class="tab-content">
                    <form action="{{ route('standings.store') }}" method="POST" id="resultsForm">
                        @csrf

                        <!-- Session Type -->
                        <div class="mb-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div>
                            <label for="session_type" class="block text-white font-semibold mb-2">Session Type *</label>
                            <select name="session_type" id="session_type" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600">
                                <option value="race">🏁 Main Race</option>
                                <option value="sprint">⚡ Sprint Race</option>
                            </select>
                        </div>

                        <div>
                            <label for="race_id" class="block text-white font-semibold mb-2">Select Main Race *</label>
                            <select name="race_id" id="race_id" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600">
                                <option value="">Choose a race...</option>
                                @foreach ($races as $race)
                                    <option value="{{ $race->id }}">
                                        {{ $race->name }} - {{ $race->date ? \Carbon\Carbon::parse($race->date)->format('d M Y') : 'TBA' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="sprint_select_div" class="hidden">
                            <label for="session_id" class="block text-white font-semibold mb-2">Select Sprint Race *</label>
                            <select name="session_id" id="session_id"
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600">
                                <option value="">Choose a sprint...</option>
                                @foreach ($sprintRaces as $sprint)
                                    <option value="{{ $sprint->id }}">
                                        {{ $sprint->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Hidden session_id for main races -->
                        <input type="hidden" id="session_id_hidden" name="session_id" value="" />
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
                                            <span class="points-value">-</span>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
                            Save Results
                        </button>
                        <a href="{{ route('standings.index') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
                            Cancel
                        </a>
                    </div>
                    </form>
                </div>

                <!-- Qualifying Tab -->
                <div id="qualifying-tab" class="tab-content hidden">
                    <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-white mb-4">🎯 Qualifying Results</h2>
                        <input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
                        <div class="mb-6">
                            <label for="qual_race_id" class="block text-white font-semibold mb-2">Select Race *</label>
                            <select id="qual_race_id" class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600">
                                <option value="">Choose a race...</option>
                                @foreach ($races as $race)
                                    <option value="{{ $race->id }}">
                                        {{ $race->name }} - {{ $race->date ? \Carbon\Carbon::parse($race->date)->format('d M Y') : 'TBA' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-8 overflow-x-auto">
                            <h3 class="text-xl font-bold text-white mb-4">Qualifying Order <span class="text-sm text-gray-400">(Drag rows to reorder)</span></h3>
                            <table class="w-full text-white">
                                <thead class="bg-gray-900">
                                    <tr>
                                        <th class="px-4 py-3 text-left w-12">↕️</th>
                                        <th class="px-4 py-3 text-left">Position</th>
                                        <th class="px-4 py-3 text-left">Driver</th>
                                        <th class="px-4 py-3 text-left">Team</th>
                                    </tr>
                                </thead>
                                <tbody id="qualifyingTableBody" class="sortable-list-qual">
                                    @for ($i = 1; $i <= 20; $i++)
                                        <tr class="border-b border-gray-700 hover:bg-gray-700 transition cursor-move draggable-row-qual" draggable="true" data-index="{{ $i-1 }}">
                                            <td class="px-4 py-3 text-gray-400 text-center select-none">⋮⋮</td>
                                            <td class="px-4 py-3 text-gray-400 row-position-qual">{{ $i }}</td>
                                            <td class="px-4 py-3">
                                                <select class="driver-select-qual w-full px-3 py-2 bg-gray-600 text-white rounded border border-gray-500">
                                                    <option value="">Select driver...</option>
                                                    @foreach ($drivers as $d)
                                                        <option value="{{ $d->id }}" data-team="{{ $d->team ? $d->team->name : '' }}">
                                                            {{ $d->Fname }} {{ $d->Lname }} (#{{ $d->number }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-3 text-gray-400">
                                                <div class="team-display-qual w-full px-3 py-2 bg-gray-600 text-gray-300 rounded border border-gray-500">-</div>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <button type="button" onclick="saveQualifyingResults()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
                                Save Qualifying Results
                            </button>
                            <a href="{{ route('standings.index') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Tab switching
        function showResultsTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(tab + '-tab').classList.remove('hidden');
            
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('border-red-600', 'text-white');
                el.classList.add('border-transparent', 'text-gray-400');
            });
            event.target.classList.add('border-red-600', 'text-white');
            event.target.classList.remove('border-transparent', 'text-gray-400');
        }

        // Qualifying Results
        let qualSortable = null;

        function initQualifyingSortable() {
            if (qualSortable) qualSortable.destroy();
            qualSortable = Sortable.create(document.getElementById('qualifyingTableBody'), {
                animation: 150,
                ghostClass: 'opacity-50',
                onEnd: updateQualifyingPositions
            });
        }

        function updateQualifyingPositions() {
            const rows = document.querySelectorAll('.draggable-row-qual');
            rows.forEach((row, index) => {
                const position = index + 1;
                row.querySelector('.row-position-qual').textContent = position;
            });
        }

        function updateTeamDisplayQual(select) {
            const selectedOption = select.options[select.selectedIndex];
            const teamName = selectedOption ? (selectedOption.getAttribute('data-team') || '-') : '-';
            const teamDisplay = select.closest('tr').querySelector('.team-display-qual');
            if (teamDisplay) teamDisplay.textContent = teamName;
        }

        document.querySelectorAll('select.driver-select-qual').forEach((select) => {
            select.addEventListener('change', function() {
                updateTeamDisplayQual(this);
            });
        });

        async function saveQualifyingResults() {
            const raceId = document.getElementById('qual_race_id').value;
            if (!raceId) {
                alert('Please select a race first');
                return;
            }

            const rows = document.querySelectorAll('.draggable-row-qual');
            const results = [];
            rows.forEach((row, index) => {
                const driverSelect = row.querySelector('.driver-select-qual');
                const driverId = driverSelect.value;
                if (driverId) {
                    results.push({
                        position: index + 1,
                        driver_id: driverId
                    });
                }
            });

            if (results.length === 0) {
                alert('Please select at least one driver');
                return;
            }

            try {
                const csrfToken = document.getElementById('csrf_token').value;
                const url = `/admin/qualifying/${raceId}/results`;
                console.log('Sending to:', url);
                console.log('Data:', { results });
                console.log('CSRF Token:', csrfToken);
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ results })
                });

                console.log('Response status:', response.status);
                console.log('Response headers:', {
                    'content-type': response.headers.get('content-type')
                });
                
                const responseText = await response.text();
                console.log('Raw response (first 500 chars):', responseText.substring(0, 500));

                let responseData;
                try {
                    responseData = JSON.parse(responseText);
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                    console.error('Response was:', responseText.substring(0, 1000));
                    throw new Error('Invalid response from server (not JSON)');
                }

                if (!response.ok) {
                    console.error('Response error:', responseData);
                    throw new Error(responseData.message || `Server error: ${response.status}`);
                }

                alert('Qualifying results saved!');
                showResultsTab('session');
            } catch (error) {
                console.error('Error:', error);
                alert('Error saving qualifying results: ' + error.message);
            }
        }

        document.getElementById('qual_race_id').addEventListener('change', async function() {
            const raceId = this.value;
            if (!raceId) return;

            try {
                const res = await fetch(`/races/${raceId}/qualifying-results`);
                if (!res.ok) return;
                const data = await res.json();
                const driverIds = data.drivers || [];

                const rows = document.querySelectorAll('.draggable-row-qual');
                driverIds.forEach((driverId, idx) => {
                    if (idx >= rows.length) return;
                    const row = rows[idx];
                    const select = row.querySelector('.driver-select-qual');
                    if (!select) return;
                    const option = select.querySelector(`option[value="${driverId}"]`);
                    if (option) {
                        select.value = driverId;
                        updateTeamDisplayQual(select);
                    }
                });
                updateQualifyingPositions();
            } catch (e) {
                console.error('Failed to fetch qualifying results', e);
            }
        });

        // Initialize when DOM is ready
        window.addEventListener('DOMContentLoaded', () => {
            initQualifyingSortable();
        });

        const racePointsTable = [25, 18, 15, 12, 10, 8, 6, 4, 2, 1];
        const sprintPointsTable = [8, 7, 6, 5, 4, 3, 2, 1];

        function getPointsTable() {
            const sessionType = document.getElementById('session_type').value;
            return sessionType === 'sprint' ? sprintPointsTable : racePointsTable;
        }

        // Show/hide sprint selector
        document.getElementById('session_type').addEventListener('change', function() {
            const sprintDiv = document.getElementById('sprint_select_div');
            const sessionIdSelect = document.getElementById('session_id');
            const sessionIdHidden = document.getElementById('session_id_hidden');
            
            if (this.value === 'sprint') {
                sprintDiv.classList.remove('hidden');
                sessionIdHidden.disabled = true;
                sessionIdSelect.disabled = false;
            } else {
                sprintDiv.classList.add('hidden');
                sessionIdSelect.disabled = true;
                sessionIdHidden.disabled = false;
                // Auto-fill session_id with race_id for main race
                const raceId = document.getElementById('race_id').value;
                sessionIdHidden.value = raceId;
            }
            updatePositions();
        });

        // Update hidden session_id when race changes
        document.getElementById('race_id').addEventListener('change', function() {
            const sessionType = document.getElementById('session_type').value;
            if (sessionType === 'race') {
                document.getElementById('session_id_hidden').value = this.value;
            }
        });

        // helper: update team display for a select element
        function updateTeamDisplay(select) {
            const selectedOption = select.options[select.selectedIndex];
            const teamName = selectedOption ? (selectedOption.getAttribute('data-team') || '-') : '-';
            const teamDisplay = select.closest('tr').querySelector('.team-display');
            if (teamDisplay) teamDisplay.textContent = teamName;
        }

        // initialize team display on change
        document.querySelectorAll('select.driver-select').forEach((select) => {
            select.addEventListener('change', function() {
                updateTeamDisplay(this);
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
            const pointsTable = getPointsTable();
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

        // Prefill table from qualifying results for selected race
        async function prefillFromQualifying(raceId) {
            if (!raceId) return;
            try {
                const res = await fetch(`/races/${raceId}/qualifying-results`);
                if (!res.ok) return;
                const data = await res.json();
                const driverIds = data.drivers || [];

                // For each row, set the driver select to the qualifying order if available
                const rows = document.querySelectorAll('.draggable-row');
                driverIds.forEach((driverId, idx) => {
                    if (idx >= rows.length) return;
                    const row = rows[idx];
                    const select = row.querySelector('.driver-select');
                    if (!select) return;
                    const option = select.querySelector(`option[value="${driverId}"]`);
                    if (option) {
                        select.value = driverId;
                        updateTeamDisplay(select);
                    }
                });
                updatePositions();
            } catch (e) {
                console.error('Failed to fetch qualifying results', e);
            }
        }

        // When race selection changes, prefill from qualifying
        document.getElementById('race_id').addEventListener('change', function() {
            const raceId = this.value;
            const sessionId = document.querySelector('input[name="session_id"][type="hidden"]');
            sessionId.value = raceId; // auto-fill session_id for main race
            prefillFromQualifying(raceId);
        });

        // Initial setup
        updatePositions();
    </script>

</body>
</html>
@include('footer')