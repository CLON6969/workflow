{{-- ========================= SELECT COURSE ========================= --}}
@extends('layouts.Uploader')

@section('title', 'Select Course')

@section('content')

<div class="p-8 min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 py-20 text-white">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.resources.programs.index', [$examBoard, $boardYear, $boardSession]) }}"
           class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 transition">
            ← Back to Program
        </a>
    </div>

    <!-- Header -->
    <div class="mb-6 text-center">

        <h1 class="text-3xl font-bold text-gray-300">
            {{ $boardProgram->name }} → Select Course
        </h1>

        <p class="text-gray-400 mt-2">
            Total Courses: {{ $courses->total() }}
        </p>

        {{-- Search Result Info --}}
        @if(request('search'))
            <div class="mt-4 flex items-center justify-center gap-4 flex-wrap">

                <p class="text-sm text-cyan-300">
                    Found {{ $courses->total() }} result(s) for
                    "<span class="font-semibold">{{ request('search') }}</span>"
                </p>

                <a href="{{ route('admin.resources.courses.index', [$examBoard, $boardYear, $boardSession, $boardProgram]) }}"
                   class="inline-flex items-center gap-2 bg-red-500/20 hover:bg-red-500/30
                          border border-red-400/30 text-red-300 px-4 py-2 rounded-xl
                          text-sm transition">

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
                id="courseSearch"
                value="{{ request('search') }}"
                placeholder="Search course..."
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

    <!-- Courses Grid -->
    <div
        id="courseGrid"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5"
    >

        @forelse($courses as $course)

<a href="{{ route('admin.resources.upload.form', [$examBoard, $boardYear, $boardSession, $boardProgram, $course]) }}"
   class="course-card border-4 rounded-2xl p-5 transition duration-300 hover:shadow-lg

   {{ $course->resources_count > 0
        ? 'bg-green-50 border-green-400 hover:border-green-500'
        : 'bg-white border-gray-200 hover:border-blue-500'
   }}">

    <div class="flex flex-col h-full">

        <!-- TOP -->
        <div class="flex-1">

            <h2 class="course-name text-sm font-semibold text-gray-800 leading-relaxed">
                {{ $course->name }}
            </h2>

            @if($course->code)
                <p class="text-xs text-gray-500 mt-2">
                    {{ $course->code }}
                </p>
            @endif

        </div>

        <!-- BOTTOM -->
        <div class="mt-4 flex items-center justify-between">

            {{-- STATUS (IMPORTANT FOR ADMIN) --}}
            @if($course->resources_count > 0)

                <span class="inline-block bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                    Uploaded ({{ $course->resources_count }})
                </span>

            @else

                <span class="inline-block bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full">
                    Not Uploaded
                </span>

            @endif

            {{-- ACTION --}}
            <span class="
                {{ $course->resources_count > 0 ? 'text-green-600' : 'text-blue-600' }}
                text-sm font-medium">
                Upload →
            </span>

        </div>

    </div>

</a>

        @empty

            <div class="col-span-full text-center py-16 text-gray-400">
                No courses found.
            </div>

        @endforelse

    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $courses->links() }}
        </div>
    @endif

</div>

<!-- Search Script -->
<script>

const searchInput = document.getElementById('courseSearch');
const searchBtn = document.getElementById('searchBtn');

function performSearch() {

    const value = searchInput.value.trim();

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
searchInput.addEventListener('keyup', function () {

    clearTimeout(this.timeout);

    this.timeout = setTimeout(() => {
        performSearch();
    }, 500);

});

// Button search
searchBtn.addEventListener('click', function () {
    performSearch();
});

</script>

@endsection