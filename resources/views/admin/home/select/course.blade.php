{{-- ========================= SELECT COURSE ========================= --}}
@extends('layouts.Uploader')

@section('title', 'Select Course')

@section('content')

<div class="p-8 min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 py-20 text-white">

        <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.select.program', [$examBoard, $year, $session]) }}"
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

                <a href="{{ route('admin.select.course', [$examBoard, $year, $session, $program]) }}"
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

                $firstResource = $course->resources->first();
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

                            <p>
                                <i class="fa-solid fa-box-open"></i>
                                Resources: {{ $resourcesCount }}
                            </p>

                            <p>
                                <i class="fa-solid fa-download"></i>
                                Downloads: {{ $downloads }}
                            </p>

                            <p>
                                <i class="fa-solid fa-eye"></i>
                                Views: {{ $views }}
                            </p>

                        </div>

                    </div>

                    <div class="mt-5 flex items-center justify-between">

                        @if($firstResource)

                            <!-- VIEW PDF -->
                            <a href="{{ route('resources.preview', $firstResource) }}"
                               target="_blank"
                               class="text-blue-600 text-sm font-medium hover:underline">
                                View PDF
                            </a>

                            <div class="flex items-center gap-4">

                                <!-- DOWNLOAD -->
                                <a href="{{ route('resources.download', $firstResource) }}"
                                   class="text-green-600 text-xl hover:text-green-500"
                                   title="Download PDF">
                                    <i class="fa-solid fa-cloud-arrow-down"></i>
                                </a>

                                <!-- SAVE / UNSAVE -->
                                @if(in_array($firstResource->id, $savedIds ?? []))

                                    <form action="{{ route('admin.home.resource.unsave', $firstResource) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-yellow-400 hover:text-yellow-300 text-xl transition"
                                            title="Unsave Resource">
                                            ★
                                        </button>
                                    </form>

                                @else

                                    <form action="{{ route('admin.home.resource.save', $firstResource) }}"
                                          method="POST">
                                        @csrf

                                        <button
                                            type="submit"
                                            class="text-gray-400 hover:text-yellow-400 text-xl transition"
                                            title="Save Resource">
                                            ☆
                                        </button>
                                    </form>

                                @endif

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-full text-center py-16 text-gray-400">
                No courses found.
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