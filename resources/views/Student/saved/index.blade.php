@extends('layouts.Student')

@section('title', 'Saved Papers')

@section('content')
<div class="min-h-screen bg-slate-950 text-white py-20">

    <!-- HEADER -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold"> Saved Papers</h1>
        <p class="text-indigo-400 mt-2">
            Your bookmarked past papers
        </p>
    </div>

    <!-- GRID -->
    <div class="max-w-7xl mx-auto grid md:grid-cols-3 lg:grid-cols-4 gap-6 px-6">

        @forelse($resources as $resource)

            <div class="relative group bg-white/5 border border-white/10 rounded-3xl p-6 hover:border-yellow-400 transition">

                <!-- ICON -->
                <div class="text-4xl mb-4">
                    <i class="fa-regular fa-file-pdf"></i>
                </div>

                <!-- TITLE -->
                <h3 class="text-lg font-semibold mb-2 line-clamp-2">
                    {{ $resource->title }}
                </h3>

                <!-- META -->
                <div class="text-sm text-gray-400 space-y-1">
                    <p> 

                    <div class="text-sm mb-4">
                        @if($resource->name === 'ECZ') <i class="fa-brands fa-galactic-republic"></i>
                        @elseif($resource->examBoard->name === 'TEVETA') <i class="fa-brands fa-old-republic"></i>
                         @elseif($resource->examBoard->name === 'UNZA') <i class="fa-brands fa-staylinked"></i>
                          @elseif($resource->examBoard->name === 'ZICA') <i class="fa-brands fa-phoenix-squadron"></i>
                        @elseif($resource->examBoard->name === 'Cambridge') <i class="fa-brands fa-vsco"></i>

                        
                        @else 🎓 @endif  {{ $resource->examBoard->name ?? '-' }}
                    </div>
                    </p>
                    <p><i class="fa-regular fa-file-pdf"></i>  {{ $resource->boardCourse->name ?? '-' }}</p>
                </div>

                <!-- STATS -->
                <div class="flex justify-between text-sm mt-4">
                    <span class="text-blue-400"> <i class="fa-solid fa-eye"></i>  {{ number_format($resource->views_count) }}</span>
                    <span class="text-green-400"> <i class="fa-solid fa-download"></i> {{ number_format($resource->downloads_count) }}</span>
                </div>

                <!-- ACTIONS -->
                <div class="flex justify-between items-center mt-6">

                    <!-- VIEW -->
                        <a href="{{ route('resources.preview', $resource) }}"
                           target="_blank"
                           class="text-indigo-400 hover:text-indigo-300 text-sm">
                            View PDF
                        </a>
                    

                    <!-- DOWNLOAD -->
                        <a href="{{ route('resources.download', $resource) }}"
                           class="text-green-400 hover:text-green-300 text-xl"
                           title="Download PDF">
                            <i class="fa-solid fa-cloud-arrow-down"></i>
                        </a>

                    <!-- UNSAVE -->
                    <form action="{{ route('Student.home.resource.unsave', $resource) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-yellow-400 text-lg hover:scale-110 transition"
                                title="Remove from saved">
                            ★
                        </button>
                    </form>

                </div>

            </div>

        @empty

            <!-- EMPTY STATE -->
            <div class="col-span-full text-center py-20">

                <div class="text-6xl mb-4">📭</div>

                <p class="text-gray-400 text-lg">
                    You haven't saved any papers yet.
                </p>

                <a href="{{ route('Student.home.boards') }}"
                   class="inline-block mt-6 bg-indigo-600 px-6 py-3 rounded-xl hover:bg-indigo-500 transition">
                    Browse Papers
                </a>

            </div>

        @endforelse

    </div>

    <!-- PAGINATION -->
    @if($resources->hasPages())
        <div class="mt-10 flex justify-center">
            <div class="bg-white/5 px-4 py-2 rounded-xl">
                {{ $resources->links() }}
            </div>
        </div>
    @endif

</div>
@endsection