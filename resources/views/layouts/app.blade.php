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
<header class="fixed top-0 left-0 w-full bg-[#34113F] z-50">
  <div class="px-2 sm:px-4 py-3">
   <nav id="menu" class="w-full z-50 opacity-0 pointer-events-none transition-all duration-300">
  <!-- carril scrolleable -->
  <div class="w-full overflow-x-auto overscroll-x-contain px-2 [-webkit-overflow-scrolling:touch]">
    <!-- contenido -->
    <ul class="flex w-max gap-3 sm:w-full sm:justify-center max-w-6xl mx-auto py-2">
      <li class="shrink-0">
        <a href="#home"
           class="min-h-[44px] flex items-center justify-center
                  px-3 sm:px-4 py-2 rounded border font-bold
                  text-sm sm:text-lg whitespace-nowrap leading-none hover:underline">
          Espejito, espejito
        </a>
      </li>

      <li class="shrink-0">
        <a href="{{ route('hitos.index') }}" class="min-h-[44px] flex items-center justify-center
           px-3 sm:px-4 py-2 rounded border font-bold text-sm sm:text-lg whitespace-nowrap leading-none hover:underline">
          Entramado
        </a>
      </li>

      <li class="shrink-0">
        <a href="{{ route('entrevistas.index') }}" class="min-h-[44px] flex items-center justify-center
           px-3 sm:px-4 py-2 rounded border font-bold text-sm sm:text-lg whitespace-nowrap leading-none hover:underline">
          Salón de espejos
        </a>
      </li>

      <li class="shrink-0">
        <a href="{{ route('espejo.paint') }}" class="min-h-[44px] flex items-center justify-center
           px-3 sm:px-4 py-2 rounded border font-bold text-sm sm:text-lg whitespace-nowrap leading-none hover:underline">
          Tocador
        </a>
      </li>

      <li class="shrink-0">
        <a href="{{ route('detras.many', ['ids' => '11,12,13']) }}" class="min-h-[44px] flex items-center justify-center
           px-3 sm:px-4 py-2 rounded border font-bold text-sm sm:text-lg whitespace-nowrap leading-none hover:underline">
          Tejedoras
        </a>
      </li>
    </ul>
  </div>
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
  class="fixed inset-0 z-[9999] pointer-events-none flex items-center justify-center">

<div id="float-card"
     class="max-w-[780px] w-[min(92vw,780px)]
            rounded-2xl shadow-2xl border bg-[#f8f8fa]/90 backdrop-blur
            p-4 pointer-events-auto
            max-h-[60vh] overflow-y-auto">
  <div class="flex items-center justify-between mb-2">
    <div class="text-[10px] uppercase tracking-wide text-slate-500"></div>

    <div class="flex gap-1">
      <button
        class="text-xs px-2 py-1 rounded border"
        :class="$store.float.mode === 'def' ? 'bg-slate-900 text-[#f8f8fa]' : 'bg-[#f8f8fa] text-slate-700'"
        @click="$store.float.setMode('def')">
        Definición
      </button>
      <button
        class="text-xs px-2 py-1 rounded border"
        :class="$store.float.mode === 'ref' ? 'bg-slate-900 text-[#f8f8fa]' : 'bg-[#f8f8fa] text-slate-700'"
        @click="$store.float.setMode('ref')">
        Referencia
      </button>
    </div>
  </div>

  <div class="text-sm text-slate-800 whitespace-pre-wrap"
       x-text="$store.float ? $store.float.text : ''"></div>

  <div class="mt-2 flex justify-end">
    <button class="text-xs underline text-slate-600 hover:text-slate-900"
            @click="$store.float && $store.float.close()">Cerrar o con ESC</button>
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
<script>
document.addEventListener('alpine:init', () => {

  Alpine.store('float', {

    show: false,
    text: '',
    def: '',
    ref: '',
    mode: 'def',
    x: 0, y: 0,

    openFor(el, palabra) {
      const word = (palabra ?? '').toString().trim();
      this.mode = 'def';
      this.text = word ? 'Cargando…' : 'Sin palabra. Demo del flotante.';
      this.show = true;

      if (!word) return;

      const ep = (window.DIC_EP ?? '/diccionario/buscar');
      fetch(`${ep}?palabra=${encodeURIComponent(word)}`)
        .then(r => r.ok ? r.json() : Promise.reject(new Error('HTTP '+r.status)))
        .then(d => {
          if (d && d.found) {
            this.def = d.definicion || 'Sin definición disponible.';
            this.ref = d.ejemplo    || '';
          } else {
            this.def = `No encontramos la definición de “${word}”.`;
            this.ref = '';
          }
          this.applyMode();
        })
        .catch(err => {
          console.warn('Diccionario error:', err);
          this.def = 'Error consultando el diccionario.';
          this.ref = '';
          this.applyMode();
        });
    },

    setMode(m) {
      this.mode = (m === 'ref') ? 'ref' : 'def';
      this.applyMode();
    },

    applyMode() {
      this.text = (this.mode === 'ref')
        ? (this.ref && this.ref.trim() !== '' ? this.ref : 'Sin referencia disponible.')
        : this.def;
    },


    positionNear(el) {
      return;
    },

    close() {
      this.show = false;
      this.text = '';
      this.def  = '';
      this.ref  = '';
      this.mode = 'def';
    }
  });

});

// Cerrar con ESC
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && window.Alpine?.store('float')) {
    Alpine.store('float').close();
  }

});

//========ANIMACION TEXTOS ==================

document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('.reveal-scroll');

    if (!('IntersectionObserver' in window)) {

        elements.forEach(el => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                obs.unobserve(entry.target); // solo una vez por elemento
            }
        });
    }, {
        threshold: 0.2  // se activa cuando ~20% del elemento es visible
    });

    elements.forEach(el => observer.observe(el));
});

</script>

  <!-- =================================================================== -->
  <div x-data @keydown.escape.window="$store.float.close()"></div>
</body>
</html>
