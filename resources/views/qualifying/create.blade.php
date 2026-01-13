<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Qualifying</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <style> .drag-handle { cursor: move; } </style>
</head>
<body class="bg-gray-50">
    @include('header')

    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('races.show', $raceId) }}" class="inline-block text-red-500 hover:text-red-400 font-semibold mb-8">← Back</a>

            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-3xl text-white font-bold mb-6">Manage Qualifying Results</h1>

                <form action="{{ route('qualifying.store', $raceId) }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="text-white block mb-2">Event name (optional)</label>
                        <input type="text" name="name" value="{{ $qualifying->name ?? 'Qualifying' }}" class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600">
                    </div>

                    <p class="text-gray-300 mb-4">Drag drivers to order them, or select placement/time manually.</p>

                    <div class="overflow-x-auto mb-6">
                        <table class="w-full text-white">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-4 py-3">↕</th>
                                    <th class="px-4 py-3">Driver</th>
                                    <th class="px-4 py-3">Team</th>
                                    <th class="px-4 py-3">Placement</th>
                                    <th class="px-4 py-3">Time</th>
                                </tr>
                            </thead>
                            <tbody id="qualifyingBody">
                                @foreach ($drivers as $index => $driver)
                                @php
                                    $placement = $results->has($driver->id) ? $results->get($driver->id) : '';
                                @endphp
                                <tr class="border-b border-gray-700 draggable-qual-row" data-driver-id="{{ $driver->id }}">
                                    <td class="px-4 py-3 drag-handle">⋮⋮</td>
                                    <td class="px-4 py-3">{{ $driver->Fname }} {{ $driver->Lname }} (#{{ $driver->number }})</td>
                                    <td class="px-4 py-3">{{ $driver->team ? $driver->team->name : '-' }}</td>
                                    <td class="px-4 py-3">
                                        <input type="hidden" name="results[{{ $index }}][driver_id]" value="{{ $driver->id }}">
                                        <input type="number" name="results[{{ $index }}][placement]" min="1" max="99" value="{{ $placement }}" class="w-24 px-2 py-1 rounded bg-gray-700 text-white border border-gray-600">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="results[{{ $index }}][time]" value="" placeholder="1:23.456" class="w-40 px-2 py-1 rounded bg-gray-700 text-white border border-gray-600">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded">Save Qualifying</button>
                        <a href="{{ route('races.show', $raceId) }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded text-center">Cancel</a>
                    </div>
                </form>

                @if ($qualifying)
                <form action="{{ route('qualifying.destroy', $raceId) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-900 hover:bg-red-950 text-white py-2 px-4 rounded" onclick="return confirm('Delete qualifying results?')">Delete Qualifying Results</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Make the qualifying rows draggable to reorder
        Sortable.create(document.getElementById('qualifyingBody'), {
            handle: '.drag-handle',
            animation: 150,
        });
    </script>

</body>
</html>
