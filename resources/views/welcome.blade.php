@extends('layouts.app')


@section('content')


<div class="relative">


    {{-- Contenido principal encima 34113f--}}
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Espejo – Menú con contraste automático</title>

        <!-- Tailwind + GSAP -->
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
                cursor: url("{{ asset('micursor.cur') }}") 16 16,
                auto;
            }

            /* cursor específico en enlaces (fallback pointer) */
            a,
            button {
                cursor: url("{{ asset('micursor.cur') }}") 16 16,
                pointer;
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
            .nav-light {
                background: #f8f8fa;
                color: #f8f8fa;
                backdrop-filter: blur(6px);
                border-bottom: 1px solid #34113f;
            }

            .nav-solid {
                background: #34113f;
                color: #E5E3F7;
                backdrop-filter: blur(6px);
                border-bottom: 1px solid #34113F14;
            }

            /* variantes de contraste según fondo */
            .menu-on-light {
                color: #34113f;
            }

            .menu-on-dark {
                color: #f8f8fa;
            }

            .reveal-up {
                opacity: 0;
                transform: translateY(40px);
            }

            .reveal-up.is-visible {
                animation: floatUp 0.8s ease-out forwards;
            }

            @keyframes floatUp {
                0% {
                    opacity: 0;
                    transform: translateY(40px);
                }

                60% {
                    opacity: 1;
                    transform: translateY(-6px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Delay*/
            .reveal-delay-1.is-visible {
                animation-delay: 0.15s;
            }
        </style>
    </head>

    <body class="overflow-x-hidden">
        <section id="home" class="bg-[#34113F] py-10 flex flex-col justify-start">

            <div class="relative w-full
              h-[45vh]
              md:h-[90vh]
              overflow-hidden">

                <video src="EspejoPortada1.mp4" autoplay muted playsinline class="w-full h-full object-cover">
                </video>

            </div>

            <div id="hero-sentinel" class="relative h-px"></div>

        </section>


        <section id="about" class="bg-[#f8f8fa] py-10 min-h-screen flex flex-col justify-start">
            <div class="relative w-full md:h-[90vh] md:flex md:items-center md:justify-center">

                <h1 class="
  relative md:absolute
  mt-10 md:mt-0
  px-6 md:px-0
  text-5xl md:text-6xl lg:text-6xl
  font-bold text-[#34113F] reveal-scroll
  md:top-14 md:left-12
  text-center md:text-left
">
                    Espejito,espejito
                </h1>


                <img src="portada1.png"
                    class="mx-auto w-auto h-[60vh] md:h-[90vh] object-contain lg:translate-x-[-50px] reveal-scroll">

                <div class="mt-6 px-6 text-center md:mt-0 md:px-0 md:text-right
                        md:absolute md:bottom-20 md:right-16">
                    <h2
                        class="text-4xl md:text-6xl lg:text-5xl font-semibold text-[#34113F] leading-tight reveal-scroll-delay-2">
                        ¿Qué es la belleza?
                    </h2>
                    <p class="text-xl md:text-3xl lg:text-4xl font-medium text-[#34113F]/80 mt-2 reveal-scroll-delay-2">
                        Historias orales <br> de mujeres colombianas
                    </p>
                </div>
            </div>
        </section>


        <section id="work" class="bg-[#f8f8fa] py-20 text-[#34113F] leading-snug">

            <div class="max-w-7xl mx-auto px-8
              grid grid-cols-1 gap-10
              lg:grid-cols-3 lg:grid-rows-2 lg:gap-12 items-center">

                <p class="italic text-xl md:text-3xl lg:text-4xl leading-snug text-center
              lg:col-start-1 lg:row-start-1 lg:self-start reveal-scroll">
                    Había una vez una mujer,
                    que le preguntó al espejo
                    si era la más bonita.
                </p>

                <div class="flex justify-center lg:col-start-2 lg:row-span-2 lg:self-center">
                    <img src="Portada2.png" alt="Mujer frente al espejo"
                        class="max-h-[520px] lg:max-h-[650px] object-contain reveal-scroll">
                </div>

                <p class="italic text-xl md:text-3xl lg:text-4xl leading-snug text-center
              lg:col-start-3 lg:row-start-2 lg:self-end reveal-scroll">
                    Cuando el espejo le dijo que no,
                    la mujer condenó
                    a quien le había quitado su lugar.
                </p>

            </div>

            <!-- TEXTO SUPERIOR -->
            <div class="max-w-5xl mx-auto px-8 text-center mt-20 mb-16">
                <p class="italic text-xl md:text-3xl lg:text-4xl leading-snug reveal-scroll-delay-2">
                    Los actos para retomar su título<br>
                    fueron en vano, nadie quiso matar<br>
                    a la inocente belleza.
                </p>
            </div>

            <!-- DOS COLUMNAS -->
            <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-10 place-items-center">

                <div class="text-left">
                    <p class="italic text-xl md:text-3xl lg:text-4xl leading-snug reveal-scroll">
                        Así, con su deseo insatisfecho,<br>
                        la mujer fue castigada con la<br>
                        muerte.
                    </p>
                </div>

                <div class="flex justify-center">
                    <img src="Portada3.png" alt="" class="max-h-[420px] md:max-h-[480px] object-contain reveal-scroll">
                </div>

            </div>

        </section>


        <section id="about3" class="flex bg-[#34113F] text-[#f8f8fa] py-16">

            <div class="max-w-6xl mx-auto px-8 space-y-6">

                <!-- Texto superior centrado -->
                <p class="text-xl md:text-3xl lg:text-4xl text-center reveal-scroll">
                    Siempre me pregunté qué pasaría después...
                </p>

                <!-- Fila central -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">

                    <!-- Imagen (MUCHO más grande) -->
                    <div class="flex justify-center">
                        <img src="Portada5.png" class="object-contain
                            max-h-[600px] md:max-h-[750px] lg:max-h-[900px]
                            reveal-scroll">
                    </div>

                    <!-- Texto central derecha -->
                    <div class="text-center md:text-left">
                        <p class="text-xl md:text-3xl lg:text-4xl text-center leading-snug reveal-scroll">
                            Tal vez el ciclo se repitió y la sobreviviente
                            le hizo la misma pregunta al espejo.
                        </p>
                    </div>

                </div>

                <!-- Texto inferior centrado, SIN MARGEN EXTRA -->
                <p class="text-xl md:text-3xl lg:text-4xl text-center reveal-scroll reveal-delay-1 !mt-2">
                    ¿Será inevitable?
                </p>

            </div>

        </section>


        <section id="flex contact33" class="flex py-24 bg-[#f8f8fa] text-[#34113F]">
            <div class="max-w-5xl mx-auto px-6 space-y-12 overflow-x-hidden">
                <!-- Pregunta superior -->
                <p class="text-xl md:text-3xl lg:text-4xl text-center reveal-scroll reveal-delay-1 !mt-2">
                    Cuando te miras al espejo, <i>¿qué ves?</i>
                </p>

                <!-- OPCIONES flotadas -->
                <div class="relative w-full mx-auto h-auto md:h-[450px] lg:h-[280px]">

                    <ul id="opciones2" class="flex flex-col gap-4 items-center
           md:block md:relative md:w-full md:h-full">

                        <!--Las imperfecciones -->
                        <li class="
    md:absolute md:top-0 md:left-[2%]
">
                            <button class="opcion2 px-4 py-2 min-w-[12rem]
                 border-2 border-[#C9BDEB] bg-white text-[#34113F]
                 rounded-2xl text-xl md:text-2xl shadow-sm">
                                Que todo esté en su lugar
                            </button>
                        </li>

                        <li class="
    md:absolute md:top-32 md:left-[28%]
">
                            <button class="opcion2 px-4 py-2 min-w-[12rem]
                 border-2 border-[#C9BDEB] bg-white text-[#34113F]
                 rounded-2xl text-xl md:text-2xl shadow-sm">
                                El paso del tiempo
                            </button>
                        </li>


                        <!-- Lo malo y lo bueno -->
                        <li class="
    md:absolute md:top-16 md:left-[15%]
">
                            <button class="opcion2 px-4 py-2 min-w-[12rem]
                 border-2 border-[#C9BDEB] bg-white text-[#34113F]
                 rounded-2xl text-xl md:text-2xl shadow-sm">
                                Lo malo y lo bueno
                            </button>
                        </li>


                        <li class="
    md:absolute md:top-48
     md:left-[62%] lg:left-[50%]
">
                            <button class="opcion2 px-4 py-2 min-w-[12rem]
                 border-2 border-[#C9BDEB] bg-white text-[#34113F]
                 rounded-2xl text-xl md:text-2xl shadow-sm
                 whitespace-normal md:whitespace-nowrap">
                                Las imperfecciones
                            </button>
                        </li>

                    </ul>
                </div>
            </div>
        </section>

        <section id="rta4" class="flex py-2 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="text-center ">
                <!-- Respuesta -->
                <p class="text-xl md:text-3xl lg:text-4xl text-center reveal-scroll">
                    <span id="respuesta2" class="inline-block min-w-[150px] border-b border-[#f8f8fa] align-middle">
                    </span>
                </p>
            </div>
        </section>

        <section id="contact4" class="flex py-24 bg-[#f8f8fa] text-[#34113F]">

            <div class="max-w-5xl mx-auto px-6 space-y-6">

                <!-- Pregunta superior -->
                <p class="text-xl md:text-3xl lg:text-4xl text-center reveal-scroll reveal-delay-1 !mt-2">
                    En tu vida cotidiana, <i>¿qué tanto piensas<br>sobre tu belleza?</i>
                </p>

                <!-- Opciones flotadas -->
                <div class="relative w-full mx-auto h-auto md:h-[450px] lg:h-[280px]">

                    <ul id="opciones1" class="flex flex-col gap-4 items-center
           md:block md:relative md:w-full md:h-full">


                        <!-- Casi nunca -->
                        <li class="md:absolute md:top-0 md:left-[1%]">
                            <button type="button" class="opcion inline-flex justify-center items-center
             px-4 py-2 min-w-[12rem]
             border-2 border-[#C9BDEB] bg-white text-[#34113F]
             rounded-2xl text-xl md:text-2xl shadow-sm">
                                Casi nunca
                            </button>
                        </li>

                        <!-- Todo el tiempo -->
                        <li class="md:absolute md:top-14 md:left-[17%]">
                            <button type="button" class="opcion inline-flex justify-center items-center
             px-4 py-2 min-w-[12rem]
             border-2 border-[#C9BDEB] bg-white text-[#34113F]
             rounded-2xl text-xl md:text-2xl shadow-sm">
                                Todo el tiempo
                            </button>
                        </li>

                        <!-- A ratos -->
                        <li class="md:absolute md:top-28 md:left-[39%]">
                            <button type="button" class="opcion inline-flex justify-center items-center
             px-4 py-2 min-w-[12rem]
             border-2 border-[#C9BDEB] bg-white text-[#34113F]
             rounded-2xl text-xl md:text-2xl shadow-sm">
                                A ratos
                            </button>
                        </li>

                        <!-- Qué hay que pensar -->
                        <li class="md:absolute md:top-44 md:left-[62%]">
                            <button type="button" class="opcion inline-flex justify-center items-center
             px-4 py-2 min-w-[12rem]
             border-2 border-[#C9BDEB] bg-white text-[#34113F]
             rounded-2xl text-xl md:text-2xl shadow-sm
             max-w-[88vw] md:max-w-none whitespace-normal md:whitespace-nowrap leading-tight">
                                Qué hay que pensar
                            </button>
                        </li>

                    </ul>
                </div>

        </section>
        <section id="rta2" class="flex py-2 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="text-center ">
                <!-- Línea de respuesta -->
                <p id="respuesta"
                    class="text-xl md:text-3xl lg:text-4xl text-center text-bold italic reveal-scroll reveal-delay-1 !mt-2">

            </div>
        </section>

        <section id="about4" class="flex py-10 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="text-center ">
                <p class="text-xl md:text-3xl lg:text-4xl text-center reveal-scroll reveal-delay-1 !mt-2">
                    Pues, este proyecto quiere hacerte reflexionar sobre la belleza de otra manera.
                </p>
            </div>
        </section>


        <section id="contact4" class="flex py-10 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
            <div class="text-center ">
                <br>
                <p class="text-xl md:text-3xl lg:text-4xl text-center max-w-prose mx-auto reveal-scroll">
                    Rompamos el blanco y negro con el propósito de reconocer y resignificar la forma en que te
                    relacionas con la belleza y tejes tu propia historia.
                </p>
            </div>

</div>
</section>

<section id="contact5" class="py-10 bg-[#f8f8fa] text-[#34113F]">
    <div class="flex justify-center">
        <img src="Portada8.png" alt="" class="max-h-[420px] md:max-h-[480px] object-contain reveal-scroll">
    </div>
</section>


<section id="contact6" class=" py-10 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
    <div class="text-center ">
        <p class="text-xl md:text-3xl lg:text-4xl text-center max-w-prose mx-auto reveal-scroll">
            Aquí leerás las historias de un par de mujeres colombianas que se aventuraron a relatar cómo se relacionaron
            con el embellecimiento y la belleza a lo largo de sus vidas.
        </p>
    </div>
</section>

<section id="contact7" class=" py-10 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
    <div class="text-center ">
        <p class="text-xl md:text-3xl lg:text-4xl text-center max-w-prose mx-auto reveal-scroll ">
            Espero que al leer los hilos de sus historias te mires al espejo y veas algo diferente.
        </p>
    </div>
</section>

<section id="contact8" class="py-20 flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">
    <div class="text-center ">
        <h2 class="text-5xl md:text-6xl lg:text-5xl tracking-wide reveal-scroll reveal-delay-2"> Entra al espejo</h2>
    </div>
</section>

<section id="contact5" class="flex flex justify-center items-center text-4xl bg-[#f8f8fa] text-[#34113F]">

    <div class="relative max-w-5xl mx-auto">
        <!-- Imagen -->
        <img src="{{ asset('Menu_espejos.png') }}" alt="Tres espejos"
            class="w-full h-auto select-none pointer-events-none ">

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
                    spanBase.className = "text-xl md:text-3xl lg:text-4xl italic text-[#f8f8fa]-300";
                    spanBase.textContent = op.textContent.trim() + " ";

                    // SPAN para "Interesante" (con otro estilo distinto)
                    const spanInteresante = document.createElement("span");
                    spanInteresante.className = "text-xl md:text-3xl lg:text-4xl font-bold italic text-[#f8f8fa]-300";
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
                    menu.classList.remove('nav-light', 'nav-solid', 'opacity-100', 'pointer-events-auto');
                    menu.classList.add('bg-transparent', 'text-[#f8f8fa]', 'opacity-0', 'pointer-events-none');
                } else {
                    menu.classList.remove('bg-transparent', 'text-[#f8f8fa]', 'opacity-0', 'pointer-events-none');
                    // elige un estilo base al bajar; por defecto claro
                    menu.classList.add('nav-light', 'opacity-100', 'pointer-events-auto');
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
            function relativeLuminance(r, g, b) {
                const s = [r, g, b].map(v => { v /= 255; return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4); });
                return 0.2126 * s[0] + 0.7152 * s[1] + 0.0722 * s[2];
            }
            function getEffectiveBgColor(el) {
                let e = el;
                while (e && e !== document.documentElement) {
                    const cs = getComputedStyle(e);
                    const { r, g, b, a } = parseRGB(cs.backgroundColor);
                    if (a > 0) return { r, g, b };
                    e = e.parentElement;
                }
                const { r, g, b } = parseRGB(getComputedStyle(document.body).backgroundColor || 'rgb(255,255,255)');
                return { r, g, b };
            }

            let rafId = null;
            function adjustMenuContrast() {
                if (rafId) { cancelAnimationFrame(rafId); }
                rafId = requestAnimationFrame(() => {
                    const navH = menu.getBoundingClientRect().height || 56;
                    const x = window.innerWidth / 2;
                    const y = Math.max(8, navH + 1);
                    const oldPE = menu.style.pointerEvents;
                    menu.style.pointerEvents = 'none';
                    const behind = document.elementFromPoint(x, y) || document.body;
                    menu.style.pointerEvents = oldPE;
                    const { r, g, b } = getEffectiveBgColor(behind);
                    const L = relativeLuminance(r, g, b);
                    const onLight = L >= 0.5;
                    menu.classList.toggle('menu-on-light', onLight);
                    menu.classList.toggle('menu-on-dark', !onLight);
                });
            }

            window.addEventListener('scroll', adjustMenuContrast, { passive: true });
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>


@endsection
