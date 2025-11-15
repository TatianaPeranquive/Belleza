@extends('layouts.app')

@section('title', 'Diccionario - ' . ucfirst($palabra))

@section('content')

        class="fixed top-0 left-0 w-full h-16 md:h-20 flex items-center px-4
               z-[9999] bg-[#34113F]/80 backdrop-blur pointer-events-auto shadow-lg">
        <a href="{{ route($volverRoute ?? 'diccionario.buscar', 'campana') }}"
           class="text--[#34113F] font-bold text-lg hover:underline">
            &larr; Volver
        </a>
    </nav>

  <div class="h-[160px] md:h-[180px]"></div>

    <section class="min-h-screen pb-16 px-6 md:px-10">
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Espejo – demo rápida</title>
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Píldora */
    .pill { @apply rounded-full px-6 py-2 text-center shadow-sm; }
    /* Área del espejo: contenedor relativo para superponer el canvas */
    .mirror-wrap { position: relative; width: 320px; margin: 0 auto; }
    .mirror-img   { width: 100%; height: auto; display:block; }
    /* Canvas centrado dentro del “cristal” (ajusta estos inset a tu gráfico) */
    .mirror-canvas {
      position:absolute; inset: 18% 20% 22% 20%;  /* top right bottom left */
      border-radius: 9999px; /* simulamos óvalo */
      background: transparent;
    }
    /* Vista previa del selfie recortada en óvalo (opcional) */
    .selfie-preview {
      position:absolute; inset: 18% 20% 22% 20%;
      border-radius:9999px; object-fit: cover; display:none;
    }
  </style>
</head>
<body class="bg--[#34113F] text-[#34113F]">

  <!-- Barra superior con botón -->
  <div class="w-full flex justify-center mt-4">
    <label class="pill bg-gray-100 cursor-pointer">
      <input id="selfie" type="file" accept="image/*" class="hidden" />
      Sube un selfie
    </label>
  </div>

  <!-- Cintillos -->
  <div class="max-w-xl mx-auto mt-4 space-y-2">
    <div class="pill bg-gray-300">¿Cuando te miras al espejo qué ves?</div>
    <div class="pill bg-yellow-100">Dibuja o escribe lo que quieras</div>
  </div>

  <!-- Zona central -->
  <section class="max-w-5xl mx-auto mt-6 grid grid-cols-12 gap-6 items-start">
    <!-- Columna izquierda (cosméticos) -->
    <aside class="col-span-2 flex flex-col items-center gap-6">
      <img src="lip1.png" alt="" class="w-8 sm:w-10" />
      <img src="makeup2.png" alt="" class="w-14 sm:w-16" />
      <img src="lip2.png" alt="" class="w-9 sm:w-11" />
    </aside>

    <!-- Centro: espejo con canvas -->
<main class="col-span-8">
  <div class="div1 flex justify-center">
    <img id="imagenEspejo" src="espejo.png" alt="Espejo" class="max-h-[500px] object-contain">
  </div>

  <div class="flex justify-center gap-3 mt-4 text-sm">
    <button id="download" class="px-3 py-1 border rounded">Descargar imagen</button>
  </div>
</main>


    <!-- Columna derecha (espaciador) -->
    <div class="col-span-2"></div>
  </section>

  <script>
    // --- Canvas de dibujo (rojo)
    const canvas = document.getElementById('draw');
    const ctx = canvas.getContext('2d');
    const parent = canvas.parentElement;

    function resizeCanvas() {
      const r = parent.getBoundingClientRect();
      const c = canvas.getBoundingClientRect();
      // Ajustamos tamaño real del canvas para alta resolución
      canvas.width  = Math.floor(c.width  * devicePixelRatio);
      canvas.height = Math.floor(c.height * devicePixelRatio);
      ctx.scale(devicePixelRatio, devicePixelRatio);
      ctx.lineWidth = 4; ctx.lineJoin="round"; ctx.lineCap="round"; ctx.strokeStyle = "#e11d48"; // rojo
    }
    // Espera a que se calcule el layout
    new ResizeObserver(resizeCanvas).observe(canvas);

    let drawing = false, last = null;
    const pos = (e) => {
      if (e.touches && e.touches[0]) {
        const rect = canvas.getBoundingClientRect();
        return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
      } else {
        const rect = canvas.getBoundingClientRect();
        return { x: e.clientX - rect.left, y: e.clientY - rect.top };
      }
    };

    const start = (e) => { drawing = true; last = pos(e); e.preventDefault(); };
    const move  = (e) => {
      if (!drawing) return;
      const p = pos(e);
      ctx.beginPath(); ctx.moveTo(last.x, last.y); ctx.lineTo(p.x, p.y); ctx.stroke();
      last = p; e.preventDefault();
    };
    const end   = () => { drawing = false; last = null; };

    canvas.addEventListener('mousedown', start);
    canvas.addEventListener('mousemove', move);
    window.addEventListener('mouseup', end);
    canvas.addEventListener('touchstart', start, {passive:false});
    canvas.addEventListener('touchmove',  move,  {passive:false});
    window.addEventListener('touchend',   end);

    document.getElementById('clear').onclick = () => {
      ctx.clearRect(0,0,canvas.width,canvas.height);
    };

    document.getElementById('download').onclick = () => {
        const img = document.getElementById('imagenEspejo');
        const link = document.createElement('a');
        link.href = img.src;            // usa la ruta del <img>
        link.download = 'espejo.png';   // nombre del archivo a descargar
        link.click();
    };

    // --- Selfie (opcional): mostrar dentro del óvalo
    const fileInput = document.getElementById('selfie');
    const selfiePrev = document.getElementById('selfiePrev');
    fileInput.addEventListener('change', (e) => {
      const f = e.target.files?.[0];
      if (!f) return;
      const url = URL.createObjectURL(f);
      selfiePrev.src = url;
      selfiePrev.style.display = 'block';
    });
  </script>
</body>
</html>

    </section>
@endsection
