@extends('layouts.admin')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="min-h-screen bg-slate-950 text-white p-6">

    <!-- HEADER -->
    <div class="mb-10 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold"> Analytics Dashboard</h1>
            <p class="text-gray-400 mt-2">Overview of platform performance</p>
        </div>

        <!-- QUICK LINK -->
        <a href="{{ route('admin.analytics.resources') }}"
           class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl text-sm">
            🔍 Open Resource Explorer
        </a>
    </div>

    <!-- ================= KPIs ================= -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-10">

        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <p class="text-gray-400 text-sm">Downloads</p>
            <h2 class="text-2xl font-bold text-green-400">{{ number_format($totalDownloads) }}</h2>
        </div>

        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <p class="text-gray-400 text-sm">Views</p>
            <h2 class="text-2xl font-bold text-blue-400">{{ number_format($totalViews) }}</h2>
        </div>

        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <p class="text-gray-400 text-sm">Resources</p>
            <h2 class="text-2xl font-bold">{{ $totalResources }}</h2>
        </div>

        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <p class="text-gray-400 text-sm">Users</p>
            <h2 class="text-2xl font-bold">{{ $totalUsers }}</h2>
        </div>

        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <p class="text-gray-400 text-sm">Courses</p>
            <h2 class="text-2xl font-bold">{{ $totalCourses }}</h2>
        </div>

    </div>

    <!-- ================= CONVERSION ================= -->
    <div class="mb-10">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 rounded-2xl">
            <p class="text-sm text-gray-200">Conversion Rate</p>
            <h2 class="text-3xl font-bold">
                {{ $conversionRate }}%
            </h2>
            <p class="text-sm text-gray-300 mt-1">
                Views → Downloads efficiency
            </p>
        </div>
    </div>

    <!-- ================= CHARTS ================= -->
    <div class="grid md:grid-cols-2 gap-6 mb-12">

        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <h3 class="mb-4 font-semibold">⬇ Downloads Trend</h3>
            <canvas id="downloadsChart"></canvas>
        </div>

        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <h3 class="mb-4 font-semibold">👁 Views Trend</h3>
            <canvas id="viewsChart"></canvas>
        </div>

    </div>

    <!-- ================= RANKINGS (CLICKABLE DRILL DOWN) ================= -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- TOP RESOURCES -->
        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold">🏆 Top Downloads</h3>
                <a href="{{ route('admin.analytics.resources', ['sort' => 'downloads']) }}"
                   class="text-xs text-indigo-400">View all →</a>
            </div>

            @foreach($topResources as $r)
                <a href="{{ route('admin.analytics.resources', ['search' => $r->title]) }}"
                   class="flex justify-between text-sm mb-2 hover:text-indigo-300 transition">
                    <span class="truncate">{{ Str::limit($r->title, 28) }}</span>
                    <span class="text-green-400">{{ $r->downloads_count }}</span>
                </a>
            @endforeach
        </div>

        <!-- MOST VIEWED -->
        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold">👁 Most Viewed</h3>
                <a href="{{ route('admin.analytics.resources', ['sort' => 'views']) }}"
                   class="text-xs text-indigo-400">View all →</a>
            </div>

            @foreach($mostViewed as $r)
                <a href="{{ route('admin.analytics.resources', ['search' => $r->title]) }}"
                   class="flex justify-between text-sm mb-2 hover:text-indigo-300 transition">
                    <span class="truncate">{{ Str::limit($r->title, 28) }}</span>
                    <span class="text-blue-400">{{ $r->views_count }}</span>
                </a>
            @endforeach
        </div>

        <!-- TOP COURSES -->
        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <h3 class="mb-4 font-semibold">📘 Top Courses</h3>

            @foreach($topCourses as $c)
                <a href="{{ route('admin.analytics.resources', ['course_id' => $c->id]) }}"
                   class="flex justify-between text-sm mb-2 hover:text-indigo-300 transition">
                    <span class="truncate">{{ $c->name }}</span>
                    <span class="text-indigo-400">{{ $c->resources_sum_downloads_count ?? 0 }}</span>
                </a>
            @endforeach
        </div>

        <!-- TOP PROGRAMS -->
        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <h3 class="mb-4 font-semibold">🎓 Top Programs</h3>

            @foreach($topPrograms as $p)
                <a href="{{ route('admin.analytics.resources', ['program_id' => $p->id]) }}"
                   class="flex justify-between text-sm mb-2 hover:text-indigo-300 transition">
                    <span class="truncate">{{ $p->name }}</span>
                    <span class="text-indigo-400">{{ $p->resources_sum_downloads_count ?? 0 }}</span>
                </a>
            @endforeach
        </div>

        <!-- TOP BOARDS -->
        <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
            <h3 class="mb-4 font-semibold">🏫 Top Boards</h3>

            @foreach($topBoards as $b)
                <a href="{{ route('admin.analytics.resources', ['board_id' => $b->id]) }}"
                   class="flex justify-between text-sm mb-2 hover:text-indigo-300 transition">
                    <span class="truncate">{{ $b->name }}</span>
                    <span class="text-indigo-400">{{ $b->resources_sum_downloads_count ?? 0 }}</span>
                </a>
            @endforeach
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('downloadsChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($downloadsTrend->pluck('date')) !!},
        datasets: [{
            label: 'Downloads',
            data: {!! json_encode($downloadsTrend->pluck('total')) !!},
            borderWidth: 2,
            fill: false
        }]
    }
});

new Chart(document.getElementById('viewsChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($viewsTrend->pluck('date')) !!},
        datasets: [{
            label: 'Views',
            data: {!! json_encode($viewsTrend->pluck('total')) !!},
            borderWidth: 2,
            fill: false
        }]
    }
});
</script>
@endsection