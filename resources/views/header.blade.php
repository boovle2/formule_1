<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">
    <header class="flex justify-between items-center p-4 bg-gray-300">


        <nav>
            <ul class="flex space-x-4">
                <p class=" font-bold text-red-600">Formule 1</p>
                <li><a href="/" class="text-gray-700 hover:text-red-600">Home</a></li>
                <li><a href="/races" class="text-gray-700 hover:text-red-600">Races</a></li>
                <li><a href="/drivers" class="text-gray-700 hover:text-red-600">Drivers</a></li>
                <li><a href="/teams" class="text-gray-700 hover:text-red-600">Teams</a></li>
                <li><a href="/standings" class="text-gray-700 hover:text-red-600">Standings</a></li>
            </ul>
        </nav>

        @if (Auth::check())

        <div class="relative">
            <button onclick="toggleMenu()" class="flex items-center gap-2 bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                <span>{{ auth()->user()->name }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="userMenu" class="hidden absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg z-50">
                <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">Profile</a>

                @if(auth()->user()->role === 'admin')
                <a href="/admin" class="block px-4 py-2 hover:bg-gray-100">Admin Dashboard</a>
                @endif

                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>

        <script>
            function toggleMenu() {
                document.getElementById('userMenu').classList.toggle('hidden');
            }
        </script>



        @else
        <nav>
            <ul class="flex space-x-4">
                <li><a href="/login" class="text-gray-700 hover:text-red-600">Login</a></li>
            </ul>
        </nav>
        @endif

    </header>

</body>

</html>