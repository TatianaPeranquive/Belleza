@extends('layouts.app')

@section('title', 'Entrevistas - Espejito, espejito')

@section('content')
<div class="relative min-h-screen">

    {{-- Fondo decorativo --}}
    <img src="{{ asset('EspejosSalon.png') }}" alt="Fondo decorativo"
         class="pointer-events-none absolute inset-0 opacity-20 object-cover w-full h-full z-0" />

    {{-- Barra fija arriba --}}
    <nav class="fixed top-0 left-0 w-full p-4 z-[200] bg-[#34113F]/80 backdrop-blur">
        <a href="{{ route('home') }}" class="text-[#f8f8fa] font-bold text-lg hover:underline">
            Espejito, espejito
        </a>
    </nav>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="relative z-10 pt-28 pb-16">

        {{-- Título --}}
        <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-10 text-[#111827]">
            Salón de espejos
        </h1>

        {{-- GRID DE TARJETAS --}}
        <div class="mx-auto max-w-5xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($cards as $card)
                <a href="{{ route('entrevistas.show', $card['slug']) }}"
                   class="card block w-full p-6 rounded-2xl shadow-lg ring-1 transition
                          transform hover:-translate-y-1 hover:shadow-xl {{ $card['colStart'] }}"
                   style="background-color: {{ $card['bg'] }}; border-color: {{ $card['border'] }};">
                    <h2 class="font-semibold text-xl text-center"
                        style="color: {{ $card['text'] }};">
                        {{ $card['name'] }}
                    </h2>
                </a>
            @endforeach
        </div>

        {{-- BOTÓN ABAJO --}}
        <div class="mt-12 flex items-center justify-center">
            <button id="btnWarnBack" type="button"
                class="inline-flex items-center gap-3 rounded-3xl px-10 py-4 text-lg font-bold
                       text-white
                       bg-[#34113F]
                       hover:bg-[#D9CCE7] hover:text-[#34113F]
                       focus:outline-none
                       focus:ring-4 focus:ring-[#D9CCE7]
                       transition-all duration-200
                       disabled:opacity-50">
                Mírate al espejo
            </button>
        </div>

    </main>
</div>




{{-- Animación --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
  if (typeof gsap !== 'undefined') {
    gsap.fromTo(".card",
      { y: 40, opacity: 0 },
      { y: 0, opacity: 1, duration: 0.6, stagger: 0.12, ease: "power3.out" }
    );
  }

        const btnWarnBack     = document.getElementById('btnWarnBack');
      //  window.location.href = "{{ route('entrevistas.index') }}";
        document.addEventListener('DOMContentLoaded', () => {
        const btnWarnBack = document.getElementById('btnWarnBack');
        btnWarnBack.addEventListener('click', () => {
            window.location.href = "{{ route('espejo.paint') }}";
        });
        });
</script>
@endsection
