@extends('layouts.app')

@section('title', 'Home - Proyecto Espejo')
@section('content')

@include('layouts.efecto_espejo')
<div class="relative">
  {{-- Fondo detrás (efecto_espejo) --}}
  <div class="absolute inset-0 -z-10">
    @include('layouts.efecto_espejo')
  </div>

  {{-- Contenido principal encima --}}
  <section id="home" class="h-screen flex flex-col justify-center items-center text-center">
    <div class="flex flex-col items-center gap-5 w-full max-w-screen-lg">
      <div class="p-4 rounded max-w-xs w-full text-center">
          <h1 class="text-4xl font-bold">BIENVENIDO</h1>
      </div>
      <div class="p-4 rounded max-w-xs w-full text-center">
          <p class="text-lg leading-relaxed">
              Explora las <strong>entrevistas</strong>, <strong>llena tu espejo</strong> y conoce más sobre nosotros en <strong>Detrás del Espejo</strong>.
          </p>
      </div>
    </div>
  </section>
</div>


<div class="pb-40"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script>
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

@endsection
