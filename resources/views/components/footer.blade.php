@php
    $footerData = App\Models\FooterTitle::with(['items' => function($query) {
        $query->active()->ordered();
    }])->active()->ordered()->get();
    $socialIcons = App\Models\Social::where('is_active', true)->orderBy('sort_order')->get();
@endphp

<footer class="bg-black text-gray-300 relative overflow-hidden">
    <!-- Futuristic Background Glow -->
    <div class="absolute inset-0 pointer-events-none opacity-30">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-sky-500/10 via-transparent to-sky-400/10"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-sky-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-sky-300/10 rounded-full blur-3xl animate-pulse delay-700"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-16 mb-16">
            @foreach ($footerData as $index => $title)
                <div class="group">
                    <!-- Desktop Title -->
                    <h3 class="text-xl font-bold text-white tracking-wide mb-8 lg:block hidden relative">
                        {{ $title->title }}
                        <span class="absolute -bottom-3 left-0 w-0 h-px bg-gradient-to-r from-sky-400 to-sky-300 rounded-full transition-all duration-700 ease-out group-hover:w-full group-hover:shadow-glow"></span>
                    </h3>

                    <!-- Mobile Accordion Toggle -->
                    <button 
                        class="lg:hidden w-full flex items-center justify-between text-xl font-bold text-white py-6 border-b border-gray-800 hover:border-sky-400 transition-all duration-500 focus:outline-none"
                        onclick="toggleFuturisticDropdown(this)"
                        data-target="footer-dropdown-{{ $index }}"
                        aria-expanded="false">
                        {{ $title->title }}
                        <svg class="w-6 h-6 text-sky-400 transition-transform duration-500 ease-out" id="chevron-{{ $index }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Links List - Always visible on desktop, collapsible on mobile -->
                    <ul class="space-y-5 text-gray-400 text-base
                               lg:block lg:space-y-5 lg:mt-0
                               mt-6 overflow-hidden transition-all duration-700 ease-out"
                        id="footer-dropdown-{{ $index }}"
                        style="max-height: 0;">
                        @foreach ($title->items as $item)
                            <li>
                                <a href="{{ $item->url }}"
                                   class="block hover:text-sky-300 transition-all duration-300 ease-out transform hover:translate-x-2 hover:shadow-neon">
                                    {{ $item->text }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <!-- Social Icons & Copyright -->
        <div class="border-t border-gray-800 pt-12">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10">
                <!-- Social Icons -->
                <div class="flex justify-center lg:justify-start items-center gap-8">
                    @foreach ($socialIcons as $social)
                        <a href="{{ $social->name_url }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group relative w-14 h-14 flex items-center justify-center rounded-2xl bg-gray-900/60 backdrop-blur-md border border-gray-800 hover:border-sky-400 text-gray-400 hover:text-sky-300 transition-all duration-500 shadow-lg hover:shadow-2xl hover:shadow-sky-400/40">
                            <i class="{{ $social->icon }} text-2xl transition-transform duration-300 group-hover:scale-110"></i>
                            <div class="absolute inset-0 rounded-2xl bg-sky-400 opacity-0 group-hover:opacity-50 blur-xl transition-opacity duration-700 animate-pulse"></div>
                        </a>
                    @endforeach
                </div>

                <!-- Copyright -->
                <div class="text-center lg:text-right">
                    <p class="text-base font-medium tracking-wider text-gray-300">
                        &copy; <span id="current-year"></span> 
                        <span class="text-white font-bold bg-gradient-to-r from-sky-400 to-sky-300 bg-clip-text text-transparent">
                            Powered by Workflow Technologies
                        </span>
                    </p>
                    <p class="text-sm text-gray-500 mt-3 opacity-80">
                        Pioneering the next era of digital innovation.
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    // Set current year
    document.getElementById('current-year').textContent = new Date().getFullYear();

    // Futuristic mobile dropdown toggle
    function toggleFuturisticDropdown(button) {
        const targetId = button.getAttribute('data-target');
        const dropdown = document.getElementById(targetId);
        const chevron = document.getElementById('chevron-' + targetId.split('-').pop());
        const isExpanded = button.getAttribute('aria-expanded') === 'true';

        if (isExpanded) {
            dropdown.style.maxHeight = '0px';
            button.setAttribute('aria-expanded', 'false');
            chevron.classList.remove('rotate-180');
        } else {
            dropdown.style.maxHeight = dropdown.scrollHeight + 40 + 'px';
            button.setAttribute('aria-expanded', 'true');
            chevron.classList.add('rotate-180');
        }

        // Close other dropdowns
        document.querySelectorAll('[id^="footer-dropdown-"]').forEach(menu => {
            if (menu.id !== targetId) {
                menu.style.maxHeight = '0px';
                const otherBtn = document.querySelector(`button[data-target="${menu.id}"]`);
                if (otherBtn) {
                    otherBtn.setAttribute('aria-expanded', 'false');
                    const otherChevron = otherBtn.querySelector('svg');
                    if (otherChevron) otherChevron.classList.remove('rotate-180');
                }
            }
        });
    }

    // On desktop: always show links, remove max-height restriction
    function updateDesktopView() {
        if (window.innerWidth >= 1024) {
            document.querySelectorAll('[id^="footer-dropdown-"]').forEach(menu => {
                menu.style.maxHeight = 'none';
                menu.classList.add('block');
            });
        }
    }

    // Run on load and resize
    window.addEventListener('load', updateDesktopView);
    window.addEventListener('resize', updateDesktopView);
</script>

<style>
    /* Ultra-smooth max-height transition (mobile only) */
    @media (max-width: 1023px) {
        [id^="footer-dropdown-"] {
            transition: max-height 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
    }

    /* Chevron smooth rotation */
    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Neon glow on hover */
    .hover\\:shadow-neon:hover {
        text-shadow: 0 0 12px rgba(14, 165, 233, 0.7);
    }

    /* Social icon glow pulse */
    .group:hover .animate-pulse {
        animation: glowPulse 1.8s ease-in-out infinite;
    }

    @keyframes glowPulse {
        0%, 100% { opacity: 0.4; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.15); }
    }

    /* Glassmorphism */
    .backdrop-blur-md {
        backdrop-filter: blur(12px);
    }
</style>