<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Race Results</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-2">Edit Race Results</h1>
                <p class="text-gray-400 text-lg mb-8">{{ $race->name }}</p>

                <form action="{{ route('standings.update', $race->id) }}" method="POST" id="resultsForm">
                    @csrf
                    @method('PUT')

                    <!-- Results Table -->
                    <div class="mb-8 overflow-x-auto">
                        <table class="w-full text-white">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-4 py-3 text-left">Position</th>
                                    <th class="px-4 py-3 text-left">Driver</th>
                                    <th class="px-4 py-3 text-left">Team</th>
                                    <th class="px-4 py-3 text-center">Placement</th>
                                    <th class="px-4 py-3 text-right">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 20; $i++)
                                    @php
                                        $result = $results->values()->get($i-1);
                                    @endphp
                                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                                        <td class="px-4 py-3 text-gray-400">{{ $i }}</td>
                                        <td class="px-4 py-3">
                                            <select name="results[{{ $i-1 }}][driver_id]" class="w-full px-3 py-2 bg-gray-600 text-white rounded border border-gray-500">
                                                <option value="">Select driver...</option>
                                                @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->id }}" {{ $result && $result->driver_id == $driver->id ? 'selected' : '' }}>
                                                        {{ $driver->Fname }} {{ $driver->Lname }} (#{{ $driver->number }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-4 py-3 text-gray-400">
                                            <select class="w-full px-3 py-2 bg-gray-600 text-white rounded border border-gray-500" disabled>
                                                <option value="">-</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-3 text-center font-semibold">{{ $i }}</td>
                                        <td class="px-4 py-3 text-right font-bold text-red-500">
                                            <input type="hidden" name="results[{{ $i-1 }}][placement]" value="{{ $i }}">
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
                            Update Results
                        </button>
                        <a href="{{ route('standings.show', $race->id) }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
@include('footer')
