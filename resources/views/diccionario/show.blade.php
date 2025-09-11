@extends('layouts.app')

@section('title', 'Diccionario - ' . ucfirst($palabra))

@section('content')

        class="fixed top-0 left-0 w-full h-16 md:h-20 flex items-center px-4
               z-[9999] bg-black/80 backdrop-blur pointer-events-auto shadow-lg">
        <a href="{{ route($volverRoute ?? 'diccionario.buscar', 'campana') }}"
           class="text-white font-bold text-lg hover:underline">
            &larr; Volver
        </a>
    </nav>

  <div class="h-[160px] md:h-[180px]"></div>

    <section class="min-h-screen pb-16 px-6 md:px-10">
        <div class="max-w-6xl mx-auto">
            {{-- Título de página --}}
            <header class="text-center mb-10">
                <h1 class="text-4xl font-bold mb-6 tracking-tight capitalize">
                    {{ $palabra }}
                </h1>
            </header>


            <div class="text-center">
                @if($definicion)
                    <pre class="text-left whitespace-pre-wrap">{{ $definicion }}</pre>
                @else
                    <p class="text-red-400">No encontramos la definición de "{{ $palabra }}".</p>
                @endif
            </div>
        </div>
    </section>
@endsection
