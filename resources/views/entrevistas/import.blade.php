@extends('layouts.app')
@section('title','Importar (genérico)')
@section('content')
<div class="max-w-xl mx-auto p-6 space-y-4">
    <br><br><br>
  <h1 class="text-xl font-semibold">Importar datos a cualquier tabla</h1>
  <p class="text-sm text-gray-600">
    El archivo debe tener <strong>encabezados</strong>. Los nombres de los encabezados se usan como nombres de columnas en la tabla destino.
  </p>

  @if ($errors->any())
    <div class="p-3 rounded bg-red-50 text-red-700">
      <ul class="list-disc ml-5">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  @if (session('ok'))
    <div class="p-3 rounded bg-green-50 text-green-700">{{ session('ok') }}</div>
  @endif

  <form action="{{ route('entrevistas.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
    @csrf
    <div>
      <label class="block text-sm font-medium mb-1">Tabla destino (exacta)</label>
      <input type="text" name="table" placeholder="entrevistas" required class="border rounded p-2 w-full">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Archivo (.xlsx / .xls / .csv)</label>
      <input type="file" name="file" accept=".xlsx,.xls,.csv,text/csv,text/plain" required class="border rounded p-2 w-full">
    </div>

    <button class="px-4 py-2 rounded bg-black text-white">Importar</button>
  </form>

  <div class="text-xs text-gray-500">
    • Si un encabezado no existe en la tabla, se ignora. <br>
    • Si ningún encabezado coincide con la tabla, no se procesa. <br>
    • Timestamps <code>created_at</code>/<code>updated_at</code> se rellenan si existen en la tabla y no vienen en el archivo.
  </div>
</div>
@endsection
