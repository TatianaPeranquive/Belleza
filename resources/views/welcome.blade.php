@extends('layouts.app')


@section('content')


<div class="relative">


    {{-- Contenido principal encima --}}
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

            /* Estados del menú según contraste detectado */
            .menu-on-dark a {
                color: #fff !important;
                border-color: currentColor !important;
            }

            .menu-on-light a {
                color: #000 !important;
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
                background-color: black;
                color: white;
            }

            /* ESTADO INICIAL: negro + texto blanco + borde blanco */
            #opciones1 .opcion,
            #opciones2 .opcion2 {
                background-color: #000;
                /* negro */
                color: #fff;
                /* blanco */
                border-color: #fff;
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
                background-color: #fff;
                color: #000;
                border-color: #000;
                animation: bounce-in 200ms ease-out;
            }
        </style>
    </head>

    <body class="overflow-x-hidden">
        <section id="home0" class="py-10 bg-black"></section>
        <!-- HERO -->
        <section id="home" class="h-screen flex justify-center items-center text-4xl bg-black text-white">
            <!-- Imagen -->
            <video src="EspejoPortada1.mp4" controls poster="EspejoPortada.png"
                class="w-full h-auto max-h-screen object-cover">
            </video>
            <br><br> <br><br>
            <!-- MENÚ FIJO -->
        </section>

        <section id="about" class="flex justify-center items-center text-4xl bg-white text-black">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada1.png" alt=" " class="max-h-[500px] object-contain">
                </div>

                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <h1 class="text-4xl md:text-6xl font-bold">Espejito, espejito</h1>
                    <br><br>
                    <h2 class="text-2xl md:text-3xl tracking-wide">• ¿Qué es la belleza? •</h2>
                    <br><br>
                    <p class="text-lg md:text-xl">Para mí, la belleza es...</p>
                </div>

                <div class="div1 flex justify-center">
                </div>

                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada1_1.png" alt=" " class="max-h-[500px] object-contain">
                </div>

            </div>
        </section>


        <section id="work" class="flex  justify-center items-center text-4xl bg-white text-black">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic"> Había una vez una mujer que le preguntó al
                        espejo
                        si era la más bonita del reino.</p>
                </div>
                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada2.png" alt=" " class="max-h-[500px] object-contain">
                </div>
            </div>
        </section>

        <!-- <section id="contact" class="h-screen flex justify-center items-center text-4xl bg-white text-black"> -->
        <section id="contact" class="flex justify-center items-center text-4xl bg-white text-black">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada3.png" alt=" " class="max-h-[500px] object-contain">
                </div>

                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic">
                        Cuando el espejo le dijo que no,
                        ella, determinada,
                        decidió matar
                        a quien tomó su lugar.
                    </p>
                </div>

                <div class="div1 flex justify-center">
                </div>

            </div>
        </section>

        <!-- <section id="about2" class="h-screen flex justify-center items-center text-4xl bg-black text-white"> -->
        <section id="about2" class="flex  justify-center items-center text-4xl bg-white text-black">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic">
                        Pero la mujer más bonita
                        se escapó de sus intentos
                        de asesinato
                        debido a su belleza.
                    </p>
                </div>
                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada4.png" alt=" " class="max-h-[500px] object-contain">
                </div>
            </div>
        </section>

        <section id="contact2" class="flex justify-center items-center text-4xl bg-white text-black">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada5.png" alt=" " class="max-h-[500px] object-contain">
                </div>

                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic">
                        Y la mujer que había
                        perdido su título fue
                        castigada con la muerte.
                    </p>
                    <p class="text-lg md:text-xl max-w-prose mx-auto italic">
                        FIN (?)
                    </p>
                </div>

                <div class="div1 flex justify-center">
                </div>

            </div>
        </section>

        <section id="about3" class="flex  justify-center items-center text-4xl bg-black text-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto ">
                        Esa es una historia que nos
                        han contado muchas veces;
                        cada vez que pienso en ella,
                        reflexiono en el castigo que
                        recibió la mujer
                        fue por tener el deseo de ser bonita,
                        por darle importancia al querer.
                        Pero...
                    </p>
                </div>
                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada6.png" alt=" " class="max-h-[500px] object-contain">
                </div>
            </div>
        </section>


        <section id="contact4" class="py-20 flex justify-center items-center text-4xl bg-black text-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Opciones -->
                <div class="div1 flex justify-center">
                    <ul id="opciones2" class="flex justify-center gap-4 w-full max-w-6xl mx-auto">
                        <li class="flex-1">
                            <button type="button"
                                class="opcion2 block w-full text-center px-3 py-1 rounded border font-bold text-lg hover:underline">
                                VARIAS VECES
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button"
                                class="opcion2 block w-full text-center px-3 py-1 rounded border font-bold text-lg hover:underline">
                                POCAS VECES
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button"
                                class="opcion2 block w-full text-center px-3 py-1 rounded border font-bold text-lg hover:underline">
                                TODO EL TIEMPO
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button"
                                class="opcion2 block w-full text-center px-3 py-1 rounded border font-bold text-lg hover:underline">
                                NUNCA
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Pregunta -->
                <div class="div2 text-center space-y-4">
                    <p class="text-lg md:text-xl max-w-prose mx-auto">
                        ¿Cuántas veces no te has visto al espejo y te has preguntado por la belleza?
                    </p>
                </div>
            </div>
        </section>

        <section id="about4" class="flex  justify-center items-center text-4xl bg-black text-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
                <!-- Texto (centrado siempre) -->
                <div class="div2 text-center space-y-4">
                    <!-- Respuesta -->
                    <div class="div1 flex justify-center">


                        </p>
                        <p id="respuesta2" class="text-lg md:text-xl max-w-prose mx-auto italic text-white-700"></p>
                    </div>
                    <p class="text-lg md:text-xl max-w-prose mx-auto ">
                        Personalmente, yo lo he hecho;
                        ha sido algo que ha impactado mi vida de muchas formas;
                        me imagino que la tuya,
                    </p>
                    <p class="text-lg md:text-xl max-w-prose mx-auto ">
                        ¿También?
                    </P>
                </div>
                <!-- Imagen -->
                <div class="div1 flex justify-center">
                    <img src="portada7.png" alt=" " class="max-h-[500px] object-contain">
                </div>
            </div>
        </section>

        <section id="contact3" class="py-10 flex justify-center items-center text-4xl bg-black text-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">

                <!-- Lista de opciones -->
                <div class="div1 flex justify-center">
                    <ul id="opciones1" class="flex justify-center gap-4 w-full max-w-6xl">
                        <li class="flex-1">
                            <button type="button" data-value="UN POCO" class="opcion block w-full text-center px-3 py-2 rounded-lg border font-bold text-lg transition
               hover:underline bg-black text-white border-black">
                                UN POCO
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button" data-value="UN MONTÓN" class="opcion block w-full text-center px-3 py-2 rounded-lg border font-bold text-lg transition
               hover:underline bg-black text-white border-black">
                                UN MONTÓN
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button" data-value="NO LO HABÍA PENSADO" class="opcion block w-full text-center px-3 py-2 rounded-lg border font-bold text-lg transition
               hover:underline bg-black text-white border-black">
                                NO LO HABÍA PENSADO
                            </button>
                        </li>
                        <li class="flex-1">
                            <button type="button" data-value="NO TANTO" class="opcion block w-full text-center px-3 py-2 rounded-lg border font-bold text-lg transition
               hover:underline bg-black text-white border-black">
                                NO TANTO
                            </button>
                        </li>
                    </ul>

                    {{-- opcional: para enviar al backend --}}
                    <input type="hidden" id="respuestaSeleccionada" name="respuesta" value="">
                </div>
                <!-- Texto que se actualizará -->
                <div class="div2 text-center space-y-4">
                    <p id="respuesta" class="text-lg md:text-xl max-w-prose mx-auto italic text-white-700">

                    </p>
                </div>
            </div>
        </section>
        <section id="contact4" class=" py-10 flex justify-center items-center text-4xl bg-white text-black">
            <div class="text-center ">
                <p class="text-lg md:text-xl max-w-prose mx-auto ">
                    Por eso, esta página es una forma de comenzar una charla.
                </p>
                <br>
                <p class="text-lg md:text-xl max-w-prose mx-auto ">
                    Una que abarque varios puntos de la belleza, mi propuesta es pasar de lo bueno y lo malo y
                    adentrarnos a un
                    espacio en que veamos el entramado de los hilos de la belleza.
                </p>
            </div>

