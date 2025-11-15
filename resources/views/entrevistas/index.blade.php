@extends('layouts.app')

@section('title', 'Entrevistas - Proyecto Espejo')

@section('content')
@php
    // Cambia esto a false para volver a usar los colores de BD por tarjeta
    $useThemeColors = true;
    $palette = $themeConfig['card_bg'] ?? ['#F3F4F6','#E5E7EB','#D1D5DB','#F9FAFB'];

    $total = count($cards);
@endphp

<div class="relative min-h-screen">

    <img src="{{ asset('fondo_index.png') }}" alt="Fondo decorativo"
       class="pointer-events-none absolute inset-0 opacity-20 object-cover w-full h-full z-0" />

    <nav class="fixed top-0 left-0 w-full p-4 z-[200] bg-[#34113F]/80 backdrop-blur">
        <a href="{{ route('home') }}" class="text-[#f8f8fa] font-bold text-lg hover:underline">Espejito, espejito</a>
    </nav>

    <div class="relative z-10 flex flex-col items-center text-center px-4 pt-5 pb-16">
         <h1 class="text-4xl font-bold mb-12">Salón de espejos</h1>
    <div class="mx-auto max-w-5xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($cards as $card)
        @php
            $index       = $loop->index;
            $isLast      = $loop->last;
            $mod         = $total % 3;

            // si el total deja 1 suelta (ej: 7, 10, 13...) la última va al centro
            $forceMiddle = $isLast && $mod === 1;

            // columna lógica para elegir color
            if ($forceMiddle) {
                $colIndex = 1;    // columna central
            } else {
                $colIndex = $index % 3; // 0,1,2,0,1,2...
            }

            switch ($colIndex) {
                case 0:  $baseBg = '#D4F2D2'; break; // verde suave
                case 1:  $baseBg = '#BEB7DF'; break; // lila
                default: $baseBg = '#ABA9BF'; break; // gris-lila
            }

            $isSelected  = !empty($card['selected']);
            $bgColor     = $isSelected ? '#34113F' : $baseBg;
            $textColor   = $isSelected ? '#F9FAFB' : '#111827';
            $borderColor = $isSelected ? '#BEB7DF' : '#ABA9BF';

            $cardClasses = 'card block w-full p-6 rounded-2xl shadow-lg ring-1 transition
                            transform hover:-translate-y-1 hover:shadow-xl';
            if ($forceMiddle) {
                $cardClasses .= ' lg:col-start-2';
            }
        @endphp

        @if (!empty($card['slug']))
            <a href="{{ route('entrevistas.show', $card['slug']) }}"
               class="{{ $cardClasses }}"
               style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }};">
                <h2 class="font-semibold text-xl text-center" style="color: {{ $textColor }};">
                    {{ $card['name'] }}
                </h2>
            </a>
        @else
            <div class="{{ $cardClasses }}"
                 style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }};">
                <h2 class="font-semibold text-xl text-center" style="color: {{ $textColor }};">
                    {{ $card['name'] }}
                </h2>
            </div>
        @endif

    @endforeach
</div>
  </div>
  <div class="mb-4 flex items-center justify-center">
    <button id="btnWarnBack" type="button"
        class="inline-flex items-center gap-3 rounded-3xl px-10 py-4 text-lg font-bold
                text-white
                bg-[#34113F]
                hover:bg-[#BEB7DF] hover:text-[#34113F]
                focus:outline-none
                focus:ring-4 focus:ring-[#D9CCE7]
                transition-all duration-200
                disabled:opacity-50">
        Mírate al espejo
    </button>

</div>
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
