@extends('layouts.app')

@section('title', strtoupper($nombre).' - ENTREVISTA')

@section('content')
<nav class="fixed top-0 left-0 w-full p-4 z-[200] bg-black/80 backdrop-blur">
  <a href="{{ route('entrevistas.index') }}" class="text-white font-bold text-lg">&larr; Volver</a>
</nav>

<section class="min-h-screen flex flex-col justify-center items-center text-center pt-20 px-8">
  <h1 class="text-5xl font-bold mb-6 uppercase">{{ $nombre }}</h1>

  <div class="max-w-5xl w-full grid md:grid-cols-2 gap-10 items-center">
    <img src="{{ asset($foto) }}" alt="{{ $nombre }}" class="w-80 h-80 object-cover rounded-xl mx-auto shadow-lg" />
    <div class="text-left">
      <p class="text-xl leading-relaxed">{{ $perfil }}</p>
      <ul class="mt-4 text-sm opacity-80 space-y-1">
        <li><strong>Oficio:</strong> {{ $oficio ?? '—' }}</li>
        <li><strong>Locación:</strong> {{ $locacion ?? '—' }}</li>
      </ul>
      <p> {{ $respuesta ?? '—' }} Frase introductoria  </p>
    </div>
  </div>

  <br><br>
    <div class="w-full grid gap-10 items-center">
        <p> {{ $respuesta ?? '—' }} </p>
    </div>
  <audio controls class="mt-10">
    <source src="{{ asset($audio) }}" type="audio/mpeg">
    Tu navegador no soporta audio HTML5.
  </audio>
</section>
@endsection