</div>
</section>

<section id="contact5" class=" py-10 flex justify-center items-center text-4xl bg-white text-black">
    <div class="text-center ">
        <img src="portada8.png" alt=" " class="max-h-[500px] object-contain">
    </div>
</section>

<section id="contact6" class=" py-10 flex justify-center items-center text-4xl bg-white text-black">
    <div class="text-center ">
        <p class="text-lg md:text-xl max-w-prose mx-auto ">
            En que podamos charlar de las cosas chéveres, las cosas difíciles y de aquellas cosas que pasan
            inadvertidas. Para reconocer y resignificar la forma en la que te relacionas con la belleza y tejes tu
            propia historia.
        </p>
    </div>
</section>

<section id="contact7" class=" py-10 flex justify-center items-center text-4xl bg-white text-black">
    <div class="text-center ">
        <p class="text-lg md:text-xl max-w-prose mx-auto ">
            Las historias que leerás a continuación son de un par de mujeres colombianas y responden a cuáles han sido
            sus experiencias con su cuerpo, cómo la belleza las atravesó en momentos de su vida y cómo han lidiado con
            ella.
        </p>
    </div>
</section>

<section id="about5" class="flex  justify-center items-center text-4xl bg-white text-black">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-6xl mx-auto items-center">
        <!-- Texto (centrado siempre) -->
        <div class="div2 text-center space-y-4">
            <p class="text-lg md:text-xl max-w-prose mx-auto ">
                Espero que al leer los hilos de sus historias encuentres algo de ti en ellas que te ayuden a pensar de
                otras formas sobre la belleza que nos atraviesa en el espejo.
            </P>
        </div>
        <!-- Imagen -->
        <div class="text-center ">
            <img src="portada9.png" alt=" " class="max-h-[500px] object-contain">
        </div>

    </div>
