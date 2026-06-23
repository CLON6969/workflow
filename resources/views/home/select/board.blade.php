{{-- ========================= SELECT EXAMINATION BOARD ========================= --}}
@extends('layouts.select')

@section('title', 'Select Examination Board')

@section('content')

<div class="p-8 min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 py-20 text-white">

    <!-- Header -->
    <div class="mb-6 text-center">

        <h1 class="text-3xl font-bold text-gray-300">
            Select Examination Board
        </h1>

        <p class="text-gray-400 mt-1">
            Total Boards: {{ $examBoards->total() }}
        </p>

        {{-- Search Result Info --}}
        @if(request('search'))
            <div class="mt-4 flex items-center justify-center gap-4 flex-wrap">

                <p class="text-sm text-cyan-300">
                    Found {{ $examBoards->total() }} result(s) for
                    "<span class="font-semibold">{{ request('search') }}</span>"
                </p>

                <a href="{{ route('select.board') }}"
                   class="inline-flex items-center gap-2 bg-red-500/20 hover:bg-red-500/30
                          border border-red-400/30 text-red-300 px-4 py-2 rounded-xl text-sm">

                    <i class="fas fa-times"></i>
                    Clear Search

                </a>

            </div>
        @endif

    </div>

    <!-- Search -->
    <div class="mb-6">

        <div class="flex gap-3">

            <input
                type="text"
                id="boardSearch"
                value="{{ request('search') }}"
                placeholder="Search board..."
                class="w-full text-black border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none"
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

    <!-- Boards Grid -->
    <div
        id="boardGrid"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5"
    >

        @forelse($examBoards as $board)

            <a href="{{ route('select.year', $board) }}"
               class="board-card bg-white border-gray-200 border-4 hover:border-blue-500 hover:shadow-lg transition duration-300 rounded-2xl p-5">

                <div class="flex flex-col h-full">

                    <div class="flex-1">

                        <div class="text-4xl mb-4 text-blue-600">
                            @if($board->name === 'ECZ')
                                <i class="fa-brands fa-galactic-republic"></i>
                            @elseif($board->name === 'TEVETA')
                                <i class="fa-brands fa-old-republic"></i>
                            @elseif($board->name === 'UNZA')
                                <i class="fa-brands fa-staylinked"></i>
                            @elseif($board->name === 'ZICA')
                                <i class="fa-brands fa-phoenix-squadron"></i>
                            @elseif($board->name === 'Cambridge')
                                <i class="fa-brands fa-vsco"></i>
                            @else
                                🎓
                            @endif
                        </div>

                        <h2 class="board-name text-sm font-semibold text-gray-800 leading-relaxed">
                            {{ $board->name }}
                        </h2>

                    </div>

                    <div class="mt-4 flex items-center justify-between">

                        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                            Board
                        </span>

                        <span class="text-blue-600 text-sm font-medium">
                            Open →
                        </span>

                    </div>

                </div>

            </a>

        @empty

            <div class="col-span-full text-center py-16 text-gray-400">
                No boards found.
            </div>

        @endforelse

    </div>

    <!-- Empty Search State -->
    <div
        id="noBoardResults"
        class="hidden text-center py-16 text-gray-500"
    >
        No boards found.
    </div>

    <!-- Pagination -->
    @if($examBoards->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $examBoards->links() }}
        </div>
    @endif

</div>

<!-- SCRIPT -->
<script>

const boardSearch = document.getElementById('boardSearch');
const searchBtn = document.getElementById('searchBtn');

function performSearch() {

    const value = boardSearch.value.trim();

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
boardSearch.addEventListener('keyup', function () {

    clearTimeout(this.timeout);

    this.timeout = setTimeout(() => {
        performSearch();
    }, 500);

});

// Button search
searchBtn.addEventListener('click', performSearch);

</script>

@endsection