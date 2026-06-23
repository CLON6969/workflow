@extends('layouts.home')

@section('title', 'Home')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl z-50">
        {{ session('success') }}
    </div>
@endif

<style>
    h1 {
    font-family: 'Orbitron', monospace;}
</style>

{{-- Hero Section --}}
<section class="relative h-screen overflow-hidden">

  <!-- SLIDES WRAPPER -->
  <div class="relative w-full h-full">

    {{-- ================= SLIDE 1 ================= --}}
    <div class="slide absolute inset-0 transition-all duration-700 opacity-100">

      <!-- BACKGROUND -->
      <div class="absolute inset-0">
        <img src="{{ asset('public/storage/uploads/pics/' . $home->background_picture) }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/70"></div>
      </div>

      <!-- CONTENT -->
      <div class="relative z-10 h-full max-w-7xl mx-auto flex items-center px-6">

        <div class="text-white max-w-2xl space-y-6">

          <h1 data-aos="fade-up" class="text-3xl md:text-4xl font-bold leading-tight">
            {{ $home->title1 }}
          </h1>

          <h2 data-aos="fade-up" data-aos-delay="150"
              class="text-xl text-slate-300">
            {{ $home->title1_content }}
          </h2>

          <p data-aos="fade-up" data-aos-delay="300"
             class="text-slate-400">
            {{ $home->title1_sub_content }}
          </p>

          <!-- BUTTONS -->
<!-- BUTTONS (FIXED + GUARANTEED HOVER + GLOW) -->
<div data-aos="fade-up" data-aos-delay="450"
     class="flex flex-col sm:flex-row gap-4 pt-6 relative z-30 pointer-events-auto">

  <!-- PRIMARY BUTTON -->
  <a href="{{$home->button1_url}}"
     class="group relative inline-flex justify-center items-center
            bg-white text-black px-6 py-3 rounded-2xl font-semibold
            overflow-hidden w-full sm:w-auto
            transition-all duration-300
            hover:scale-105 active:scale-95">

    <span class="relative z-10 transition-colors duration-300 group-hover:text-black">
      {{$home->button1_name}}
    </span>

    <!-- GLOW EFFECT -->
    <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-40 blur-2xl transition-all duration-500"></div>

  </a>

  <!-- SECONDARY BUTTON -->
  <a href="{{$home->button2_url}}"
     class="group relative inline-flex justify-center items-center
            border border-white/40 text-white px-6 py-3 rounded-2xl
            overflow-hidden w-full sm:w-auto
            transition-all duration-300
            hover:scale-105 active:scale-95
            hover:border-sky-400 hover:shadow-lg hover:shadow-sky-400/40">

    <span class="relative z-10 transition-colors duration-300 group-hover:text-sky-300">
      {{$home->button2_name}}
    </span>

    <!-- GLOW EFFECT -->
    <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-20 blur-xl transition-all duration-500"></div>

  </a>

