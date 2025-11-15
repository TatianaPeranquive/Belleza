@extends('layouts.app')


@section('content')


<div class="relative">


    {{-- Contenido principal encima  34113f--}}
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Espejo – Menú con contraste automático</title>

        <!-- Tailwind + GSAP (igual que tus ejemplos) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

        <style>
            html,

            body {
                margin: 0;
                padding: 0;
            }
/* a { background-color: rgba(255,0,0,0.2); } */
            body {
                overflow-x: hidden;
            }

            /* cursor principal */
            body {
                cursor: url("{{ asset('micursor.cur') }}") 16 16, auto;
            }

            /* cursor específico en enlaces (fallback pointer) */
            a, button {
                cursor: url("{{ asset('micursor.cur') }}") 16 16, pointer;
            }



            /* Estados del menú según contraste detectado */
            .menu-on-dark a {
                color: #fff !important;
                border-color: currentColor !important;
            }

            .menu-on-light a {
                color: #34113f !important;
                border-color: currentColor !important;
            }

            .parent {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(0, 1fr);
                gap: 0px;
            }

            #menu {
                background: transparent;
            }

            .selected {
                background-color: 34113f;
                color: #f8f8fa;
            }

            /* ESTADO INICIAL: negro + texto blanco + borde blanco */
            #opciones1 .opcion,
            #opciones2 .opcion2 {
                background-color: #34113f;
                /* negro */
                color: #f8f8fa;
                /* blanco */
                border-color: #f8f8fa;
                /* borde blanco */
                transition: transform 180ms ease, background-color .2s ease, color .2s ease, border-color .2s ease;
            }

            /* "Squash" mientras se presiona */
            #opciones1 .opcion:active,
            #opciones2 .opcion2:active {
                transform: scale(0.92);
            }

            /* REBOTE al seleccionar */
            @keyframes bounce-in {
                0% {
                    transform: scale(0.95);
                }

                55% {
                    transform: scale(1.08);
                }

                100% {
                    transform: scale(1.00);
                }
            }

            /* ESTADO SELECCIONADO: pasa a claro (blanco) + borde negro */
            #opciones1 .opcion.selected,
            #opciones2 .opcion2.selected {
                background-color: #f8f8fa;
                color: #34113f;
                border-color: #34113f;
                animation: bounce-in 200ms ease-out;
            }
            .fade-scroll {
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.8s ease-out;
            }

            /* Cuando entra en vista */
            .fade-scroll.show {
                opacity: 1;
                transform: translateY(0);
            }

   /* barra sólida clara / oscura */
