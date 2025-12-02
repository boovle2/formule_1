<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formula 1 - Homepage</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-black">
    @include('header')

    <!-- Hero Section -->
    <div class="relative w-full h-screen bg-gradient-to-r from-black via-red-900 to-black overflow-hidden">
        <!-- Background Video/Image Effect -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22><defs><pattern id=%22grid%22 width=%2240%22 height=%2240%22 patternUnits=%22userSpaceOnUse%22><path d=%22M 40 0 L 0 0 0 40%22 fill=%22none%22 stroke=%22rgba(255,255,255,.05)%22 stroke-width=%221%22/></pattern></defs><rect width=%221200%22 height=%22600%22 fill=%22rgba(0,0,0,.5)%22/><rect width=%221200%22 height=%22600%22 fill=%22url(%23grid)%22/></svg>')]"></div>

        <div class="relative z-10 h-full flex items-center justify-center px-4">
            <div class="text-center max-w-4xl">
                <!-- Logo/Title -->
                <div class="mb-8">
                    <h1 class="text-7xl md:text-8xl font-black text-red-600 mb-4 tracking-tighter">
                        FORMULA 1
                    </h1>
                    <div class="h-1 w-32 bg-gradient-to-r from-red-600 to-red-400 mx-auto mb-8"></div>
                </div>

                <!-- Subtitle -->
                <p class="text-xl md:text-3xl text-gray-300 mb-8 font-light">
                    The Greatest Motorsport on Earth
                </p>

                <!-- Description -->
                <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
                    Experience the speed, passion, and drama of Formula 1. Explore the world's best drivers, teams, and races.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('races.index') }}" class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold text-lg rounded-lg transition duration-300 shadow-lg hover:shadow-red-900/50">
                        Explore Races
                    </a>
                    <a href="{{ route('drivers.index') }}" class="px-8 py-4 bg-gray-800 hover:bg-gray-700 text-white font-bold text-lg rounded-lg transition duration-300 border border-gray-600">
                        View Drivers
                    </a>
                </div>
            </div>
        </div>

        <!-- Animated Bottom Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-black py-16 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Teams -->
                <a href="{{ route('teams.index') }}" class="group bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-8 hover:from-red-900 hover:to-gray-900 transition duration-300 border border-gray-700">
                    <div class="text-4xl mb-4">🏁</div>
                    <h3 class="text-2xl font-bold text-white mb-2">Teams</h3>
                    <p class="text-gray-400 mb-4">{{ \App\Models\TeamModel::count() }} Teams</p>
                    <p class="text-gray-500 group-hover:text-gray-300 transition">Explore all Formula 1 teams and their performance</p>
                </a>

                <!-- Drivers -->
                <a href="{{ route('drivers.index') }}" class="group bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-8 hover:from-red-900 hover:to-gray-900 transition duration-300 border border-gray-700">
                    <div class="text-4xl mb-4">🏎️</div>
                    <h3 class="text-2xl font-bold text-white mb-2">Drivers</h3>
                    <p class="text-gray-400 mb-4">{{ \App\Models\DriverModel::count() }} Drivers</p>
                    <p class="text-gray-500 group-hover:text-gray-300 transition">Meet the world's best drivers</p>
                </a>

                <!-- Races -->
                <a href="{{ route('races.index') }}" class="group bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-8 hover:from-red-900 hover:to-gray-900 transition duration-300 border border-gray-700">
                    <div class="text-4xl mb-4">🏆</div>
                    <h3 class="text-2xl font-bold text-white mb-2">Races</h3>
                    <p class="text-gray-400 mb-4">{{ \App\Models\RaceModel::count() }} Races</p>
                    <p class="text-gray-500 group-hover:text-gray-300 transition">Follow the championship calendar</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Section -->
    <div class="bg-gradient-to-b from-black to-gray-900 py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 text-center">Latest Updates</h2>
            <div class="h-1 w-24 bg-red-600 mx-auto mb-12"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Featured Teams -->
                @php
                    $topTeams = \App\Models\TeamModel::orderBy('points', 'desc')->limit(3)->get();
                @endphp
                @forelse ($topTeams as $team)
                <div class="bg-gray-800 rounded-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                    <div class="h-40 bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center">
                        <span class="text-white text-5xl font-bold opacity-30">{{ substr($team->name, 0, 1) }}</span>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-white mb-2">{{ $team->name }}</h4>
                        <p class="text-gray-400 text-sm mb-4">{{ $team->championships ?? 0 }} Championships</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-red-500">{{ $team->points }} pts</span>
                            <a href="{{ route('teams.show', $team->id) }}" class="text-red-500 hover:text-red-400 font-semibold">→</a>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 col-span-3 text-center">No teams yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-black py-20 px-4 border-t border-gray-800">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 text-center">Why Choose Our Platform</h2>
            <div class="h-1 w-24 bg-red-600 mx-auto mb-12"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="text-5xl mb-4">⚡</div>
                    <h4 class="text-white font-bold text-lg mb-2">Live Updates</h4>
                    <p class="text-gray-400">Real-time race information and standings</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="text-5xl mb-4">🎯</div>
                    <h4 class="text-white font-bold text-lg mb-2">Detailed Stats</h4>
                    <p class="text-gray-400">Comprehensive driver and team statistics</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="text-5xl mb-4">📱</div>
                    <h4 class="text-white font-bold text-lg mb-2">Responsive Design</h4>
                    <p class="text-gray-400">Access from any device, anytime</p>
                </div>

                <!-- Feature 4 -->
                <div class="text-center">
                    <div class="text-5xl mb-4">🔐</div>
                    <h4 class="text-white font-bold text-lg mb-2">Secure</h4>
                    <p class="text-gray-400">Your data is safe and protected</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-red-900 via-black to-red-900 py-20 px-4 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute w-96 h-96 bg-red-600 rounded-full -top-48 -right-48"></div>
            <div class="absolute w-96 h-96 bg-red-600 rounded-full -bottom-48 -left-48"></div>
        </div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Join the Action?</h2>
            <p class="text-gray-300 text-lg mb-8 max-w-2xl mx-auto">
                Discover everything about Formula 1 - from the fastest drivers to the most prestigious races.
            </p>
            <a href="{{ route('drivers.index') }}" class="inline-block px-10 py-4 bg-white hover:bg-gray-100 text-red-600 font-bold text-lg rounded-lg transition duration-300 shadow-lg">
                Explore Now
            </a>
        </div>
    </div>

</body>
</html>
@include('footer')