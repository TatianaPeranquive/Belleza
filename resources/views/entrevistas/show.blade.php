@extends('layouts.app') @section('title')
{{ $tituloPagina ?? ($nombre ?? "Entrevista") }}
@endsection @section('content')
{{-- Barra fija de "Volver" SIEMPRE por encima del header global --}}
<nav
    class="fixed top-0 left-0 w-full h-16 md:h-20 flex items-center px-4 z-[9999] bg-[#34113F]/80 backdrop-blur pointer-events-auto">
    <a href="{{ route($volverRoute ?? 'entrevistas.index') }}" class="text-[#f8f8fa] font-bold text-lg"> Espejito, espejito</a>
</nav>

{{-- SPACER: empuja TODO por debajo de lo que tape arriba.
Si tu header global también es fijo, este tamaño grande evita solapes.
Ajusta si quieres: h-[140px] / h-[160px] / h-[180px] --}}
<div class="h-[160px] md:h-[180px]"></div>

<section class="min-h-screen pb-16 px-6 md:px-10">
    <div class="max-w-6xl mx-auto">
        {{-- Título de página (no se tapa gracias al spacer) --}}
        <header class="text-center mb-10">
            <h1 class="text-4xl font-bold mb-6 tracking-tight">
                {{ $tituloPagina ?? ($nombre ?? "Entrevista") }}
            </h1>
        </header>

        @if(isset($autoras) && is_array($autoras))
        {{-- === MODO MÚLTIPLE (apilado): una debajo de la otra === --}}
        <div class="max-w-5xl mx-auto space-y-16">
            @foreach($autoras as $a)
            <article class="grid md:grid-cols-2 gap-10 items-start">
                {{-- Foto --}}
                <div class="flex flex-col items-center">
                    <img src="{{ asset($a['foto']) }}" alt="{{ $a['nombre'] }}"
                        class="w-80 h-80 md:w-[22rem] md:h-[22rem] object-cover rounded-2xl shadow-xl ring-1 ring-[#f8f8fa]/10" />
                    <div class="mt-4 h-1 w-40 rounded-full" style="background-color: {{
                            $a['color'] ?? '#96D1C5'}};"></div>
                </div>

                {{-- Perfil + datos + audio --}}
                <div>
                    <h2 class="text-2xl font-bold">
                        {{ $a["nombre"] }}
                    </h2>
                    <p class="text-xl leading-relaxed mt-3">
                        {{ $a["perfil"] }}
                    </p>
                    <ul class="mt-4 text-sm opacity-90 space-y-1">

                        <span class="font-semibold">Edad:</span>
                        {{ $a["edad"] ?? "—" }}
                        </li>
                        <li>
                            <span class="font-semibold">Oficio:</span>
                            {{ $a["oficio"] ?? "—" }}
                        </li>
                    </ul>

                    <br /><br />
                    <div class="bg-gray-200 w-full grid gap-10 items-center fade-in">
                        {!! strip_tags($respuesta, '<p><strong><em><b><i><br>') !!}
                    </div>
                </div>
            </article>

            @if(!$loop->last)
            <hr class="border-t border-[#f8f8fa]/10 my-2" />
            @endif @endforeach
        </div>

        @else
        {{-- === MODO UNA SOLA PERSONA === --}}
        <div class="max-w-5xl w-full mx-auto grid md:grid-cols-2 gap-10 items-center">
            <img src="{{ asset($foto) }}" alt="{{ $nombre }}"
                class="w-80 h-80 object-cover rounded-xl mx-auto shadow-lg" />
            <div class="text-left">
                <h2 class="sr-only">{{ $nombre }}</h2>
                <p class="text-xl leading-relaxed">{{ $perfil }}</p>
                <ul class="mt-4 text-sm opacity-80 space-y-1">
                    <li><strong>Edad:</strong> {{ $edad ?? "—" }}</li>
                    <li><strong>Oficio:</strong> {{ $oficio ?? "—" }}</li>
                    <br><br>
                </ul>
            </div>
        </div>
        <br><br>
        <div class="bg-gray-200 w-full grid gap-10 items-center fade-in">
            {!! strip_tags($respuesta, '<p><strong><em><b><i><br>') !!}
        </div>

        @endif
    </div>
</section>
@endsection