.nav-light { background: #f8f8fa; color:#f8f8fa; backdrop-filter: blur(6px); border-bottom:1px solid #34113f; }
.nav-solid { background: #34113f;  color:#fff;     backdrop-filter: blur(6px); border-bottom:1px solid #34113F14; }
/* variantes de contraste según fondo */
.menu-on-light { color:#34113f; }
.menu-on-dark  { color:#f8f8fa; }
        </style>

        </style>
    </head>

    <body class="overflow-x-hidden">

        <section id="home0"></section>
        <!-- HERO -->
       <section id="home" class="h-screen flex justify-center items-center text-4xl bg-[#34113F] text-[#f8f8fa]">
            <!-- video -->
            <video src="EspejoPortada1.mp4"
                autoplay
                muted
                loop
                playsinline
                class="w-full h-auto max-h-screen object-cover">
            </video>
            <!-- al final del hero/video -->
            <div id="hero-sentinel" style="position: relative; height: 1px;"></div>

            <br><br> <br><br>
            <!-- MENÚ FIJO -->
        </section>

        <section id="about" class="flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <h2 class="text-4xl md:text-6xl font-bold">Espejito, espejito</h2>
                    <img src="portada1.png" alt=" " class="max-h-[500px] object-contain">
                </div>

                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <h2 class="text-2xl md:text-3xl tracking-wide">¿Qué es la belleza?</h2>
                    <p class="text-lg md:text-xl">Historias orales de mujeres colombianas</p>
                </div>

                <div class="div1 flex justify-center">
                </div>

                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada1_1.png" alt=" " class="max-h-[500px] object-contain">
                </div>

            </div>
        </section>


        <section id="work" class="flex  justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic"> Había una vez una mujer que le preguntó al
                        espejo
                        si era la más bonita.</p>
                </div>
                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada2.png" alt=" " class="max-h-[500px] object-contain">
                </div>
            </div>
        </section>

        <!-- <section id="contact" class="h-screen flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]"> -->
        <section id="contact" class="flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada3.png" alt=" " class="max-h-[500px] object-contain">
                </div>

                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic">
                        Cuando el espejo le dijo que no,
                        la mujer condenó a quien le había quitado su lugar.
                    </p>
                </div>

                <div class="div1 flex justify-center">
                </div>

            </div>
        </section>


        <section id="about2" class="flex  justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic">
                        Los actos para retomar su título fueron en vano, nadie quiso matar a la inocente belleza.
                    </p>
                </div>
            </div>
        </section>

        <section id="contact2" class="flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada5.png" alt=" " class="max-h-[500px] object-contain">
                </div>

                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic">
                        Así, con su deseo insatisfecho, la mujer fue castigada con la muerte.
                    </p>
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic">
                        Siempre me pregunté qué pasaría después...
                    </p>
                </div>

                <div class="div1 flex justify-center">
                </div>

            </div>
        </section>

        <section id="about3" class="flex  justify-center items-center text-4xl bg-[#34113F] text-[#f8f8fa]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto ">
                        Tal vez el ciclo se repitió y la sobreviviente le hizo la misma pregunta al espejo.
                    </p>
                </div>

                 <div class="div1 flex justify-center">
                    <p class="text-lg md:text-xl max-w-prose mx-auto ">
                        ¿Será inetable?
                    </p>
                </div>
            </div>
        </section>


        <section id="contact4" class="py-20 flex justify-center items-center text-4xl bg-[#34113F] text-[#f8f8fa]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Opciones -->
                <div class="div1 flex justify-center">
                    <ul id="opciones2" class="flex justify-center gap-4 w-full max-w-6xl mx-auto">
                        <li class="flex-1">
                            <button type="button"
                                class="opcion2 block w-full text-center px-3 py-1 rounded border font-bold text-lg hover:underline">
                                Las imperfecciones
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button"
                                class="opcion2 block w-full text-center px-3 py-1 rounded border font-bold text-lg hover:underline">
                                Lo malo y lo bueno
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button"
                                class="opcion2 block w-full text-center px-3 py-1 rounded border font-bold text-lg hover:underline">
                                El paso del tiempo
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button"
                                class="opcion2 block w-full text-center px-3 py-1 rounded border font-bold text-lg hover:underline">
                                Que todo esté en su lugar
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Pregunta -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto">
                        Y tú, ¿cuándo te miras al espejo, qué ves?
                    </p>
                </div>
            </div>
        </section>

        <section id="about4" class="flex  justify-center items-center text-4xl bg-[#34113F] text-[#f8f8fa]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <!-- Respuesta -->
                    <div class="div1 flex justify-center">
                        <p id="respuesta2" ></p>
                    </div>

                    <p class="text-lg md:text-xl max-w-prose mx-auto ">
                        En tu vida cotidiana, ¿qué tanto piensas sobre tu belleza?
                    </p>
                    <p class="text-lg md:text-xl max-w-prose mx-auto ">
                        ¿También?
                    </P>
                </div>
            </div>
        </section>

        <section id="contact3" class="py-10 flex justify-center items-center text-4xl bg-[#34113F] text-[#f8f8fa]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Lista de opciones -->
                <div class="div1 flex justify-center">
                    <ul id="opciones1" class="flex justify-center gap-4 w-full max-w-6xl">
                        <li class="flex-1">
                            <button type="button" data-value="UN POCO" class="opcion block w-full text-center px-3 py-2 rounded-lg border font-bold text-lg transition
               hover:underline bg-[#34113F] text-[#f8f8fa] border-[#34113F]">
                                Casi nunca
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button" data-value="UN MONTÓN" class="opcion block w-full text-center px-3 py-2 rounded-lg border font-bold text-lg transition
               hover:underline bg-[#34113F] text-[#f8f8fa] border-[#34113F]">
                                A ratos
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button" data-value="NO LO HABÍA PENSADO" class="opcion block w-full text-center px-3 py-2 rounded-lg border font-bold text-lg transition
               hover:underline bg-[#34113F] text-[#f8f8fa] border-[#34113F]">
                                Todo el tiempo
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button" data-value="NO TANTO" class="opcion block w-full text-center px-3 py-2 rounded-lg border font-bold text-lg transition
               hover:underline bg-[#34113F] text-[#f8f8fa] border-[#34113F]">
                                Qué hay que pensar
                            </button>
                        </li>
                    </ul>
                </div>
                <!-- Texto que se actualizará -->
                <div class="div2 text-center space-y-4">
                    <p id="respuesta" class="text-lg md:text-xl max-w-prose mx-auto italic text-[#f8f8fa]-700"></p>
                    <p class="text-lg md:text-xl max-w-prose mx-auto ">
                        Pues, este proyecto quiere hacerte reflexionar sobre la belleza de otra manera.
                    </p>
                </div>
            </div>
        </section>
        <section id="contact4" class=" py-10 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="text-center ">
                <br>
                <p class="text-lg md:text-xl max-w-prose mx-auto ">
                   Rompamos el blanco y negro con el propósito de reconocer y resignificar la forma en que te relacionas con la belleza y tejes tu propia historia.
                </p>
            </div>

</div>
</section>

<section id="contact5" class=" py-10 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
    <div class="text-center ">
        <img src="portada8.png" alt=" " class="max-h-[500px] object-contain">
    </div>
</section>

<section id="contact6" class=" py-10 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
    <div class="text-center ">
        <p class="text-lg md:text-xl max-w-prose mx-auto ">
           Aquí leerás las historias de un par de mujeres colombianas que se aventuraron a relatar cómo se relacionaron con el embellecimiento y la belleza a lo largo de sus vidas.
        </p>
    </div>
</section>

<section id="contact7" class=" py-10 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
    <div class="text-center ">
        <p class="text-lg md:text-xl max-w-prose mx-auto ">
            Espero que al leer los hilos de sus historias te mires al espejo y veas algo diferente.
        </p>
            <!-- Imagen -->
        <div class="text-center ">
            <img src="portada9.png" alt=" " class="max-h-[500px] object-contain">
        </div>
    </div>
</section>

<section id="contact8" class="py-20 justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
    <div class="text-center ">
        <h2 class="text-2xl md:text-3xl tracking-wide">• Entra al espejo •</h2>
    </div>
</section>

<section id="contact5" class="flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">

    <div class="relative max-w-5xl mx-auto">
        <!-- Imagen -->
        <img src="{{ asset('Menu_espejos.png') }}" alt="Tres espejos"
            class="w-full h-auto select-none pointer-events-none">

        <!-- Hotspots invisibles -->
        <div class="absolute inset-0 grid grid-cols-3">
            <!-- Espejo izquierdo -->
            <a href="{{ route('hitos.index', ['hito' => 1]) }}#hitos-top" class="block group"
                aria-label="Espejo izquierdo"
                class="block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
            </a>

            <!-- Espejo central -->
            <a href="{{ route('hitos.index', ['hito' => 2]) }}#hitos-top" class="block group"
            aria-label="Espejo central"
            class="block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
            </a>

            <!-- Espejo derecho -->
            <a href="{{ route('hitos.index', ['hito' => 3]) }}#hitos-top" class="block group"
                aria-label="Espejo derecho"
                class="block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
            </a>
        </div>
    </div>
</section>
<br><br><br>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // -------------------------------
  // 1) Clicks en opciones (bloques de preguntas/respuestas simples)
  // -------------------------------
  const opciones = document.querySelectorAll('#opciones1 .opcion');
  const respuesta = document.getElementById('respuesta');

  opciones.forEach(op => {
    op.addEventListener('click', e => {
      e.preventDefault();
      opciones.forEach(o => o.classList.remove('selected'));
      op.classList.add('selected');
      if (respuesta) respuesta.textContent = " ¿" + op.textContent.trim() + "?";
    });
  });

  const opciones2 = document.querySelectorAll('#opciones2 .opcion2');
  const respuesta2 = document.getElementById('respuesta2');
  const comentario = document.getElementById("comentario");



  opciones2.forEach(op => {
    op.addEventListener('click', e => {
        e.preventDefault();
        opciones2.forEach(o => o.classList.remove('selected'));
        op.classList.add('selected');
        if (respuesta2) {
            // Limpia el <p>
            respuesta2.innerHTML = "";

            // SPAN para el texto base (con su propio estilo)
            const spanBase = document.createElement("span");
            spanBase.className = "text-lg md:text-xl italic text-[#f8f8fa]-300";
            spanBase.textContent = op.textContent.trim() + " ";

            // SPAN para "Interesante" (con otro estilo distinto)
            const spanInteresante = document.createElement("span");
            spanInteresante.className = "text-lg md:text-xl font-bold text-[#f8f8fa]-300";
            spanInteresante.textContent = "  Interesante.";

            // Agregar ambos al párrafo
            respuesta2.appendChild(spanBase);
            respuesta2.appendChild(spanInteresante);
        }
      //if (respuesta2.textContent.trim() !== "") {comentario.classList.remove("hidden");}
    });
  });

  // -------------------------------
  // 2) Menú: mostrar/ocultar + contraste según lo que haya detrás
  // -------------------------------
  const menu = document.getElementById('menu');                 // <-- el header del layout
  const sentinel = document.getElementById('hero-sentinel');    // <-- pon esto al final del hero

  if (menu && sentinel) {
    menu.style.zIndex = 1200;

    // Cambia transparente ↔ sólido cuando sales del hero
    const navObserver = new IntersectionObserver(([entry]) => {
      const onHero = entry.isIntersecting;
      if (onHero) {
        menu.classList.remove('nav-light','nav-solid','opacity-100','pointer-events-auto');
        menu.classList.add('bg-transparent','text-[#f8f8fa]','opacity-0','pointer-events-none');
      } else {
        menu.classList.remove('bg-transparent','text-[#f8f8fa]','opacity-0','pointer-events-none');
        // elige un estilo base al bajar; por defecto claro
        menu.classList.add('nav-light','opacity-100','pointer-events-auto');
      }
      // Recalcula contraste al cambiar de estado
      requestAnimationFrame(adjustMenuContrast);
    }, { threshold: 0.05 });

    navObserver.observe(sentinel);

    // ---- contraste dinámico (claro/oscuro) ----
    function parseRGB(rgbStr) {
      const m = rgbStr && rgbStr.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([0-9.]+))?\)/);
      if (!m) return { r: 255, g: 255, b: 255, a: 1 };
      return { r: +m[1], g: +m[2], b: +m[3], a: m[4] !== undefined ? +m[4] : 1 };
    }
    function relativeLuminance(r,g,b){
      const s=[r,g,b].map(v=>{v/=255;return v<=0.03928?v/12.92:Math.pow((v+0.055)/1.055,2.4);});
      return 0.2126*s[0]+0.7152*s[1]+0.0722*s[2];
    }
    function getEffectiveBgColor(el){
      let e=el;
      while(e&&e!==document.documentElement){
        const cs=getComputedStyle(e);
        const {r,g,b,a}=parseRGB(cs.backgroundColor);
        if(a>0) return {r,g,b};
        e=e.parentElement;
      }
      const {r,g,b}=parseRGB(getComputedStyle(document.body).backgroundColor||'rgb(255,255,255)');
      return {r,g,b};
    }

    let rafId = null;
    function adjustMenuContrast(){
      if (rafId) { cancelAnimationFrame(rafId); }
      rafId = requestAnimationFrame(() => {
        const navH = menu.getBoundingClientRect().height || 56;
        const x = window.innerWidth / 2;
        const y = Math.max(8, navH + 1);
        const oldPE = menu.style.pointerEvents;
        menu.style.pointerEvents = 'none';
        const behind = document.elementFromPoint(x,y) || document.body;
        menu.style.pointerEvents = oldPE;
        const { r,g,b } = getEffectiveBgColor(behind);
        const L = relativeLuminance(r,g,b);
        const onLight = L >= 0.5;
        menu.classList.toggle('menu-on-light', onLight);
        menu.classList.toggle('menu-on-dark', !onLight);
      });
    }

    window.addEventListener('scroll', adjustMenuContrast, { passive:true });
    window.addEventListener('resize', adjustMenuContrast);
    adjustMenuContrast();
  }

  // -------------------------------
  // 3) Animaciones (opcionales) GSAP
  // -------------------------------
  if (window.gsap) {
    gsap.registerPlugin && gsap.registerPlugin(window.ScrollTrigger || {});
    // Hero text (si existen)
    if (document.querySelector('h1')) {
      gsap.from("h1", { opacity: 0, y: -50, duration: 1, ease: "power2.out" });
    }
    if (document.querySelector('p')) {
      gsap.from("p", { opacity: 0, y: 20, duration: 1, delay: 0.5, ease: "power2.out" });
    }
    // Tarjetas en cascada
    if (gsap.utils && document.getElementById('cards-container')) {
      gsap.fromTo(".card",
        { y: 80, opacity: 0 },
        {
          y: 0, opacity: 1, duration: 1, ease: "power3.out", stagger: 0.3,
          scrollTrigger: {
            trigger: "#cards-container",
            start: "top 85%",
            end: "bottom 60%",
            toggleActions: "play none none none",
          }
        }
      );
    }
  }

  // -------------------------------
  // 4) Fade-on-scroll (IntersectionObserver)
  // -------------------------------
  const faders = document.querySelectorAll('.fade-scroll');
  if (faders.length) {
    const appearOnScroll = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    faders.forEach(f => appearOnScroll.observe(f));
  }
});
</script>

</body>
</html>
</div>
<div class="pb-40"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>


@endsection
