<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  @vite('resources/css/app.css')
<script>
  window.DIC_EP = @json(url('/diccionario/buscar'));
</script>

  <!-- AlpineJS -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    html, body { margin:0; padding:0; }
    body { overflow-x:hidden; }
    body { cursor: url("{{ asset('micursor.cur') }}") 16 16, auto; }
    a, button { cursor: url("{{ asset('micursor.cur') }}") 16 16, pointer; }
    [x-cloak]{display:none!important}
  </style>
</head>
<body class="{{ $theme === 'dark' ? 'bg-[#111827] text-[#F9FAFB]' : 'bg-white text-[#111827]' }}">

  <header class="fixed top-0 left-0 w-full bg-black z-50">
    <div class="flex justify-between items-center p-4 text-white">
      <div class="font-bold text-lg"></div>
      <div class="flex justify-between items-center p-4 text-white"></div>
      <nav id="menu" class="fixed top-0 left-0 w-full z-50 opacity-0 pointer-events-none transition-all duration-300">
        <ul class="flex justify-center gap-4 w-full max-w-6xl mx-auto">
          <li class="flex-1">
            <a href="#home" class="block w-full text-center px-4 py-2 rounded border font-bold text-lg hover:underline">Espejito, espejito</a>
          </li>
          <li class="flex-1">
            <a href="#work" class="block w-full text-center px-4 py-2 rounded border font-bold text-lg hover:underline">Entramado</a>
          </li>
          <li class="flex-1">
            <a href="{{ route('entrevistas.index') }}" class="block w-full text-center px-4 py-2 rounded border font-bold text-lg hover:underline">Salón de espejos</a>
          </li>
          <li class="flex-1">
            <a href="{{ route('espejo.paint') }}" class="block w-full text-center px-4 py-2 rounded border font-bold text-lg hover:underline">Dentro del espejo</a>
          </li>
          <li class="flex-1">
            <a href="{{ route('diccionario.buscar', 'palabra') }}" class="block w-full text-center px-4 py-2 rounded border font-bold text-lg hover:underline">Diccionario</a>
          </li>
          <li class="flex-1">
            <a href="{{ route('detras.many', ['ids' => '11,12']) }}" class="block w-full text-center px-4 py-2 rounded border font-bold text-lg hover:underline">Detrás del espejo</a>
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
    style="position: fixed; left: 0; top: 0; display:none;"
    class="z-[9999] pointer-events-none"
  >
    <div id="float-card"
      class="max-w-[360px] w-[min(92vw,360px)] rounded-2xl shadow-2xl border bg-white/90 backdrop-blur p-3 pointer-events-auto">
      <div class="text-[10px] uppercase tracking-wide text-slate-500 mb-1">Definición</div>
      <div class="text-sm text-slate-800 whitespace-pre-wrap"
           x-text="$store.float ? $store.float.text : ''"></div>
      <div class="mt-2 flex justify-end">
        <button class="text-xs underline text-slate-600 hover:text-slate-900"
                @click="$store.float && $store.float.close()">Cerrar</button>
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
        x: 0, y: 0,

        openFor(el, palabra) {
          const word = (palabra ?? '').toString().trim();
          if (!word) {
            this.text = 'Sin palabra. Demo del flotante.';
            this.positionNear(el);
            this.show = true;
            return;
          }

        fetch(`${window.DIC_EP}?palabra=${encodeURIComponent(word)}`)
          //fetch(`/api/diccionario?palabra=${encodeURIComponent(word)}`)
            .then(r => r.ok ? r.json() : Promise.reject(new Error('HTTP '+r.status)))
            .then(d => {
              this.text = (d && d.found && d.definicion)
                ? d.definicion
                : `No encontramos la definición de “${word}”.`;
              this.positionNear(el);
              this.show = true;
            })
            .catch(err => {
              console.warn('Diccionario error:', err);
              this.text = 'Error consultando el diccionario.';
              this.positionNear(el);
              this.show = true;
            });
        },

        positionNear(el) {
          const rect = el.getBoundingClientRect();
          this.x = rect.left + rect.width / 2;
          this.y = rect.top  - 8;

          requestAnimationFrame(() => {
            const holder = document.getElementById('float-holder');
            const card   = document.getElementById('float-card');
            if (!holder || !card) return;

            const r = card.getBoundingClientRect();
            let x = this.x - r.width / 2;
            let y = this.y - r.height - 12;

            const vw = window.innerWidth, vh = window.innerHeight;
            x = Math.max(8, Math.min(vw - r.width - 8, x));
            y = Math.max(8, Math.min(vh - r.height - 8, y));

            holder.style.left = `${x}px`;
            holder.style.top  = `${y}px`;
          });
        },

        close() { this.show = false; }
      });

      // Reposicionar si cambia tamaño/scroll
      const repos = () => {
        const holder = document.getElementById('float-holder');
        const card   = document.getElementById('float-card');
        const s = Alpine.store('float');
        if (!holder || !card || !s.show) return;
        // Recalcula respecto a la última posición guardada en x/y (suficiente)
        requestAnimationFrame(() => {
          const r = card.getBoundingClientRect();
          let x = s.x - r.width / 2;
          let y = s.y - r.height - 12;
          const vw = window.innerWidth, vh = window.innerHeight;
          x = Math.max(8, Math.min(vw - r.width - 8, x));
          y = Math.max(8, Math.min(vh - r.height - 8, y));
          holder.style.left = `${x}px`;
          holder.style.top  = `${y}px`;
        });
      };
      window.addEventListener('resize', repos);
      window.addEventListener('scroll',  repos, true);
    });

    // Cerrar con ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && window.Alpine?.store('float')) {
        Alpine.store('float').close();
      }
    });
  </script>
  <!-- =================================================================== -->
  <div x-data @keydown.escape.window="$store.float.close()"></div>
</body>
</html>