</div>

        </div>
      </div>

      <!-- FLOATING CARD -->
      <div data-aos="zoom-in"
           data-aos-delay="600"
           class="absolute bottom-4 left-4 right-4 md:bottom-10 md:right-10 md:left-auto max-w-sm z-20">

        <div class="group relative p-5 rounded-2xl
                    bg-gray-900/60 backdrop-blur-md
                    border border-gray-800
                    hover:border-sky-400
                    shadow-lg hover:shadow-2xl hover:shadow-sky-400/40
                    transition-all duration-500">

          <div class="absolute inset-0 rounded-2xl
                      bg-sky-400 opacity-0
                      group-hover:opacity-50
                      blur-xl transition-opacity duration-700 animate-pulse"></div>

          <div class="relative z-10">
            <h3 class="text-white font-semibold text-lg group-hover:text-sky-300 transition">
              {{$home->title2}}
            </h3>

            <p class="text-gray-300 text-sm mt-2 group-hover:text-gray-200 transition">
              {{$home->title2_content}}
            </p>
          </div>

        </div>
      </div>

    </div>

    {{-- ================= SLIDE 2 ================= --}}
    <div class="slide absolute inset-0 transition-all duration-700 opacity-0">

      <!-- BACKGROUND -->
      <div class="absolute inset-0">
        <img src="{{ asset('public/storage/uploads/pics/' . $home->background_picture2) }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/70"></div>
      </div>

      <!-- CONTENT -->
      <div class="relative z-10 h-full max-w-7xl mx-auto flex items-center px-6">

        <div class="text-white max-w-2xl space-y-6">

          <h1 data-aos="fade-up" class="text-3xl md:text-4xl font-bold">
            {{ $home->title3 }}
          </h1>

          <h2 data-aos="fade-up" data-aos-delay="150"
              class="text-xl text-slate-300">
            {{ $home->title3_content }}
          </h2>

          <p data-aos="fade-up" data-aos-delay="300"
             class="text-slate-400">
            {{ $home->title3_sub_content }}
          </p>

          <!-- BUTTONS -->
          <div data-aos="fade-up" data-aos-delay="450"
               class="flex flex-col sm:flex-row gap-4 pt-4">

            <a href="{{$home->button3_url}}"
               class="group bg-white text-black px-6 py-3 rounded-2xl font-semibold
                      hover:scale-105 active:scale-95 transition w-full sm:w-auto text-center relative overflow-hidden">

              <span class="relative z-10">{{$home->button3_name}}</span>
              <div class="absolute inset-0 bg-sky-200 opacity-0 group-hover:opacity-30 blur-xl transition"></div>
            </a>

            <a href="{{$home->button4_url}}"
               class="group border border-white/40 text-white px-6 py-3 rounded-2xl
                      hover:scale-105 active:scale-95 transition
                      hover:border-sky-400 hover:shadow-lg hover:shadow-sky-400/30
                      w-full sm:w-auto text-center relative overflow-hidden">

              <span class="relative z-10">{{$home->button4_name}}</span>
              <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-20 blur-xl transition"></div>
            </a>

          </div>

        </div>
      </div>

      <!-- FLOATING CARD -->
      <div data-aos="zoom-in"
           data-aos-delay="600"
           class="absolute bottom-4 left-4 right-4 md:bottom-10 md:right-10 md:left-auto max-w-sm z-20">

        <div class="group relative p-5 rounded-2xl
                    bg-gray-900/60 backdrop-blur-md
                    border border-gray-800
                    hover:border-sky-400
                    shadow-lg hover:shadow-2xl hover:shadow-sky-400/40
                    transition-all duration-500">

          <div class="absolute inset-0 rounded-2xl
                      bg-sky-400 opacity-0
                      group-hover:opacity-50
                      blur-xl transition-opacity duration-700 animate-pulse"></div>

          <div class="relative z-10">
            <h3 class="text-white font-semibold text-lg group-hover:text-sky-300 transition">
              {{$home->title4}}
            </h3>

            <p class="text-gray-300 text-sm mt-2 group-hover:text-gray-200 transition">
              {{$home->title4_content}}
            </p>
          </div>

        </div>
      </div>

    </div>

  </div>

  <!-- NAV -->
  <button class="prev absolute left-5 top-1/2 -translate-y-1/2 text-white text-3xl z-20 hover:text-sky-400">
    ‹
  </button>

  <button class="next absolute right-5 top-1/2 -translate-y-1/2 text-white text-3xl z-20 hover:text-sky-400">
    ›
  </button>

  <!-- DOTS -->
  <div class="pagination absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20"></div>

</section>

{{-- YOUR ORIGINAL JS (UNCHANGED) --}}
<script>
const slides = document.querySelectorAll(".slide");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
const pagination = document.querySelector(".pagination");

let index = 0;
let autoPlay;

// Create dots
slides.forEach((_, i) => {
  const dot = document.createElement("div");
  dot.className = "w-3 h-3 rounded-full bg-gray-500 cursor-pointer";
  if(i === 0) dot.classList.add("bg-white");

  dot.onclick = () => {
    index = i;
    showSlide(index);
    stopAuto();
  };

  pagination.appendChild(dot);
});

const dots = pagination.children;

// Show slide
function showSlide(i){
  slides.forEach((s, idx) => {
    s.classList.toggle("opacity-100", idx === i);
    s.classList.toggle("translate-x-0", idx === i);

    s.classList.toggle("opacity-0", idx !== i);
    s.classList.toggle("translate-x-10", idx !== i);
  });

  [...dots].forEach((d, idx) => {
    d.classList.toggle("bg-white", idx === i);
    d.classList.toggle("bg-gray-500", idx !== i);
  });
}

// Navigation
nextBtn.onclick = () => {
  index = (index + 1) % slides.length;
  showSlide(index);
  stopAuto();
};

prevBtn.onclick = () => {
  index = (index - 1 + slides.length) % slides.length;
  showSlide(index);
  stopAuto();
};

// Auto-play
function startAuto(){
  autoPlay = setInterval(() => {
    index = (index + 1) % slides.length;
    showSlide(index);
  }, 6000);
}

function stopAuto(){
  clearInterval(autoPlay);
}

startAuto();
showSlide(index);
</script>


