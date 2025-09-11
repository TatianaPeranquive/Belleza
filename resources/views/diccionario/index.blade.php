@extends('layouts.app')

@section('title', 'Diccionario')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Diccionario</h1>
    <ul class="list-disc pl-5">
        @foreach($palabras as $item)
            <li>
                <a href="{{ route('diccionario.show', $item->palabra) }}"
                   class="text-blue-600 hover:underline capitalize">
                    {{ $item->palabra }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
