<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-8">Edit Team</h1>

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

                <form action="{{ route('teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="name" class="block text-white font-semibold mb-2">Team Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                    </div>

                    <div class="mb-6">
                        <label for="team_principal" class="block text-white font-semibold mb-2">Team Principal</label>
                        <input type="text" name="team_principal" id="team_principal" value="{{ old('team_principal', $team->team_principal) }}"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                    </div>

                    <div class="mb-6">
                        <label for="points" class="block text-white font-semibold mb-2">Points</label>
                        <input type="number" name="points" id="points" value="{{ old('points', $team->points) }}"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                    </div>

                    <div class="mb-6">
                        <label for="championships" class="block text-white font-semibold mb-2">Championships</label>
                        <input type="text" name="championships" id="championships" value="{{ old('championships', $team->championships) }}"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                    </div>

                    <div class="mb-8">
                        <label for="logo" class="block text-white font-semibold mb-2">Team Logo</label>
                        @if ($team->logo)
                            <div class="mb-4">
                                <p class="text-gray-400 text-sm mb-2">Current logo:</p>
                                <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="h-32 rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="logo" id="logo" accept="image/*"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        <p class="text-gray-400 text-sm mt-2">Upload a new team logo (optional)</p>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
                            Update Team
                        </button>
                        <a href="{{ route('teams.show', $team->id) }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
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
