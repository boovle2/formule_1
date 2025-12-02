<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Race</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-8">Edit Race</h1>

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

                <form action="{{ route('races.update', $race->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="name" class="block text-white font-semibold mb-2">Race Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $race->name) }}" required
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="date" class="block text-white font-semibold mb-2">Date *</label>
                            <input type="date" name="date" id="date" value="{{ old('date', $race->date) }}" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                        <div>
                            <label for="location" class="block text-white font-semibold mb-2">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $race->location) }}"
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="laps" class="block text-white font-semibold mb-2">Laps</label>
                            <input type="number" name="laps" id="laps" value="{{ old('laps', $race->laps) }}"
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                        <div>
                            <label for="distance" class="block text-white font-semibold mb-2">Distance (km)</label>
                            <input type="number" name="distance" id="distance" step="0.01" value="{{ old('distance', $race->distance) }}"
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="image" class="block text-white font-semibold mb-2">Race Image</label>
                        @if ($race->image)
                            <div class="mb-4">
                                <p class="text-gray-400 text-sm mb-2">Current image:</p>
                                <img src="{{ asset('storage/' . $race->image) }}" alt="{{ $race->name }}" class="h-40 rounded-lg object-cover">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        <p class="text-gray-400 text-sm mt-2">Upload a new image (optional)</p>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
                            Update Race
                        </button>
                        <a href="{{ route('races.show', $race->id) }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
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