{{-- Quick Board Selection Teaser --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900">Choose Your Examination Board</h2>
            <p class="text-gray-600 mt-3">Start by selecting your board to access relevant materials</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($examBoards->take(8) as $board)
                <a href="{{ route('select.year', $board) }}" 
                   class="bg-white border border-gray-200 hover:border-indigo-500 rounded-3xl p-8 text-center transition hover:shadow-lg">
                    <div class="text-5xl mb-4">
                        @if($board->name === 'ECZ') <i class="fa-brands fa-galactic-republic"></i>
                        @elseif($board->name === 'TEVETA') <i class="fa-brands fa-old-republic"></i>
                         @elseif($board->name === 'UNZA') <i class="fa-brands fa-staylinked"></i>
                          @elseif($board->name === 'ZICA') <i class="fa-brands fa-phoenix-squadron"></i>
                        @elseif($board->name === 'Cambridge') <i class="fa-brands fa-vsco"></i>

                        
                        @else 🎓 @endif
                    </div>
                    <h3 class="font-semibold text-lg">{{ $board->name }}</h3>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-10">

             <a href="{{$home->button1_url}}"
               class="group border border-black/40 text-indigo-600 px-8 py-3 rounded-2xl
                      hover:scale-105 active:scale-95 transition
                      hover:border-sky-400 hover:shadow-lg hover:shadow-sky-400/30
                      w-full sm:w-auto text-center relative overflow-hidden">

              <span class="relative z-10">View All Examination Boards </span> <span class="text-xl">→</span>
              <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-20 blur-xl transition"></div>
            </a>
        </div>
    </div>
</section>



<div class="opportunities-container">
  @foreach($opportunities as $index => $opportunity)
    <section class="opportunity-card" onclick="openOverlay('overlay-{{ $opportunity->id }}')">
      <img src="{{ asset('/public/storage/opportunities/' . $opportunity->image) }}" class="bg" alt="background picture">
      <div class="overlay">
        <div class="content">
          <h2>{{ $opportunity->title }}</h2>
          <p>{{ $opportunity->summary }}</p>
          <a href="#" class="read-more">Read more</a>
        </div>
      </div>
    </section>
  @endforeach
</div>

@foreach($opportunities as $opportunity)
  <div id="overlay-{{ $opportunity->id }}" class="fullscreen-overlay">
    <div class="overlay-inner" style="background-image: url('{{ asset('/public/storage/opportunities/' . $opportunity->image) }}');">
      <button onclick="closeOverlay()" class="close-btn">&times;</button>
      <div class="overlay-text">
        <h2>{{ $opportunity->title }}</h2>
        <p>{{ $opportunity->overlay_intro }}</p>
        <div class="more-content">
          <p>{{ $opportunity->overlay_details }}</p>
        </div>
        <button class="expand-btn" onclick="event.stopPropagation(); toggleMore(this)">Read more</button>
      </div>
    </div>
  </div>
@endforeach


 <!-- this is for full screen overlay when clicked -->
<script>
let scrollPosition = 0;

function openOverlay(id) {
  // Save current scroll position
  scrollPosition = window.scrollY || document.documentElement.scrollTop;

  // Lock scrolling by fixing the body
  document.body.style.position = 'fixed';
  document.body.style.top = `-${scrollPosition}px`;
  document.body.style.width = '100%';

  // Show overlay
  document.getElementById(id).classList.add('active');
}

function closeOverlay() {
  document.querySelectorAll('.fullscreen-overlay').forEach(el => el.classList.remove('active'));

  // Restore body scroll
  document.body.style.position = '';
  document.body.style.top = '';
  document.body.style.width = '';
  window.scrollTo(0, scrollPosition); // Return to saved scroll position
}

function toggleMore(button) {
  const moreContent = button.previousElementSibling;
  moreContent.classList.toggle('active');
  button.textContent = moreContent.classList.contains('active') ? 'Show less' : 'Read more';
}
</script>


  

 <!-- this gets -->

 <style>
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>


{{-- Recent Resources --}}
<section class="py-20 bg-black">
    <div class="max-w-7xl mx-auto px-6">
       {{-- <h2 class="text-3xl font-bold text-center mb-12 text-black">Recently Added Resources</h2> --}}



        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($resources as $resource)
                <div class="group bg-white border border-gray-200 rounded-3xl overflow-hidden hover:border-indigo-300 transition">
                    <div class="h-48 bg-gradient-to-br from-slate-100 to-indigo-50 flex items-center justify-center">
                        <span class="text-6xl">📄</span>
                    </div>
                    <div class="p-6">
                        <h4 class="font-medium line-clamp-2 mb-3 group-hover:text-indigo-600 transition">
                            {{ $resource->title }}
                        </h4>
                        <p class="text-sm text-gray-500 mb-4">
                            {{ $resource->examBoard->name }} • {{ $resource->year }}
                        </p>
                        <a href="{{ route('resources.download', $resource) }}" 
                           class="text-indigo-600 font-medium text-sm hover:underline">
                            Download →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{$home->button1_url}}" 
               class="inline-block bg-indigo-600 text-white px-10 py-4 rounded-3xl font-semibold hover:bg-indigo-700 transition">
                Browse All Resources
            </a>
            
        </div>
    </div>
</section>

@endsection
