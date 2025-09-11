@extends('layouts.app')
@section('content')

<div class="container mx-auto text-center p-10">
    <h1 class="text-4xl font-bold mb-6">Bienvenido</h1>
    <p class="mb-4">Explora las entrevistas, llena tu espejo y conoce más sobre nosotros en detrás del espejo.</p>
    <div class="mt-6">
        <button id="playBtn" class="bg-green-500 px-4 py-2 text-white rounded">▶ Play Audio</button>
        <button id="pauseBtn" class="bg-red-500 px-4 py-2 text-white rounded">⏸ Pause Audio</button>
    </div>
</div>
<script>
    const audio = new Audio('{{ asset("storage/audio/audio1.mp3") }}');
    document.getElementById('playBtn').addEventListener('click', () => audio.play());
    document.getElementById('pauseBtn').addEventListener('click', () => audio.pause());
</script>
@endsection
