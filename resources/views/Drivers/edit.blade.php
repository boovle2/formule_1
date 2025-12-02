<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Driver</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-8">Edit Driver</h1>

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

                <form action="{{ route('drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="Fname" class="block text-white font-semibold mb-2">First Name *</label>
                            <input type="text" name="Fname" id="Fname" value="{{ old('Fname', $driver->Fname) }}" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                        <div>
                            <label for="Lname" class="block text-white font-semibold mb-2">Last Name *</label>
                            <input type="text" name="Lname" id="Lname" value="{{ old('Lname', $driver->Lname) }}" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="number" class="block text-white font-semibold mb-2">Driver Number *</label>
                            <input type="number" name="number" id="number" value="{{ old('number', $driver->number) }}" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                        <div>
                            <label for="points" class="block text-white font-semibold mb-2">Points</label>
                            <input type="number" name="points" id="points" value="{{ old('points', $driver->points) }}"
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="team_id" class="block text-white font-semibold mb-2">Team</label>
                        <select name="team_id" id="team_id"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                            <option value="">Select a team...</option>
                            @foreach (\App\Models\TeamModel::all() as $team)
                                <option value="{{ $team->id }}" {{ old('team_id', $driver->team_id) == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-8">
                        <label for="image" class="block text-white font-semibold mb-2">Driver Photo</label>
                        @if ($driver->image)
                            <div class="mb-4">
                                <p class="text-gray-400 text-sm mb-2">Current photo:</p>
                                <img src="{{ asset('storage/' . $driver->image) }}" alt="{{ $driver->Fname }} {{ $driver->Lname }}" class="h-40 rounded-lg object-cover object-top">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        <p class="text-gray-400 text-sm mt-2">Upload a new photo (optional)</p>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
                            Update Driver
                        </button>
                        <a href="{{ route('drivers.show', $driver->id) }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
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
