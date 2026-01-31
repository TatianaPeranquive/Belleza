<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  @vite('resources/css/app.css')
<!-- <script>
  window.DIC_EP = @json(secure_url('/diccionario/buscar'));
</script> -->

  <!-- AlpineJS -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    html, body { margin:0; padding:0; }
    body { overflow-x:hidden; }
    body { cursor: url("{{ asset('micursor.cur') }}") 16 16, auto; }
    a, button { cursor: url("{{ asset('micursor.cur') }}") 16 16, pointer; }
    [x-cloak]{display:none!important}

@keyframes hitoGlowPulse {
  0% {
    box-shadow: 0 0 18px 6px rgba(190, 183, 223, 0.55);
    transform: translateY(0) scale(1.03);
  }
  50% {
    box-shadow: 0 0 55px 22px rgba(190, 183, 223, 0.95);
    transform: translateY(-1px) scale(1.07);
  }
  100% {
    box-shadow: 0 0 18px 6px rgba(190, 183, 223, 0.55);
    transform: translateY(0) scale(1.03);
  }
}

.hitoBtn.is-selected {
  animation: hitoGlowPulse 1.4s ease-in-out infinite;
}


  </style>
</head>
<body class="{{ $theme === 'dark' ? 'bg-[#111827] text-[#F9FAFB]' : 'bg-[#f8f8fa] text-[#111827]' }}">

<header
    x-data="{ open: false }"
    class="fixed top-0 left-0 w-full z-50
           {{ $theme === 'dark'
                ? 'bg-[#34113F] text-[#f8f8fa]'
                : 'bg-[#f8f8fa] text-[#34113F] border-b border-[#34113F]/20' }}"
>
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            {{-- Logo / título (ajusta el texto o déjalo vacío) --}}
            <div class="flex items-center gap-2">
                <span class="font-bold tracking-wide">
                    Espejito
                </span>
            </div>

            {{-- Menú DESKTOP --}}
            <nav class="hidden md:flex gap-4">
                @php
                    $linkBase = 'block px-4 py-2 rounded-lg border border-current font-bold text-sm md:text-base text-center transition hover:bg-white/10 hover:bg-opacity-20';
                @endphp

                <a href="#home" class="{{ $linkBase }}">
                    Espeo, espejito
                </a>
                <a href="{{ route('hitos.index') }}" class="{{ $linkBase }}">
                    Entramado
                </a>
                <a href="{{ route('entrevistas.index') }}" class="{{ $linkBase }}">
                    Salón de espejos
                </a>
                <a href="{{ route('espejo.paint') }}" class="{{ $linkBase }}">
                    Tocador
                </a>
                <a href="{{ route('detras.many', ['ids' => '11,12,13']) }}" class="{{ $linkBase }}">
                    Tejedoras
                </a>
            </nav>

            {{-- Botón hamburguesa (solo móvil) --}}
            <button
                class="md:hidden inline-flex items-center justify-center p-2 rounded-lg border border-current"
                @click="open = !open"
                aria-label="Abrir menú"
            >
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Menú MÓVIL --}}
        <nav
            class="md:hidden mt-1 pb-2"
            x-show="open"
            x-transition.opacity.duration.150ms
        >
            <ul class="flex flex-col gap-2">
                <li>
                    <a href="#home"
                       class="block w-full text-center px-4 py-2 rounded-lg border border-current font-bold text-sm hover:bg-white/10 hover:bg-opacity-20">
                       Espejito, espejito
                    </a>
                </li>
                <li>
                    <a href="{{ route('hitos.index') }}"
                       class="block w-full text-center px-4 py-2 rounded-lg border border-current font-bold text-sm hover:bg-white/10 hover:bg-opacity-20">
                       Entramado
                    </a>
                </li>
                <li>
                    <a href="{{ route('entrevistas.index') }}"
                       class="block w-full text-center px-4 py-2 rounded-lg border border-current font-bold text-sm hover:bg-white/10 hover:bg-opacity-20">
                       Salón de espejos
                    </a>
                </li>
                <li>
                    <a href="{{ route('espejo.paint') }}"
                       class="block w-full text-center px-4 py-2 rounded-lg border border-current font-bold text-sm hover:bg-white/10 hover:bg-opacity-20">
                       Tocador
                    </a>
                </li>
                <li>
                    <a href="{{ route('detras.many', ['ids' => '11,12,13']) }}"
                       class="block w-full text-center px-4 py-2 rounded-lg border border-current font-bold text-sm hover:bg-white/10 hover:bg-opacity-20">
                       Tejedoras
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>


  <main class="min-h-screen pt-16">
    @yield('content')
  </main>

  <!-- ===================== PORTAL FLOTA ================================== -->
