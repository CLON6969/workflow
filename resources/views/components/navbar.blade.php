@php 
    $navItems = App\Models\Nav1::with('children')
        ->whereNull('parent_id')
        ->get();
    $logo = App\Models\Logo::first();
@endphp

<style>
    .nav a, .nav button {
        font-family: 'Orbitron', sans-serif;
        font-weight: bold;
    }

    /* Light mode - when background is light */
    .nav-light a, 
    .nav-light button {
        color: #111827 !important;
    }
    .nav-light a:hover, 
    .nav-light button:hover {
        color: #1e40af !important;
    }

    /* Dark mode - when background is dark/image (default) */
    .nav-dark a, 
    .nav-dark button {
        color: white !important;
    }
    .nav-dark a:hover, 
    .nav-dark button:hover {
        color: #1e40af !important;
    }
</style>

<script src="//unpkg.com/alpinejs" defer></script>

<nav id="main-nav" class="bg-blue border-b border-transparent fixed top-0 w-full z-50 nav nav-dark">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex items-center justify-between h-14">

            {{-- Logo --}}
            <div>
                <a href="{{ url($logo->home_url ?? '/') }}" class="flex items-center">
                    @if($logo && $logo->picture)
                        <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture) }}" 
                             alt="Logo" class="h-10 w-auto drop-shadow-md">
                    @else
                        <img src="{{ asset('/public/uploads/default.png') }}" 
                             alt="Logo" class="h-10 w-auto drop-shadow-md">
                    @endif
                </a>
            </div>

            {{-- Desktop Menu --}}
            <ul class="hidden md:flex items-center space-x-8 font-medium">
                @foreach ($navItems as $item)
                    <li x-data="{ open: false }" class="relative group">
                        @if($item->children->count())
                            <button 
                                @click="open = !open" 
                                @click.outside="open = false"
                                class="flex items-center space-x-1 transition-colors duration-200">
                                <span>{{ $item->name }}</span>
                                <svg class="w-4 h-4 mt-0.5 transition-transform duration-200" 
                                     :class="{'rotate-180': open}" 
                                     fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" x-transition 
                                 class="absolute left-0 mt-3 w-52 bg-gradient-to-br from-zinc-950/75 via-slate-950/60 to-indigo-950/10 rounded-xl shadow-xl py-2 z-50">
                                @foreach ($item->children as $child)
                                    <a href="{{ url($child->name_url) }}" 
                                       class="block px-5 py-2.5 text-sm text-black hover:bg-black/10 hover:text-black transition">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ url($item->name_url) }}" 
                               class="transition-colors duration-200">
                                {{ $item->name }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>

            {{-- Mobile Hamburger --}}
            <div class="md:hidden" x-data="{ mobileOpen: false }">
                <button @click="mobileOpen = !mobileOpen" 
                        class="text-3xl transition-colors">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Mobile Menu -->
                <div x-show="mobileOpen" x-transition 
                     class="absolute top-14 left-0 w-full bg-gradient-to-br from-zinc-950/75 via-slate-950/60 to-indigo-950/10 shadow-xl border-t">
                    <ul class="flex flex-col px-6 py-6 space-y-5 text-lg">
                        @foreach ($navItems as $item)
                            <li x-data="{ open: false }" class="w-full">
                                @if($item->children->count())
                                    <button @click="open = !open" 
                                            class="flex justify-between w-full items-center text-gray-800 font-medium">
                                        <span>{{ $item->name }}</span>
                                        <svg class="w-5 h-5 transition-transform" 
                                             :class="{'rotate-180': open}" 
                                             fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="ml-6 mt-3 space-y-3">
                                        @foreach ($item->children as $child)
                                            <a href="{{ url($child->name_url) }}" 
                                               class="block text-gray-600 hover:text-blue-700">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <a href="{{ url($item->name_url) }}" 
                                       class="block text-gray-800 hover:text-blue-700">
                                        {{ $item->name }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</nav>

<script>
    // ============= Smart Color Adaptation =============
    const nav = document.getElementById('main-nav');

    function updateNavColor() {
        // Look for hero section with data-nav attribute
        const hero = document.querySelector('[data-nav]');
        
        if (hero) {
            const mode = hero.getAttribute('data-nav'); // "dark" or "light"
            
            if (mode === "light") {
                nav.classList.remove('nav-dark');
                nav.classList.add('nav-light');
            } else {
                nav.classList.remove('nav-light');
                nav.classList.add('nav-dark');
            }
        }
    }

    // Run when page loads
    window.addEventListener('load', updateNavColor);
</script>