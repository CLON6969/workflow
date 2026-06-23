{{-- ========================= SELECT COURSE ========================= --}}
@extends('layouts.select')

@section('title', 'Select Course')

@section('content')

<div class="p-8 min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 py-20 text-white">

        <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('select.program', [$examBoard, $year, $session]) }}"
           class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 transition text-sm font-medium">

            <i class="fas fa-arrow-left"></i>
            Back to Programs

        </a>
    </div>

    <!-- Header -->
    <div class="mb-6 text-center">

        <h1 class="text-3xl font-bold text-gray-300">
            {{ $program->name }} → Select Course
        </h1>

        <p class="text-gray-400 mt-1">
            Total Courses: {{ $courses->total() }}
        </p>

        {{-- Search Result Info --}}
        @if(request('search'))
            <div class="mt-4 flex items-center justify-center gap-4 flex-wrap">

                <p class="text-sm text-cyan-300">
                    Found {{ $courses->total() }} result(s) for
                    "<span class="font-semibold">{{ request('search') }}</span>"
                </p>

                <a href="{{ route('select.course', [$examBoard, $year, $session, $program]) }}"
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

            @php
                $resourcesCount = $course->resources->count();
                $downloads = $course->resources->sum('downloads_count');
                $views = $course->resources->sum('views_count');
            @endphp

            <div class="course-card bg-white border-4 border-gray-200 hover:border-blue-500 hover:shadow-lg transition duration-300 rounded-2xl p-5">

                <div class="flex flex-col h-full">

                    <div class="flex-1">

                        <div class="text-4xl mb-4 text-blue-600">
                            <i class="fa-regular fa-file-pdf"></i>
                        </div>

                        <h2 class="course-name text-sm font-semibold text-gray-800 leading-relaxed mb-3">
                            {{ $course->name }}
                        </h2>

                        <div class="space-y-2 text-sm text-gray-500">
                            <p>Resources: {{ $resourcesCount }}</p>
                            <p>Downloads: {{ $downloads }}</p>
                            <p>Views: {{ $views }}</p>
                        </div>

                    </div>

                    <div class="mt-5 flex items-center justify-between">

                        @if($course->resources->first())

                            <a href="{{ route('resources.preview', $course->resources->first()) }}"
                               target="_blank"
                               class="text-blue-600 text-sm font-medium hover:underline">
                                View PDF
                            </a>

                            <a href="{{ route('resources.download', $course->resources->first()) }}"
                               class="text-green-600 text-xl">
                                <i class="fa-solid fa-cloud-arrow-down"></i>
                            </a>

                        @endif

                    </div>

                </div>

            </div>

        @empty

<div class="col-span-full text-center py-16 text-gray-400">

    <div class="bg-white/5 border border-white/10 rounded-2xl p-8 max-w-2xl mx-auto">

        <div class="text-5xl text-yellow-400 mb-4">
            <i class="fas fa-circle-exclamation"></i>
        </div>

        <h2 class="text-2xl font-bold text-white mb-3">
            No Courses Found
        </h2>

        <p class="text-gray-300 mb-6 leading-relaxed">
            If the course you are looking for is not available,
            please contact us by clicking the button below or
            inbox/call us using <span class="text-cyan-400 font-semibold">0976206889</span>.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">

<a href="https://wa.me/260976206889?text=Hello%2C%20I%20hope%20you%20are%20doing%20well.%0A%0AI%20was%20unable%20to%20find%20some%20courses%20or%20course%20materials%20on%20your%20platform.%20Kindly%20assist%20me%20with%20adding%20or%20providing%20access%20to%20the%20missing%20course(s).%0A%0AExamination%20Board%3A%20__________%0AProgram%3A%20__________%0ASession%2FYear%3A%20__________%0A%0AMissing%20Course(s)%3A%0A1.%20__________%0A2.%20__________%0A3.%20__________%20or%20ALL%0A%0AThank%20you."
   target="_blank"
   class="inline-flex items-center gap-3 bg-green-600 hover:bg-green-700
          text-white px-6 py-3 rounded-xl transition font-medium">

    <i class="fab fa-whatsapp text-xl"></i>
    Contact on WhatsApp

</a>

            <a href="tel:0976206889"
               class="inline-flex items-center gap-3 bg-cyan-600 hover:bg-cyan-700
                      text-white px-6 py-3 rounded-xl transition font-medium">

                <i class="fas fa-phone"></i>
                0976206889

            </a>

        </div>

    </div>

</div>

        @endforelse

    </div>

    <!-- Empty State -->
    <div
        id="noCourseResults"
        class="hidden text-center py-16 text-gray-500"
    >
        No courses found.
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $courses->links() }}
        </div>
    @endif

</div>

<!-- SCRIPT -->
<script>

const courseSearch = document.getElementById('courseSearch');
const searchBtn = document.getElementById('searchBtn');

function performSearch() {

    const value = courseSearch.value.trim();

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
courseSearch.addEventListener('keyup', function () {

    clearTimeout(this.timeout);

    this.timeout = setTimeout(() => {
        performSearch();
    }, 500);

});

// Button search
searchBtn.addEventListener('click', performSearch);

</script>

@endsection