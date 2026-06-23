@extends('layouts.Seller')

@section('title', 'Resource Analytics')

@section('content')
<div class="min-h-screen bg-slate-950 text-white p-4 md:p-6 space-y-6">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

        <div class="space-y-1">
            <h1 class="text-2xl md:text-3xl font-bold"> Resource Analytics</h1>
            <p class="text-gray-400 text-sm md:text-base">
                Search, filter and analyze platform resources in real time
            </p>
        </div>

        <!-- NAV ACTIONS -->
        <div class="flex gap-2">

            <a href="{{ route('admin.analytics.dashboard') }}"
               class="bg-white/5 hover:bg-white/10 border border-white/10 px-4 py-2 rounded-xl text-sm transition">
                ⬅ Dashboard
            </a>

            <a href="{{ route('admin.analytics.resources') }}"
               class="bg-slate-800 hover:bg-slate-700 border border-white/10 px-4 py-2 rounded-xl text-sm transition">
                🔄 Reset
            </a>

        </div>

    </div>

    <!-- ================= FILTERS ================= -->
    <form method="GET"
          class="bg-white/5 border border-white/10 rounded-2xl p-4 md:p-5 space-y-3">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">

            <!-- SEARCH -->
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search resource title..."
                   class="bg-slate-900 border border-white/10 p-2 rounded-lg w-full">

            <!-- BOARD -->
            <select name="board_id" class="bg-slate-900 border border-white/10 p-2 rounded-lg w-full">
                <option value="">All Boards</option>
                @foreach($boards as $b)
                    <option value="{{ $b->id }}" @selected(request('board_id') == $b->id)>
                        {{ $b->name }}
                    </option>
                @endforeach
            </select>

            <!-- PROGRAM -->
            <select name="program_id" class="bg-slate-900 border border-white/10 p-2 rounded-lg w-full">
                <option value="">All Programs</option>
                @foreach($programs as $p)
                    <option value="{{ $p->id }}" @selected(request('program_id') == $p->id)>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>

            <!-- COURSE -->
            <select name="course_id" class="bg-slate-900 border border-white/10 p-2 rounded-lg w-full">
                <option value="">All Courses</option>
                @foreach($courses as $c)
                    <option value="{{ $c->id }}" @selected(request('course_id') == $c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>

            <!-- SORT -->
            <select name="sort" class="bg-slate-900 border border-white/10 p-2 rounded-lg w-full">
                <option value="">Latest</option>
                <option value="downloads" @selected(request('sort')=='downloads')>Most Downloads</option>
                <option value="views" @selected(request('sort')=='views')>Most Views</option>
            </select>

            <!-- APPLY -->
            <button class="bg-indigo-600 hover:bg-indigo-500 transition rounded-lg px-4 py-2 font-medium w-full">
                Apply
            </button>

        </div>

        <!-- SINGLE DATE FILTER -->
        <div class="mt-3 text-black">
            <input type="date"
                   name="date"
                   value="{{ request('date') }}"
                   class="bg-slate-900 border border-white/10 p-2 rounded-lg w-full md:w-1/3">
        </div>

    </form>

    <!-- ================= TABLE ================= -->
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto max-h-[75vh]">

            <table class="min-w-full text-sm">

                <thead class="bg-slate-900 text-gray-300 sticky top-0 z-20">
                    <tr class="text-left">
                        <th class="p-3">Resource</th>
                        <th>Board</th>
                        <th>Program</th>
                        <th>Course</th>
                        <th class="text-blue-400">Views</th>
                        <th class="text-green-400">Downloads</th>
                        <th>Conversion</th>
                        <th>Last Activity</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/10">

                    @forelse($resources as $r)

                        @php
                            $conversion = $r->views_count > 0
                                ? round(($r->downloads_count / $r->views_count) * 100, 1)
                                : 0;

                            $badge = match(true) {
                                $conversion >= 50 => 'bg-green-500/20 text-green-400',
                                $conversion >= 20 => 'bg-yellow-500/20 text-yellow-300',
                                default => 'bg-red-500/20 text-red-400',
                            };
                        @endphp

                        <tr class="hover:bg-white/5 transition">

                            <td class="p-3 font-medium max-w-[220px] truncate">
                                {{ $r->title }}
                            </td>

                            <td class="text-gray-300">{{ $r->examBoard->name ?? '-' }}</td>
                            <td class="text-gray-300">{{ $r->boardProgram->name ?? '-' }}</td>
                            <td class="text-gray-300">{{ $r->boardCourse->name ?? '-' }}</td>

                            <td class="text-blue-400 font-semibold">
                                {{ number_format($r->views_count) }}
                            </td>

                            <td class="text-green-400 font-semibold">
                                {{ number_format($r->downloads_count) }}
                            </td>

                            <td>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                    {{ $conversion }}%
                                </span>
                            </td>

                            <td class="text-gray-400 text-xs">
                                {{ $r->updated_at->diffForHumans() }}
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="p-10 text-center text-gray-500">
                                No resources found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

    <!-- ================= PAGINATION ================= -->
    <div class="flex justify-center">
        <div class="bg-white/5 p-2 rounded-xl">
            {{ $resources->links() }}
        </div>
    </div>

</div>
@endsection