<div
  id="float-holder"
  x-data
  x-show="$store.float && $store.float.show"
  x-transition.opacity.duration.120ms
  class="fixed inset-0 z-[9999] pointer-events-none"
  style="left:0; top:0;"
>
  <div
    id="float-card"
    class="absolute pointer-events-auto max-w-[420px] w-[min(92vw,420px)] rounded-2xl shadow-2xl border bg-white/90 backdrop-blur p-3"
    style="will-change: transform;"
  >
    <div class="flex items-center justify-between mb-2">
      <div class="text-[10px] uppercase tracking-wide text-slate-500">Diccionario</div>

      <div class="flex gap-1">
        <button
          class="text-xs px-2 py-1 rounded border"
          :class="$store.float.mode === 'def' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
          @click="$store.float.setMode('def')"
        >Definición</button>

        <button
          class="text-xs px-2 py-1 rounded border"
          :class="$store.float.mode === 'ref' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
          @click="$store.float.setMode('ref')"
          :disabled="!$store.float.ref || $store.float.ref.trim()===''"
        >Referencia</button>
      </div>
    </div>

    <div class="text-sm text-slate-800 whitespace-pre-wrap"
         x-text="$store.float.text"></div>

    <div class="mt-2 flex justify-end">
      <button class="text-xs underline text-slate-600 hover:text-slate-900"
              @click="$store.float.close()">Cerrar</button>
    </div>
  </div>
</div>

  <!-- ===================================================================== -->

  <!-- GSAP (si lo usas) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

  <!-- Scripts varios seguros (no fallan si no existen los IDs) -->
  <script>
    (function(){
      const menuButton = document.getElementById('menuButton');
      const menuPanel  = document.getElementById('menuPanel');
      let menuOpen = false;
      if (menuButton && menuPanel) {
        menuButton.addEventListener('click', () => {
          if (!menuOpen) {
            menuPanel.classList.remove('hidden');
            gsap.fromTo(menuPanel, { y: -100, opacity: 0 }, { y: 0, opacity: 1, duration: 0.5 });
          } else {
            gsap.to(menuPanel, { y: -100, opacity: 0, duration: 0.5, onComplete: () => {
              menuPanel.classList.add('hidden');
            }});
          }
          menuOpen = !menuOpen;
        });
      }

      const playBtn  = document.getElementById('playBtn');
      const pauseBtn = document.getElementById('pauseBtn');
      if (playBtn && pauseBtn) {
        const audio = new Audio('{{ asset("storage/audio/audio1.mp3") }}');
        playBtn.addEventListener('click', () => audio.play());
        pauseBtn.addEventListener('click', () => audio.pause());
      }
    })();
  </script>

  <!-- ============= Store Alpine: flotante diccionario =================== -->
<div
  id="float-holder"
  x-data
  x-show="$store.float && $store.float.show"
  x-transition.opacity.duration.120ms
  class="fixed inset-0 z-[9999] pointer-events-none"
  style="left:0; top:0;"
>
  <div
    id="float-card"
    class="absolute pointer-events-auto max-w-[420px] w-[min(92vw,420px)] rounded-2xl shadow-2xl border bg-white/90 backdrop-blur p-3"
    style="will-change: transform;"
  >
    <div class="flex items-center justify-between mb-2">
      <div class="text-[10px] uppercase tracking-wide text-slate-500">Diccionario</div>

      <div class="flex gap-1">
        <button
          class="text-xs px-2 py-1 rounded border"
          :class="$store.float.mode === 'def' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
          @click="$store.float.setMode('def')"
        >Definición</button>

        <button
          class="text-xs px-2 py-1 rounded border"
          :class="$store.float.mode === 'ref' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
          @click="$store.float.setMode('ref')"
          :disabled="!$store.float.ref || $store.float.ref.trim()===''"
        >Referencia</button>
      </div>
    </div>

    <div class="text-sm text-slate-800 whitespace-pre-wrap"
         x-text="$store.float.text"></div>

    <div class="mt-2 flex justify-end">
      <button class="text-xs underline text-slate-600 hover:text-slate-900"
              @click="$store.float.close()">Cerrar</button>
    </div>
  </div>
</div>


  <!-- =================================================================== -->
  <div x-data @keydown.escape.window="$store.float.close()"></div>
</body>
</html>
