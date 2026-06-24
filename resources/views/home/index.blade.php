@extends('layouts.home')

@section('title', 'Home')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 flex items-center gap-2">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<style>
    h1 { font-family: 'Orbitron', monospace; }

    /* Animation for slide content */
    .animate-in {
        animation: fadeUp 0.8s ease forwards;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .slide-content > * {
        opacity: 0;
    }
</style>

{{-- Hero Section --}}
<section class="relative h-screen overflow-hidden">
    <!-- SLIDES WRAPPER -->
    <div class="relative w-full h-full">
       
        {{-- ================= SLIDE 1 ================= --}}
        <div class="slide absolute inset-0 transition-all duration-700 opacity-0">
            <!-- Background -->
            <div class="absolute inset-0">
                <img src="{{ asset('public/storage/uploads/pics/' . $home->background_picture) }}"
                     class="w-full h-full object-cover object-top">
                <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-black/70 to-black/60"></div>
            </div>

            <!-- Content -->
            <div class="slide-content relative z-10 h-full max-w-7xl mx-auto flex items-center px-6">
                <div class="text-white max-w-2xl space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight"> {{ $home->title1 }} </h1>
                    <h2 class="text-xl md:text-2xl text-slate-300"> {{ $home->title1_content }} </h2>
                    <p class="text-slate-400 max-w-md"> {{ $home->title1_sub_content }} </p>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <a href="{{ $home->button1_url }}"
                           class="group relative inline-flex items-center justify-center gap-3
                                  bg-white text-black px-8 py-4 rounded-2xl font-semibold
                                  overflow-hidden transition-all duration-300 hover:scale-105 active:scale-95">
                            <i class="fas fa-arrow-right"></i>
                            <span class="relative z-10">{{ $home->button1_name }}</span>
                            <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-30 blur-xl transition-all"></div>
                        </a>
                        <a href="{{ $home->button2_url }}"
                           class="group relative inline-flex items-center justify-center gap-3
                                  border border-white/50 text-white px-8 py-4 rounded-2xl font-semibold
                                  overflow-hidden transition-all duration-300 hover:scale-105 active:scale-95
                                  hover:border-sky-400 hover:shadow-xl hover:shadow-sky-400/30">
                            <i class="fas fa-play-circle"></i>
                            <span class="relative z-10">{{ $home->button2_name }}</span>
                            <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-20 blur-xl transition-all"></div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Glowing Floating Card -->
            <div class="slide-content absolute bottom-6 left-6 md:bottom-10 md:right-10 md:left-auto max-w-sm z-20">
                <div class="group relative p-6 rounded-3xl bg-gray-900/80 backdrop-blur-2xl border border-gray-600
                            hover:border-sky-400 transition-all duration-500
                            shadow-2xl hover:shadow-[0_0_40px_-5px] hover:shadow-sky-400/60">
                    <div class="absolute inset-0 rounded-3xl bg-sky-400 opacity-0 group-hover:opacity-40 blur-3xl transition-all duration-700"></div>
                    <div class="absolute inset-0 rounded-3xl bg-sky-500 opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-700 animate-pulse"></div>
                    <div class="relative z-10">
                        <h3 class="text-white font-semibold text-xl group-hover:text-sky-300 transition-colors">
                            {{ $home->title2 }}
                        </h3>
                        <p class="text-gray-300 text-sm mt-3 group-hover:text-gray-100 transition-colors">
                            {{ $home->title2_content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= SLIDE 2 ================= --}}
        <div class="slide absolute inset-0 transition-all duration-700 opacity-0">
            <!-- Background -->
            <div class="absolute inset-0">
                <img src="{{ asset('public/storage/uploads/pics/' . $home->background_picture2) }}"
                     class="w-full h-full object-cover object-top">
                <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-black/70 to-black/60"></div>
            </div>


            <!-- Content -->
            <div class="slide-content relative z-10 h-full max-w-7xl mx-auto flex items-center px-6">
                <div class="text-white max-w-2xl space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight"> {{ $home->title3 }} </h1>
                    <h2 class="text-xl md:text-2xl text-slate-300"> {{ $home->title3_content }} </h2>
                    <p class="text-slate-400 max-w-md"> {{ $home->title3_sub_content }} </p>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <a href="{{ $home->button3_url }}"
                           class="group relative inline-flex items-center justify-center gap-3
                                  bg-white text-black px-8 py-4 rounded-2xl font-semibold
                                  overflow-hidden transition-all duration-300 hover:scale-105 active:scale-95">
                            <i class="fas fa-arrow-right"></i>
                            <span class="relative z-10">{{ $home->button3_name }}</span>
                            <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-30 blur-xl transition-all"></div>
                        </a>
                        <a href="{{ $home->button4_url }}"
                           class="group relative inline-flex items-center justify-center gap-3
                                  border border-white/50 text-white px-8 py-4 rounded-2xl font-semibold
                                  overflow-hidden transition-all duration-300 hover:scale-105 active:scale-95
                                  hover:border-sky-400 hover:shadow-xl hover:shadow-sky-400/30">
                            <i class="fas fa-play-circle"></i>
                            <span class="relative z-10">{{ $home->button4_name }}</span>
                            <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-20 blur-xl transition-all"></div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Glowing Floating Card -->
            <div class="slide-content absolute bottom-6 left-6 md:bottom-10 md:right-10 md:left-auto max-w-sm z-20">
                <div class="group relative p-6 rounded-3xl bg-gray-900/80 backdrop-blur-2xl border border-gray-600
                            hover:border-sky-400 transition-all duration-500
                            shadow-2xl hover:shadow-[0_0_40px_-5px] hover:shadow-sky-400/60">
                    <div class="absolute inset-0 rounded-3xl bg-sky-400 opacity-0 group-hover:opacity-40 blur-3xl transition-all duration-700"></div>
                    <div class="absolute inset-0 rounded-3xl bg-sky-500 opacity-0 group-hover:opacity-20 blur-2xl transition-all duration-700 animate-pulse"></div>
                    <div class="relative z-10">
                        <h3 class="text-white font-semibold text-xl group-hover:text-sky-300 transition-colors">
                            {{ $home->title4 }}
                        </h3>
                        <p class="text-gray-300 text-sm mt-3 group-hover:text-gray-100 transition-colors">
                            {{ $home->title4_content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <button class="prev absolute left-6 top-1/2 -translate-y-1/2 text-white text-5xl z-30 hover:text-sky-400 transition">
        ‹
    </button>
    <button class="next absolute right-6 top-1/2 -translate-y-1/2 text-white text-5xl z-30 hover:text-sky-400 transition">
        ›
    </button>

    <!-- Dots -->
    <div class="pagination absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-30"></div>
</section>

<script>
const slides = document.querySelectorAll(".slide");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
const pagination = document.querySelector(".pagination");
let index = 0;
let autoPlay;

slides.forEach((_, i) => {
    const dot = document.createElement("div");
    dot.className = `w-3 h-3 rounded-full cursor-pointer transition-all ${i === 0 ? 'bg-white scale-110' : 'bg-gray-500'}`;
    dot.onclick = () => { index = i; showSlide(index); stopAuto(); };
    pagination.appendChild(dot);
});

const dots = pagination.children;

function animateContent(slide) {
    const contents = slide.querySelectorAll('.slide-content > *');
    contents.forEach((el, i) => {
        el.style.animationDelay = `${i * 100}ms`;
        el.classList.remove('animate-in');
        // Force reflow
        void el.offsetWidth;
        el.classList.add('animate-in');
    });
}

function showSlide(i) {
    slides.forEach((s, idx) => {
        if (idx === i) {
            s.classList.add('opacity-100');
            s.classList.remove('opacity-0');
            // Trigger animation
            setTimeout(() => animateContent(s), 100);
        } else {
            s.classList.remove('opacity-100');
            s.classList.add('opacity-0');
        }
    });

    [...dots].forEach((d, idx) => {
        d.classList.toggle("bg-white", idx === i);
        d.classList.toggle("bg-gray-500", idx !== i);
        d.classList.toggle("scale-110", idx === i);
    });
}

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

function startAuto() {
    autoPlay = setInterval(() => {
        index = (index + 1) % slides.length;
        showSlide(index);
    }, 6500);
}

function stopAuto() {
    clearInterval(autoPlay);
}

startAuto();
showSlide(0);   // Start with first slide animated
</script>


{{-- Quick Board Selection Teaser --}}
<section class="py-16 bg-white">

    <div class="max-w-6xl mx-auto px-6">

        <!-- Header -->
        <div
            class="text-center mb-12"
            data-aos="fade-up"
            data-aos-duration="1000"
        >

            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
               Apply with Confidance
            </h2>

            <p class="text-gray-600 mt-3 text-lg">
                Start by selecting Making an accoun
            </p>

        </div>

  


        <!-- View All Button -->
        <div
            class="text-center mt-12"
            data-aos="fade-up"
            data-aos-duration="1000"
        >

            <a href="{{ $home->button1_url }}"
               class="group inline-flex items-center gap-3 border border-black/40 text-indigo-600 
                      px-8 py-4 rounded-2xl font-medium hover:scale-105 active:scale-95 
                      transition-all duration-300 hover:border-sky-400 hover:shadow-xl 
                      hover:shadow-sky-400/30 relative overflow-hidden">

                <span class="relative z-10">
                    View 
                </span>

                <span class="text-2xl transition-transform group-hover:translate-x-1">
                    →
                </span>

                <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-10 blur-xl transition-all"></div>

            </a>

        </div>

    </div>

</section>

<!-- AOS Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- AOS INIT -->
<script>

    document.addEventListener('DOMContentLoaded', function () {

        AOS.init({
            duration: 1000,
            once: false,
            mirror: true
        });

    });

</script>




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


  

 <!-- this gets (i dont even remeber) -->

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




        <div class="text-center mt-12">
            <a href="{{$home->button1_url}}" 
               class="inline-block bg-indigo-600 text-white px-10 py-4 rounded-3xl font-semibold hover:bg-indigo-700 transition">
                Browse All Resources
            </a>
            
        </div>
    </div>
</section>

@endsection
