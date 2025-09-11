@extends('layouts.app')

@section('title', 'Entrevistas - Proyecto Espejo')

@section('content')
@php
  // Cambia esto a false si quieres volver a usar los colores de BD por tarjeta
  $useThemeColors = true;

  // Paleta de tarjetas según el tema activo (inyectado desde AppServiceProvider)
  $palette = $themeConfig['card_bg'] ?? ['#F3F4F6','#E5E7EB','#D1D5DB','#F9FAFB'];
@endphp

<div class="relative min-h-screen">

    <img src="{{ asset('fondo_index.png') }}" alt="Fondo decorativo"
       class="pointer-events-none absolute inset-0 opacity-20 object-cover w-full h-full z-0" />



    <nav class="fixed top-0 left-0 w-full p-4 z-[200] bg-black/80 backdrop-blur">
        <a href="{{ route('home') }}" class="text-white font-bold text-lg hover:underline">&larr; Volver</a>
    </nav>

  <div class="relative z-10 flex flex-col items-center text-center px-4 pt-40 pb-16">
    <h1 class="text-4xl font-bold mb-12">Entrevistas</h1>

    <div id="cards-container"
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full max-w-6xl">
      @foreach($cards as $card)
        @php
          $bg = $useThemeColors
                ? $palette[$loop->index % count($palette)]
                : ($card['color'] ?? $palette[$loop->index % count($palette)]);
        @endphp

        @if(!empty($card['slug']))
          <a href="{{ route('entrevistas.show', $card['slug']) }}"
             class="card p-6 rounded shadow-lg transition transform hover:-translate-y-1 hover:shadow-xl ring-1"
             style="background-color: {{ $bg }}; {{ $theme === 'dark' ? 'border-color:#334155;' : 'border-color:#E5E7EB;' }}">
            <h2 class="font-semibold text-xl"
                style="color: {{ $theme === 'dark' ? '#F9FAFB' : '#111827' }};">
              {{ $card['name'] }}
            </h2>
          </a>
        @else
          <div class="card p-6 rounded shadow-lg opacity-90 ring-1"
               style="background-color: {{ $bg }}; {{ $theme === 'dark' ? 'border-color:#334155;' : 'border-color:#E5E7EB;' }}">
            <h2 class="font-semibold text-xl"
                style="color: {{ $theme === 'dark' ? '#F9FAFB' : '#111827' }};">
              {{ $card['name'] }}
            </h2>
          </div>
        @endif
      @endforeach
    </div>
  </div>
</div>

{{-- Animación simple (opcional) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
  if (typeof gsap !== 'undefined') {
    gsap.fromTo(".card",
      { y: 40, opacity: 0 },
      { y: 0, opacity: 1, duration: 0.6, stagger: 0.12, ease: "power3.out" }
    );
  }
</script>
@endsection
