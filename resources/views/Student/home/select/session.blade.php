{{-- ========================= SELECT SESSION ========================= --}}
@extends('layouts.Uploader')

@section('title', 'Select Session')

@section('content')

<div class="p-8 min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 py-20 text-white">

    <!-- Back Button -->
<div class="mb-6">
    
    <a href="{{ route('Student.select.year', [$examBoard, $year]) }}"
       class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 transition text-sm font-medium">

        <i class="fas fa-arrow-left"></i>
        Back to Years

    </a>
</div>

    <!-- Header -->
    <div class="mb-6 text-center">

        <h1 class="text-3xl font-bold text-gray-300">
            {{ $examBoard->name }} → Select Session
        </h1>

        <p class="text-gray-400 mt-1">
            Total Sessions: {{ $sessions->total() }}
        </p>

        {{-- Search Result Info --}}
        @if(request('search'))
            <div class="mt-4 flex items-center justify-center gap-4 flex-wrap">

                <p class="text-sm text-cyan-300">
                    Found {{ $sessions->total() }} result(s) for
                    "<span class="font-semibold">{{ request('search') }}</span>"
                </p>

                <a href="{{ route('Student.select.session', [$examBoard, $year]) }}"
                   class="inline-flex items-center gap-2 bg-red-500/20 hover:bg-red-500/30
                          border border-red-400/30 text-red-300 px-4 py-2 rounded-xl text-sm">

                    <i class="fas fa-times"></i>
                    Clear Search

                </a>

            </div>
        @endif

    </div>

    <!-- Search -->
    <div class="mb-8">

        <div class="flex gap-3">

            <input
                type="text"
                id="sessionSearch"
                value="{{ request('search') }}"
                placeholder="Search session..."
                class="w-full border text-black border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none"
            >

            <!-- Search Button -->
            <button
                id="searchBtn"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 rounded-xl transition flex items-center justify-center"
            >
                <i class="fas fa-search"></i>
            </button>

        </div>

    </div>

    <!-- Sessions Grid -->
    <div
        id="sessionGrid"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5"
    >

        @forelse($sessions as $session)

            <a href="{{ route('Student.select.program', [$examBoard, $year, $session]) }}"
               class="session-card bg-white border-4 border-gray-200 hover:border-blue-500 hover:shadow-lg transition duration-300 rounded-2xl p-5">

                <div class="flex flex-col h-full">

                    <div class="flex-1">

                        <div class="text-4xl mb-4 text-blue-600">
                            <i class="fas fa-clock"></i>
                        </div>

                        <h2 class="session-name text-sm font-semibold text-gray-800 leading-relaxed">
                            {{ $session->name }}
                        </h2>

                    </div>

                    <div class="mt-4 flex items-center justify-between">

                        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                            Session
                        </span>

                        <span class="text-blue-600 text-sm font-medium">
                            Open →
                        </span>

                    </div>

                </div>

            </a>

        @empty

            <div class="col-span-full text-center py-16 text-gray-400">
                No sessions found.
            </div>

        @endforelse

    </div>

    <!-- Empty State -->
    <div
        id="noSessionResults"
        class="hidden text-center py-16 text-gray-500"
    >
        No sessions found.
    </div>

    <!-- Pagination -->
    @if($sessions->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $sessions->links() }}
        </div>
    @endif

</div>

<!-- SCRIPT -->
<script>

const sessionSearch = document.getElementById('sessionSearch');
const searchBtn = document.getElementById('searchBtn');

function performSearch() {

    const value = sessionSearch.value.trim();

    const url = new URL(window.location.href);

    if (value.length > 0) {
        url.searchParams.set('search', value);
    } else {
        url.searchParams.delete('search');
    }

    url.searchParams.delete('page');
    window.location.href = url.toString();
}

// Live search
sessionSearch.addEventListener('keyup', function () {

    clearTimeout(this.timeout);

    this.timeout = setTimeout(() => {
        performSearch();
    }, 500);

});

// Button search
searchBtn.addEventListener('click', performSearch);

</script>

@endsection