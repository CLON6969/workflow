{{-- ========================= PLATFORM STATISTICS ========================= --}}
@extends('layouts.select')

@section('title', 'Platform Statistics')

@section('content')

<div class="p-8 min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 py-20 text-white">

    <!-- Header -->
    <div class="max-w-7xl mx-auto mb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white flex items-center justify-center gap-4">
            <i class="fas fa-chart-pie text-emerald-400"></i>
            Platform Statistics
        </h1>
        <p class="text-gray-400 mt-3 text-lg">
            Comprehensive Academic Content Upload & Completion Dashboard
        </p>
    </div>

    <!-- Overall Statistics -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">

        <!-- Boards -->
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 hover:border-blue-400/50 transition-all group">
            <div>
                <i class="fas fa-university text-4xl text-blue-400 mb-4"></i>
                <p class="text-gray-400 text-sm font-medium">EXAM BOARDS</p>
                <p class="text-5xl font-bold mt-2">
                    {{ $boardPercent }}<span class="text-3xl font-normal text-gray-400">%</span>
                </p>
            </div>

            <p class="mt-6 text-xs text-gray-500">
                {{ $boardsWithData }} of {{ $totalBoards }} boards have data
            </p>

            <div class="mt-4 h-2.5 bg-white/10 rounded-3xl overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-400 rounded-3xl"
                     style="width: {{ $boardPercent }}%"></div>
            </div>
        </div>

        <!-- Years -->
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 hover:border-indigo-400/50 transition-all group">
            <div>
                <i class="fas fa-calendar-alt text-4xl text-indigo-400 mb-4"></i>
                <p class="text-gray-400 text-sm font-medium">YEARS</p>
                <p class="text-5xl font-bold mt-2">
                    {{ $yearPercent }}<span class="text-3xl font-normal text-gray-400">%</span>
                </p>
            </div>

            <p class="mt-6 text-xs text-gray-500">
                {{ $yearsWithData }} of {{ $totalYears }} years active
            </p>

            <div class="mt-4 h-2.5 bg-white/10 rounded-3xl overflow-hidden">
                <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-400 rounded-3xl"
                     style="width: {{ $yearPercent }}%"></div>
            </div>
        </div>

        <!-- Programs -->
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 hover:border-purple-400/50 transition-all group">
            <div>
                <i class="fas fa-graduation-cap text-4xl text-purple-400 mb-4"></i>
                <p class="text-gray-400 text-sm font-medium">PROGRAMS</p>
                <p class="text-5xl font-bold mt-2">
                    {{ $programPercent }}<span class="text-3xl font-normal text-gray-400">%</span>
                </p>
            </div>

            <p class="mt-6 text-xs text-gray-500">
                {{ $programsWithData }} of {{ $totalPrograms }} programs
            </p>

            <div class="mt-4 h-2.5 bg-white/10 rounded-3xl overflow-hidden">
                <div class="h-full bg-gradient-to-r from-purple-500 to-fuchsia-400 rounded-3xl"
                     style="width: {{ $programPercent }}%"></div>
            </div>
        </div>

        <!-- Courses -->
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 hover:border-emerald-400/50 transition-all group">
            <div>
                <i class="fas fa-book-open text-4xl text-emerald-400 mb-4"></i>
                <p class="text-gray-400 text-sm font-medium">COURSES WITH RESOURCES</p>
                <p class="text-5xl font-bold mt-2">
                    {{ $coursePercent }}<span class="text-3xl font-normal text-gray-400">%</span>
                </p>
            </div>

            <p class="mt-6 text-xs text-gray-500">
                {{ $coursesWithResources }} of {{ $totalCourses }} courses
            </p>

            <div class="mt-4 h-2.5 bg-white/10 rounded-3xl overflow-hidden">
                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-3xl"
                     style="width: {{ $coursePercent }}%"></div>
            </div>
        </div>

    </div>

    <!-- BOARD BREAKDOWN -->
    <div class="max-w-7xl mx-auto">

        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
                <i class="fas fa-chart-bar"></i>
                Board-wise Progress
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($boardStats as $stat)

            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 hover:border-white/30 transition-all group">

                <!-- HEADER -->
                <div class="flex justify-between items-center mb-8">

                    <!-- ICON + NAME -->
                    <div class="flex items-center gap-4">

                        <div class="text-4xl text-blue-600">
                            @if($stat['name'] === 'ECZ')
                                <i class="fa-brands fa-galactic-republic"></i>
                            @elseif($stat['name'] === 'TEVETA')
                                <i class="fa-brands fa-old-republic"></i>
                            @elseif($stat['name'] === 'UNZA')
                                <i class="fa-brands fa-staylinked"></i>
                            @elseif($stat['name'] === 'ZICA')
                                <i class="fa-brands fa-phoenix-squadron"></i>
                            @elseif($stat['name'] === 'Cambridge')
                                <i class="fa-brands fa-vsco"></i>
                            @else
                                🎓
                            @endif
                        </div>

                        <h3 class="text-2xl font-bold">
                            {{ $stat['name'] }}
                        </h3>

                    </div>

                    <!-- OVERALL % -->
                    <div class="text-right">
                        <span class="text-5xl font-bold text-emerald-400">
                            {{ $stat['overall_percent'] }}
                        </span>
                        <span class="text-2xl text-emerald-400/70">%</span>
                    </div>

                </div>

                <!-- YEARS -->
                <div class="mb-5">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-400 flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i> Years
                        </span>
                        <span>{{ $stat['year_percent'] }}%</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full">
                        <div class="h-full bg-blue-500" style="width: {{ $stat['year_percent'] }}%"></div>
                    </div>
                </div>

                <!-- SESSIONS -->
                <div class="mb-5">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-400 flex items-center gap-2">
                            <i class="fas fa-clock"></i> Sessions
                        </span>
                        <span>{{ $stat['session_percent'] }}%</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full">
                        <div class="h-full bg-indigo-500" style="width: {{ $stat['session_percent'] }}%"></div>
                    </div>
                </div>

                <!-- PROGRAMS -->
                <div class="mb-5">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-400 flex items-center gap-2">
                            <i class="fas fa-graduation-cap"></i> Programs
                        </span>
                        <span>{{ $stat['program_percent'] }}%</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full">
                        <div class="h-full bg-purple-500" style="width: {{ $stat['program_percent'] }}%"></div>
                    </div>
                </div>

                <!-- COURSES -->
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-400 flex items-center gap-2">
                            <i class="fas fa-book"></i> Courses
                        </span>
                        <span>{{ $stat['course_percent'] }}%</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full">
                        <div class="h-full bg-emerald-500" style="width: {{ $stat['course_percent'] }}%"></div>
                    </div>
                </div>

            </div>

            @endforeach

        </div>
    </div>

</div>

@endsection