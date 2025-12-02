<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Driver</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('header')
    
    <div class="min-h-screen bg-zinc-800 py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-8">Add New Driver</h1>

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

                <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="Fname" class="block text-white font-semibold mb-2">First Name *</label>
                            <input type="text" name="Fname" id="Fname" value="{{ old('Fname') }}" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                        <div>
                            <label for="Lname" class="block text-white font-semibold mb-2">Last Name *</label>
                            <input type="text" name="Lname" id="Lname" value="{{ old('Lname') }}" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="number" class="block text-white font-semibold mb-2">Driver Number *</label>
                            <input type="number" name="number" id="number" value="{{ old('number') }}" required
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                        <div>
                            <label for="points" class="block text-white font-semibold mb-2">Points</label>
                            <input type="number" name="points" id="points" value="{{ old('points', 0) }}"
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="team_id" class="block text-white font-semibold mb-2">Team</label>
                        <select name="team_id" id="team_id"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                            <option value="">Select a team...</option>
                            @foreach (\App\Models\TeamModel::all() as $team)
                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-8">
                        <label for="image" class="block text-white font-semibold mb-2">Driver Photo</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600">
                        <p class="text-gray-400 text-sm mt-2">Upload a driver photo</p>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
                            Add Driver
                        </button>
                        <a href="{{ route('drivers.index') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition duration-300 text-center">
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
                        <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4 4 4M17 8v12m0 0l4-4m-4 4-4-4"></path></svg>
                        Kies bestand
                    </label>

                    <span id="fileName" class="text-sm text-gray-600 truncate">Geen bestand geselecteerd</span>
                </div>

                @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Create Driver</button>
            </div>
        </form>
    </main>

    <footer class="footer bg-gray-800 text-white p-4 text-center mt-8">
        <p>&copy; 2024 Formule 1. All rights reserved.</p>
    </footer>

    <script>
        // show chosen filename and allow keyboard activation
        const input = document.getElementById('image');
        const fileName = document.getElementById('fileName');
        const imageBtn = document.getElementById('imageBtn');

        imageBtn.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                input.click();
            }
        });

        input.addEventListener('change', () => {
            const f = input.files[0];
            fileName.textContent = f ? f.name : 'Geen bestand geselecteerd';
        });
    </script>
</body>
</html>