</section>

<section id="contact8" class="py-20 justify-center items-center text-4xl bg-white text-black">
    <div class="text-center ">
        <h2 class="text-2xl md:text-3xl tracking-wide">• Escoge un espejo •</h2>
    </div>
</section>

<section id="contact5" class="flex justify-center items-center text-4xl bg-white text-black">

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
    const opciones = document.querySelectorAll('#opciones1 .opcion');
    const respuesta = document.getElementById('respuesta');

    opciones.forEach(op => {
        op.addEventListener('click', e => {
            e.preventDefault();

            // quitar selección de todos
            opciones.forEach(o => o.classList.remove('selected'));

            // marcar la opción clicada
            op.classList.add('selected');

            // mostrar el texto de la opción en el párrafo
            respuesta.textContent = `${op.textContent.trim()}`;
        });
    });

    const opciones2 = document.querySelectorAll('#opciones2 .opcion2');
    const respuesta2 = document.getElementById('respuesta2');

    opciones2.forEach(op => {
        op.addEventListener('click', e => {
            e.preventDefault();

            // quitar selección de todas
            opciones2.forEach(o => o.classList.remove('selected'));

            // marcar clicada
            op.classList.add('selected');

            // mostrar el valor elegido
            respuesta2.textContent = `${op.textContent.trim()}.`;
        });
    });

    const menu = document.getElementById('menu');
    const hero = document.getElementById('home');

    // 1) Mostrar/ocultar el menú cuando SALES del hero (sin mágicos "80px")
    const io = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
            // Hero visible → ocultar menú
            menu.classList.remove('opacity-100', 'pointer-events-auto');
            menu.classList.add('opacity-0', 'pointer-events-none');
        } else {
            // Hero NO visible → mostrar menú
            menu.classList.remove('opacity-0', 'pointer-events-none');
            menu.classList.add('opacity-100', 'pointer-events-auto');
        }
    }, { threshold: 0.05 });
    io.observe(hero);

    // 2) Utilidades para detectar el color de fondo "efectivo" bajo el nav
    function parseRGB(rgbStr) {
        const m = rgbStr && rgbStr.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([0-9.]+))?\)/);
        if (!m) return { r: 255, g: 255, b: 255, a: 1 };
        return { r: +m[1], g: +m[2], b: +m[3], a: m[4] !== undefined ? +m[4] : 1 };
    }
    function relativeLuminance(r, g, b) {
        const s = [r, g, b].map(v => {
            v /= 255;
            return (v <= 0.03928) ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
        });
        return 0.2126 * s[0] + 0.7152 * s[1] + 0.0722 * s[2];
    }
    function getEffectiveBgColor(el) {
        let e = el;
        while (e && e !== document.documentElement) {
            const cs = getComputedStyle(e);
            const { r, g, b, a } = parseRGB(cs.backgroundColor);
            if (a > 0) return { r, g, b }; // en cuanto no sea transparente, devolvemos
            e = e.parentElement;
        }
        const { r, g, b } = parseRGB(getComputedStyle(document.body).backgroundColor || 'rgb(255,255,255)');
        return { r, g, b };
    }

    // 3) Detecta qué hay debajo del nav y aplica clase de contraste
    function adjustMenuContrast() {
        // Punto de muestra: centro horizontal, un poco debajo del tope del nav
        const navH = menu.getBoundingClientRect().height || 56;
        const x = window.innerWidth / 2;
        const y = Math.max(8, navH + 1);

        // Ignoramos el propio nav para "ver" lo de atrás
        const oldPE = menu.style.pointerEvents;
        menu.style.pointerEvents = 'none';
        const behind = document.elementFromPoint(x, y) || document.body;
        menu.style.pointerEvents = oldPE;

        // Color efectivo del fondo y luminancia
        const { r, g, b } = getEffectiveBgColor(behind);
        const L = relativeLuminance(r, g, b);
        const onLight = L >= 0.5; // umbral: >= 0.5 lo tratamos como fondo claro

        menu.classList.toggle('menu-on-light', onLight);
        menu.classList.toggle('menu-on-dark', !onLight);
    }

    // Recalcular en scroll/resize/load
    window.addEventListener('scroll', adjustMenuContrast, { passive: true });
    window.addEventListener('resize', adjustMenuContrast);
    window.addEventListener('load', () => {
        // Animaciones iniciales del hero
        gsap.from("h1", { opacity: 0, y: -50, duration: 1, ease: "power2.out" });
        gsap.from("p", { opacity: 0, y: 20, duration: 1, delay: 0.5, ease: "power2.out" });

        // Estado inicial
        adjustMenuContrast();
    });

    gsap.registerPlugin(ScrollTrigger);

    gsap.utils.toArray(".card").forEach((card, i) => {
        gsap.fromTo(".card",
            { y: 80, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 1,
                ease: "power3.out",
                stagger: 0.3, // retraso entre tarjetas
                scrollTrigger: {
                    trigger: "#cards-container",
                    start: "top 85%",
                    end: "bottom 60%",
                    toggleActions: "play none none none",
                }
            }
        );

    });
</script>
</body>
</html>
</div>
<div class="pb-40"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>


@endsection
