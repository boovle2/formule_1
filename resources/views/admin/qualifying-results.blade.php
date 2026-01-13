<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Qualifying Results</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <div class="mb-6">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $qualifying->name }}</h1>
                    <p class="text-gray-300">Race: {{ $qualifying->race->name }} • {{ $qualifying->date ? \Carbon\Carbon::parse($qualifying->date)->format('d M Y') : 'TBA' }}</p>
                </div>

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

                <form action="{{ route('admin.qualifying.results.store', $qualifying->id) }}" method="POST" id="qualifyingForm">
                    @csrf

                    <!-- Qualifying Grid -->
                    <div class="space-y-2 mb-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Qualifying Order (drag to reorder)</h2>
                        <div id="qualifyingList" class="space-y-2">
                            @forelse($results as $index => $result)
                                <div class="draggable-row bg-gray-700 p-4 rounded-lg flex items-center gap-4 cursor-move hover:bg-gray-600 transition" draggable="true">
                                    <div class="flex-shrink-0 text-white font-bold text-2xl w-12 text-center position-display">
                                        {{ $index + 1 }}
                                    </div>
                                    <select name="results[{{ $index }}][driver_id]" class="driver-select flex-1 px-4 py-2 bg-gray-600 text-white border border-gray-500 rounded-lg focus:outline-none focus:border-red-600">
                                        <option value="">-- Select Driver --</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}" {{ $result->driver_id == $driver->id ? 'selected' : '' }}>
                                                #{{ $driver->number }} - {{ $driver->Fname }} {{ $driver->Lname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="results[{{ $index }}][position]" class="position-input" value="{{ $index + 1 }}" />
                                </div>
                            @empty
                                @for ($i = 0; $i < 20; $i++)
                                    <div class="draggable-row bg-gray-700 p-4 rounded-lg flex items-center gap-4 cursor-move hover:bg-gray-600 transition" draggable="true">
                                        <div class="flex-shrink-0 text-white font-bold text-2xl w-12 text-center position-display">
                                            {{ $i + 1 }}
                                        </div>
                                        <select name="results[{{ $i }}][driver_id]" class="driver-select flex-1 px-4 py-2 bg-gray-600 text-white border border-gray-500 rounded-lg focus:outline-none focus:border-red-600">
                                            <option value="">-- Select Driver --</option>
                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}">
                                                    #{{ $driver->number }} - {{ $driver->Fname }} {{ $driver->Lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="results[{{ $i }}][position]" class="position-input" value="{{ $i + 1 }}" />
                                    </div>
                                @endfor
                            @endforelse
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                            Save Qualifying Results
                        </button>
                        <a href="{{ route('admin.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition text-center">
                            Back to Admin
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const list = document.getElementById('qualifyingList');
        
        // Sortable setup
        Sortable.create(list, {
            animation: 150,
            ghostClass: 'bg-red-600',
            onEnd: updatePositions
        });

        function updatePositions() {
            const rows = document.querySelectorAll('.draggable-row');
            rows.forEach((row, index) => {
                const positionDisplay = row.querySelector('.position-display');
                const positionInput = row.querySelector('.position-input');
                positionDisplay.textContent = index + 1;
                positionInput.value = index + 1;
            });
        }

        updatePositions();
    </script>

</body>
</html>
@include('footer')
