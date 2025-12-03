<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race Results - {{ $race->name }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('standings.index') }}" class="inline-block text-red-500 hover:text-red-400 font-semibold mb-8">
                ← Back to Standings
            </a>

            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-2">{{ $race->name }}</h1>
                <p class="text-gray-400 text-lg mb-8">
                    {{ $race->date ? \Carbon\Carbon::parse($race->date)->format('d F Y') : 'Date TBA' }}
                </p>

                @if ($results->count() > 0)
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
                                @forelse ($results as $result)
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
                                            <a href="{{ route('drivers.show', $result->driver->id) }}" class="hover:text-red-500 transition">
                                                {{ $result->driver->Fname }} {{ $result->driver->Lname }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($result->driver->team)
                                                <a href="{{ route('teams.show', $result->driver->team->id) }}" class="text-red-400 hover:text-red-300">
                                                    {{ $result->driver->team->name }}
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-2xl text-red-500">{{ $result->points }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">No results available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (Auth::check() && auth()->user()->role === 'admin')
                    <div class="mt-8 pt-8 border-t border-gray-700 flex gap-4">
                        <a href="{{ route('standings.edit', $race->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
                            Edit Results
                        </a>
                        <form action="{{ route('standings.destroy', $race->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-900 hover:bg-red-950 text-white font-bold py-3 rounded-lg transition duration-300" onclick="return confirm('Delete all results for this race?')">
                                Delete Results
                            </button>
                        </form>
                    </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-400 text-lg mb-4">No results available for this race</p>
                        @if (Auth::check() && auth()->user()->role === 'admin')
                            <a href="{{ route('standings.create') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300">
                                Enter Results
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
@include('footer')
