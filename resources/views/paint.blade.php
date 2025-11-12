<!DOCTYPE html>
<html lang="es">

@extends('layouts.app') @section('title')
{{ $tituloPagina ?? ($nombre ?? "Entrevista") }}
@endsection @section('content')
{{-- Barra fija de "Volver" SIEMPRE por encima del header global --}}
<nav
    class="fixed top-0 left-0 w-full h-16 md:h-20 flex items-center px-4 z-[9999] bg-black/80 backdrop-blur pointer-events-auto">
    <a href="{{ route($volverRoute ?? 'entrevistas.index') }}" class="text-white font-bold text-lg">&larr; Espejito,
        espejito</a>
</nav>

{{-- SPACER: empuja TODO por debajo de lo que tape arriba.
Si tu header global también es fijo, este tamaño grande evita solapes.
Ajusta si quieres: h-[140px] / h-[160px] / h-[180px] --}}
<div class="h-[160px] md:h-[100px]"></div>

<head>
    <meta charset="UTF-8">
    <title>Dibujar sobre imagen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --bar-h: 48px;
            --subbar-h: 44px;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Inter, Arial, sans-serif;
            background: #f8fafc;
            color: #0f172a
        }

        .bar {
            position: sticky;
            top: 0;
            display: flex;
            align-items: center;
            gap: .5rem;
            height: var(--bar-h);
            padding: 0 .75rem;
            background: #fff;
            backdrop-filter: saturate(180%) blur(8px);
            border-bottom: 1px solid #e2e8f0;
            z-index: 50
        }

        /* === Barra de herramientas === */
        .subbar {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: 0.2rem 0.5rem;
            min-height: 7px;
            background: transparent !important;
            border: none !important;
            position: relative;
            z-index: 1;
        }

        /* Distribución */
        .subbar .left {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .subbar .center {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .subbar .right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: auto;
        }

        .field {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.9rem;
        }

        /* === Botones generales === */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.42rem 0.75rem;
            border: 1px solid #111;
            border-radius: 9999px;
            background: #fff;
            color: #111;
            font-weight: 600;
            line-height: 1;
            white-space: nowrap;
            box-shadow: inset 0 -2px rgba(0, 0, 0, 0.06);
            cursor: pointer;
            transition: transform 0.05s ease, background 0.15s ease, color 0.15s ease;
        }

        .btn {
            padding: .4rem .7rem;
            border: 1px solid #cbd5e1;
            border-radius: .6rem;
            background: #fff;
            color: #334155;
            font-size: .9rem;
            cursor: pointer
        }

        .btn[disabled] {
            opacity: .5;
            cursor: not-allowed
        }

        /* Clic → negro */
        .btn:active,
        .chip:active {
            background: #000;
            color: #fff;
            transform: translateY(1px);
        }

        /* Estado activo (si el JS aplica .active) */
        .btn.active,
        .chip.active {
            background: #f4f4f5;
        }

        /* === Botón “Cargar imagen” === */
        .btn--upload {
            font-size: 1.05rem;
            padding: 0.7rem 1.4rem;
            background: #ffdce9;
            border-color: #d7a9bb;
            box-shadow: inset 0 -3px rgba(0, 0, 0, 0.07);
            animation: pulseUpload 2.2s ease-in-out 0s 20;
            /* ← solo 3 veces */
        }

        .btn--upload:hover {
            filter: brightness(1.05);
        }

        .btn--upload:active {
            background: #000;
            color: #fff;
            animation: none;
            /* detiene el pulso al hacer clic */
        }

        /* Animación de pulso suave */
        @keyframes pulseUpload {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 #D9CCE7;
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 8px 4px #BEB7DF;
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 #34113F;
            }
        }

        /* Oculta el input real */
        #file {
            display: none;
        }

        /* Asegura que “chip” herede el mismo estilo */
        .chip {
            all: unset;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.42rem 0.75rem;
            border: 1px solid #111;
            border-radius: 9999px;
            background: #fff;
            color: #111;
            font-weight: 600;
            cursor: pointer;
            box-shadow: inset 0 -2px rgba(0, 0, 0, 0.06);
            transition: transform 0.05s ease, background 0.15s ease, color 0.15s ease;
        }



        .btn-primary {
            border-color: #d4f2d2;
            color: #065f46;
            background: #ecfdf5
        }

        .chip {
            padding: .4rem .7rem;
            border: 1px solid #cbd5e1;
            border-radius: 6rem;
            background: #fff;
            color: #334155;
            font-size: .85rem;
            cursor: pointer;
            white-space: nowrap
        }

        .chip.active {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a
        }

        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 12px
        }

        .stage-box {
            position: relative;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
            overflow: hidden
        }

        .stage {
            position: relative;
            touch-action: none
        }

        .bg {
            display: block;
            user-select: none;
            -webkit-user-drag: none
        }

        canvas {
            position: absolute;
            inset: 0;
            background: transparent;
            z-index: 10
        }

        .help {
            color: #64748b;
            font-size: .8rem;
            margin-top: .5rem
        }

        .spacer {
            height: .5rem
        }

        .field {
            display: flex;
            align-items: center;
            gap: .4rem
        }

        .field input[type="range"] {
            width: 160px
        }

        /* Tarjeta flotante (oculta hasta hover inicial) */
        .q-fly {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow:
                0 12px 24px rgba(2, 6, 23, .06),
                0 2px 6px rgba(2, 6, 23, .03);
            padding: 12px;
            color: #0f172a;
            height: 100%;
            /* ocupa todo el alto disponible */
            display: flex;
            flex-direction: column;
            gap: 10px;

            /* estado inicial (oculta/afuera) */
            transform: translateX(-100px) scale(.92);
            opacity: 0;
            filter: blur(4px);
            will-change: transform, opacity, filter;
        }

        .q-fly.hidden {
            display: none;
        }

        .q-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .q-body {
            line-height: 1.35;
            overflow: auto;
        }

        /* Animaciones helper (usamos Web Animations en JS, pero estos son útiles si precisas fallback) */
        @keyframes flyIn {
            0% {
                transform: translateX(-100px) scale(.92);
                opacity: 0;
                filter: blur(4px);
            }

            100% {
                transform: translateX(0) scale(1);
                opacity: 1;
                filter: blur(0);
            }
        }

        @keyframes flyOut {
            0% {
                transform: translateX(0) scale(1);
                opacity: 1;
                filter: blur(0);
            }

            100% {
                transform: translateX(-80px) scale(.95);
                opacity: 0;
                filter: blur(4px);
            }
        }

        /* 3) Capas visibles: placeholder por encima del marco */
        #placeholder {
            z-index: 30 !important;
        }

        /* mensaje arriba */
        /* marco en medio */
        :root {
            --mirror-shift-x: 25%;
            /* Ajusta según necesites */
        }

        #frame,
        #bg {
            transform: translateX(var(--mirror-shift-x));
        }

        /* fondo abajo */

        /* --- Corrección de capas y eventos --- */
        /* Capas dentro del stage */


        #bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            z-index: 0;
        }

        #cv {
            position: absolute;
            inset: 1% 1% 1% 1%;
            /* top right bottom left */
            width: auto;
            height: auto;
            z-index: 10;
            pointer-events: auto;
            touch-action: none;
            display: block;
        }

        #frame {
            z-index: 20;
        }



        #placeholder {
            position: absolute;
            inset: var(--glass-inset);
            display: grid;
            text-align: left;
            color: #94a3b8;
            z-index: 10;
            pointer-events: none;
        }

        /* Inset del vidrio (TOP RIGHT BOTTOM LEFT). Ajusta a tu PNG. */
        :root {
            /* Ejemplo para el tocador clásico: */
            --glass-inset: 14% 13% 17% 13%;
        }

        #stage {
            position: relative;
            overflow: hidden;
        }

        /* Región del vidrio alineada con el hueco del marco */
        .glass {
            position: absolute;
            inset: var(--glass-inset);
            z-index: 10;
            overflow: hidden;
            /* Para que no se pinte fuera del vidrio (opcional) */
            display: grid;
            /* Nos permite centrar el placeholder */
            place-items: center;
        }

        /* Fondo oscuro bloqueante */
        .warn-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            /* encima de todo */
        }

        /* Tarjeta central del aviso */
        .warn-modal {
            background: #fff;
            border: 2px solid #dc2626;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            padding: 1.5rem;
            width: min(90vw, 420px);
            text-align: center;
        }

        /* Oculto por defecto (si ya aceptó antes) */
        .hidden {
            display: none !important;
        }


        /* Utilidad para ocultar */
        .hidden {
            display: none !important;
        }

        /* Overlay bloqueante */
        .warn-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .55);
            /* fondo oscuro */
            backdrop-filter: blur(2px);
            display: grid;
            place-items: center;
            z-index: 9999;
            /* por encima de todo */
        }

        /* Caja del modal */
        .warn-modal {
            width: min(560px, 92vw);
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow:
                0 18px 36px rgba(2, 6, 23, .14),
                0 4px 12px rgba(2, 6, 23, .06);
            padding: 20px;
        }

        /* (Opcional) Si usas .q-fly de antes, mantiene estilo */
        .q-fly {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(2, 6, 23, .06), 0 2px 6px rgba(2, 6, 23, .03);
            padding: 12px;
            color: #0f172a;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Botones base (si no los tienes ya) */
        .btn {
            padding: .45rem .8rem;
            border: 1px solid #cbd5e1;
            border-radius: .6rem;
            background: #fff;
            color: #334155;
            font-size: .95rem;
            cursor: pointer;
        }

        .btn-primary {
            border-color: #34d399;
            color: #065f46;
            background: #ecfdf5;
        }

        /* --- Reflexión al final del lienzo --- */
        .reflection-section {
            margin-top: 40px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
            padding: 20px;
            max-width: 900px;
            margin-inline: auto;
        }

        .reflection-title {
            font-weight: 800;
            font-size: 1.25rem;
            color: #0f172a;
            margin-bottom: .5rem;
        }

        .reflection-desc {
            color: #334155;
            line-height: 1.5;
            margin-bottom: .75rem;
        }

        .reflection-textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px;
            font: inherit;
            resize: vertical;
            min-height: 120px;
            color: #0f172a;
        }

        .reflection-actions {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
            margin-top: 10px;
        }

        /* --- Reflexión final --- */
        .hidden {
            display: none !important;
        }

        .reflection-section {
            margin-top: 40px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
            padding: 20px;
            max-width: 900px;
            margin-inline: auto;
        }

        .reflection-title {
            font-weight: 800;
            font-size: 1.25rem;
            color: #0f172a;
            margin-bottom: .5rem;
        }

        .reflection-desc {
            color: #334155;
            line-height: 1.5;
            margin-bottom: .75rem;
        }

        .reflection-textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px;
            font: inherit;
            resize: vertical;
            min-height: 120px;
            color: #0f172a;
        }

        .reflection-actions {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
            margin-top: 10px;
        }

        /* Contenedor que agrupa botón y tooltip */
        .tooltip-wrap {
            position: relative;
            display: inline-block;
        }

        /* Tooltip visual */
        .tooltip-text {
            position: absolute;
            bottom: 125%;
            /* justo encima del botón */
            left: 50%;
            transform: translateX(-50%);
            background: rgba(15, 23, 42, 0.95);
            color: #f8fafc;
            text-align: center;
            font-size: 0.85rem;
            line-height: 1.2;
            padding: 8px 10px;
            border-radius: 8px;
            width: max-content;
            max-width: 240px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
            white-space: normal;
            z-index: 999;
        }

        /* Triángulo del tooltip */
        .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: rgba(15, 23, 42, 0.95) transparent transparent transparent;
        }

        /* Mostrar tooltip al pasar el mouse */
        .tooltip-wrap:hover .tooltip-text {
            opacity: 1;
            transform: translate(-50%, -4px);
        }

        /* En pantallas táctiles puedes mantener el tooltip visible al tocar */
        @media (hover: none) {
            .tooltip-text {
                display: none;
            }
        }

        /* Tarjeta de instrucciones (delgada, fuera de la subbar) */
        .instructions-card {
            max-width: 1024px;
            margin: .4rem auto 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: rgba(249, 250, 251, .75);
            /* gris MUY leve y semitransparente */
            overflow: hidden;
        }

        /* Quita el triángulo por defecto y estiliza el header */
        .instructions-card>summary {
            list-style: none;
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .55rem .85rem;
            cursor: pointer;
            font-weight: 700;
            user-select: none;
        }

        .instructions-card>summary::-webkit-details-marker {
            display: none;
        }

        .instructions-card .marker {
            display: inline-flex;
            width: 1.35rem;
            height: 1.35rem;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            border: 1px solid #111;
            font-size: .9rem;
            line-height: 1;
            background: #fff;
            color: #111;
        }

        .instructions-card .hint {
            margin-left: auto;
            font-weight: 600;
            font-size: .85rem;
            color: #6b7280;
        }

        /* Contenido */
        .instructions-content {
            padding: .75rem .95rem 1rem;
            font-size: .95rem;
            line-height: 1.45;
            color: #111;

        }

        /* (Opcional) Animación de abrir/cerrar suave */
        .instructions-card .instructions-content {
            max-height: 600px;
            opacity: 1;
            transition: max-height .25s ease, opacity .25s ease;
        }

        .instructions-card:not([open]) .instructions-content {
            max-height: 0;
            opacity: 0;
            padding-top: 0;
            padding-bottom: 0;
            overflow: hidden;
        }

        .overlay{ position:fixed; inset:0; display:flex; align-items:center; justify-content:center;
        background:rgba(0,0,0,.55); backdrop-filter:blur(2px); z-index:1000; }
        .overlay.hidden{ display:none; }
        .modal{ background:#fff; border-radius:12px; padding:1.4rem 1.8rem; max-width:1000px; text-align:center; }
        .modal-title{ font-size:1.25rem; font-weight:800; margin-bottom:.6rem; }
        .modal-desc{ color:#333; margin-bottom:1rem; }


        /* Fondo Reflexión Fullscreen real: ancho completo */

/* === FULLSCREEN A PRUEBA DE FRAMEWORKS para el modal final === */
#finalOverlay{
  position: fixed !important;
  inset: 0 !important;
  z-index: 7000 !important;
  background: rgba(0,0,0,.55) !important;
  backdrop-filter: blur(3px);
}

/* La modal se pega a los 4 bordes del viewport */
#finalOverlay .modal{
  position: fixed !important;
  left: 0 !important; top: 0 !important; right: 0 !important; bottom: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  max-width: none !important;
  margin: 0 !important;
  border-radius: 0 !important;
  background: #fff !important;
  display: flex !important;
  flex-direction: column !important;
  box-shadow: none !important;
}

/* Header fijo arriba (opcional) */
#finalOverlay .modal-header{
  position: sticky; top: 0; z-index: 2;
  background: #fff;
  border-bottom: 1px solid #eee;
  padding: 12px 20px;
}

/* Cuerpo con scroll vertical y sin límites de ancho */
#finalOverlay .modal-body {
  position: relative;
  z-index: 1;
  margin: 0 auto;

  /* 🔧 más angosto y un poco más alto */
  width: min(55vw, 750px);         /* antes 65vw */
  max-height: min(70vh, 680px);    /* antes 60vh */

  overflow-y: auto;
  padding: 2.8rem 3.2rem;
  background: rgba(255, 255, 255, 0.85);
  border-radius: 16px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);

  font-size: 1.05rem;
  line-height: 1.7;
  color: #111;

  backdrop-filter: blur(2px);
}



/* Forzar que nada adentro se auto-estreche (prose, container, max-w-*, etc.) */
#finalOverlay .modal-body :is(.prose, .container, .mx-auto, [class*="max-w"], [class*="container"]){
  max-width: 100% !important;
  width: 100% !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

/* Footer fijo abajo con botón visible */
#finalOverlay .modal-footer{
  position: sticky; bottom: 0; z-index: 2;
  background: rgba(255,255,255,.96);
  backdrop-filter: blur(2px);
  border-top: 1px solid #eee;
  padding: 10px 16px;
  display: flex; justify-content: flex-end; gap: .5rem;
}

/* Botón */
#finalOverlay .btn{
  padding: .6rem 1.2rem; font-weight: 600;
  border: 1px solid #111; border-radius: 9999px; background:#fff; color:#111;
}
#finalOverlay .btn:active{ background:#000; color:#fff; }

/* Bloquea el scroll del fondo cuando está abierto */
body.modal-open{ overflow: hidden !important; }




.modal-frame{
  position:fixed;
  inset:0;
  max-width:100vh;
   max-height:100vh;
  object-fit:cover;
  z-index:0;
}
#finalOverlay .modal{
  position:relative;
  z-index:1;
  background:rgba(255,255,255,0.8);
  backdrop-filter:blur(2px);
}
.modal-frame{
  position:fixed;
  inset:0;
  max-width:100vh;
  max-height:100vh;
  object-fit:cover;
  z-index:0;
}
#finalOverlay .modal{
  position:relative;
  z-index:1;
  background:rgba(255,255,255,0.8);
  backdrop-filter:blur(2px);
}

/* imagen fondo reflexion*/
/* Fondo de la modal (mantiene todo fullscreen) */
#finalOverlay .modal {
  position: fixed;
  inset: 0;
  width: 100vw;
  height: 100vh;
  background-color: #fff;
  background-image: url("/PROYECTOS/Belleza/public/img/tocador.png"); /* ← tu marco PNG */
  background-repeat: no-repeat;
  background-size: cover; /* se estira al tamaño completo */
  background-position: center;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

/* Cuerpo scrollable con espacio para el marco */
#finalOverlay .modal-body {
  flex: 1;
  overflow-y: auto;
  padding: 80px clamp(5vw, 8vw, 120px); /* agrega margen para no tapar texto */
  color: #111;
  line-height: 1.7;
  font-size: 1.05rem;
  background: rgba(255,255,255,0.7); /* leve velo para legibilidad */
  border-radius: 12px;
  box-shadow: 0 0 12px rgba(0,0,0,0.1);
}

/* Header y footer ajustados */
#finalOverlay .modal-header,
#finalOverlay .modal-footer {
  background: transparent;
  border: none;
}

#finalOverlay .modal-footer {
  position: sticky;
  bottom: 0;
  padding: 1rem 2rem;
  display: flex;
  justify-content: flex-end;
}

#finalOverlay .btn {
  padding: .6rem 1.2rem;
  font-weight: 600;
  border: 1px solid #111;
  border-radius: 9999px;
  background: #fff;
  color: #111;
}
#finalOverlay .btn:active {
  background: #000;
  color: #fff;
}
/* Capa oscura */
/* === POP-UP FINAL CON MARCO A PANTALLA COMPLETA === */
#finalOverlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.55);
  backdrop-filter: blur(3px);
  z-index: 10000;
  display: flex;
  align-items: stretch;
  justify-content: stretch;
}
#finalOverlay.hidden { display: none; }

/* Contenedor general: grid header-body-footer */
#finalOverlay .modal-full {
  position: fixed;
  inset: 0;
  display: grid;
  grid-template-rows: auto 1fr auto;
  width: 100vw;
  height: 100vh;
  background: transparent;
  overflow: hidden;
}

/* --- Imagen del marco --- */
#finalOverlay .modal-frame{
  position:fixed;
  top:50%; left:50%;
  transform:translate(-50%,-50%);
  width:auto;          /* no se deforma */
  height:auto;
  max-width:100vw;     /* ocupa todo el ancho disponible */
  max-height:100vh;    /* o todo el alto, lo que llegue primero */
  object-fit:contain;  /* mantiene proporciones */
  pointer-events:none;
  z-index:0;
}

/* --- Contenido encima del marco --- */
#finalOverlay .modal-header,
#finalOverlay .modal-body,
#finalOverlay .modal-footer {
  position: relative;
  z-index: 1;
  color: #111;
}

/* Header arriba */
#finalOverlay .modal-header {
  padding: 1rem 2rem;
}
#finalOverlay .modal-title {
  margin: 0;
  font-size: 1.6rem;
  font-weight: 800;
  color: #111;
}

/* Body con scroll */
#finalOverlay .modal-body{
  position:relative; z-index:1;
  margin:0 auto;
  width:80vw;          /* texto dentro del marco */
  max-height:70vh;     /* alto controlado */
  overflow:auto;
  padding:2rem 3rem;
  background:rgba(255,255,255,.88);
  border-radius:12px;
  box-shadow:0 6px 18px rgba(0,0,0,.15);
}

/* Footer con el botón fijo abajo */
#finalOverlay .modal-footer {
  position: fixed;
  bottom: 0;
  right: 0;
  padding: 1rem 2rem;
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(4px);
  border-top-left-radius: 12px;
}

/* Botón */
#finalOverlay .btn {
  padding: .6rem 1.2rem;
  font-weight: 600;
  border: 1px solid #111;
  border-radius: 9999px;
  background: #fff;
  color: #111;
  cursor: pointer;
  transition: background .15s, color .15s;
}
#finalOverlay .btn:active {
  background: #000;
  color: #fff;
}


    </style>
</head>

<body>

    <!-- Barra superior -->
    <div class="bar">
        <!-- Bloque izquierdo -->
        <strong style="margin:0 auto;" class="text-3xl font-bold mb-12">Tocador</strong>
    </div>
    <!-- Instrucciones (fuera de la barra) -->
    <details id="inst" class="instructions-card" open>
        <summary>
            <span class="marker"></span>
            Instrucciones
            <span class="hint">(clic para mostrar / ocultar)</span>
        </summary>

        <div class="instructions-content" display: flex, justify-content: center>
            <p> <strong>Invirtamos los roles;</strong> este espejo te hará un par de preguntas que aparecen con solo ubicar el labial en el lienzo. </p><p> Te advierto que <strong> no existe una respuesta
                correcta;</strong> es más bien una invitación a reflexionar sobre tu alrededor y el entramado social. Recuerda que esta sección es para ti y tus propias reflexiones.La información que escribas aquí no será
                almacenada ni recolectada. </p> <br>
            <p> <strong>1)</strong> Te pediré que te tomes una selfie que nunca compartirías con alguien y cargarla usando el botón
                <strong>“Cargar selfie"</strong>.</p> <br>
            <p> <strong>2)</strong> Utiliza el labial para marcar tu selfie según las indicaciones de las preguntas en cada caso. Puedes hacer dibujos,
                símbolos o escribir alguna palabra o mensaje. No tienes que ser una artista; solo responde a cada
                pregunta indicando qué parte cambiarías. </p>
        </div>
    </details>
    <!-- Sub-barra de herramientas -->
    <div class="subbar">

        <div class="left">
            <div class="field">
                <span>Color</span>
                <input id="color" type="color" value="#ff1f6d">
            </div>

            <div class="field">
                <span>Grosor</span>
                <input id="size" type="range" min="1" max="60" step="1" value="8">
                <span id="sizev">8</span>
            </div>

            <button id="undo" class="btn">↶ Deshacer</button>
            <button id="redo" class="btn">↷ Rehacer</button>
            <label for="file" class="btn btn--upload" style="cursor:pointer">
                <input id="file" type="file" accept="image/*">
                Cargar selfie
            </label>
        </div>

        <div class="right">
            <button id="modeDraw" class="btn chip active">Rayar</button>
            <button id="modeErase" class="btn chip">Borrar</button>
            <button id="clear" class="btn chip">Limpiar Todo</button>
        </div>

    </div>







    <!-- Lienzo -->
    <div class="stage-box" style="display:flex; align-items:stretch; gap:20px;">
        <!-- Columna izquierda: TARJETA lateral (misma altura que el lienzo) -->
        <aside style="flex:0 0 300px;">
            <!-- Tu tarjeta de preguntas (qFly) arranca oculta -->
            <div id="qFly" class="q-fly hidden">
                <div class="q-head">
                    <strong>Pregunta</strong>
                </div>

                <div id="qText" class="q-body" style="font-weight:500;">
                    ¿Cuál es tu color favorito?
                </div>

                <label style="font-size:.8rem;color:#64748b;">Tu respuesta</label>
                <textarea id="qInput" rows="4"
                    style="resize:vertical;width:100%;border:1px solid #e2e8f0;border-radius:10px;padding:8px;outline:none;font:inherit;"
                    placeholder="Escribe aquí..."></textarea>

                <div class="q-foot" style="margin-top:8px;display:flex;gap:8px;justify-content:space-between;">
                    <button hidden id="qDownload" class="btn">⬇️ Descargar</button>
                    <button id="qNext" class="btn btn-primary">Continuar →</button>

                </div>
            </div>


        </aside>

        <!-- Columna derecha: LIENZO / STAGE (lo que ya tienes) -->


        <!-- ==== AVISO BLOQUEANTE (modal con overlay) ==== -->
        <div id="warnOverlay" class="warn-overlay" aria-modal="true" role="dialog">
            <div class="warn-modal" role="document">
                <h2
                    style="color:#dc2626; font-weight:800; font-size:1.4rem; text-transform:uppercase; text-align:center; margin-bottom:.75rem;">
                     Advertencia de contenido
                </h2>

                <p style="line-height:1.5; color:#0f172a; text-align:center; margin-bottom:1rem;">
                    Este ejercicio contiene preguntas sobre modificación facial, cirugía plástica e inseguridades. Si no
                    te sientes en la condición de hablar sobre estos temas, te recomiendo que saltes esta sección.<br>
                    Presione <strong>Continuar</strong> para ver las preguntas o <strong>Volver</strong> para ir al
                    Salón de Espejos.
                </p>

                <div style="display:flex; justify-content:space-between; gap:.75rem;">
                    <button id="btnWarnBack" class="btn" style="flex:1;">← Volver</button>
                    <button id="btnWarnContinue" class="btn btn-primary" style="flex:1;">Continuar →</button>
                </div>
            </div>
        </div>

<div id="finalOverlay" class="overlay hidden">
  <div class="modal-full">
    <!-- Marco imagen: capa de fondo que NO bloquea clics/scroll -->
    <img src="{{ asset('img/tocador.png') }}"alt="" class="modal-frame">

    <!-- Contenido -->
    <header class="modal-header">
      <h2 class="modal-title">Espejito, espejito</h2>
    </header>

    <section class="modal-body">
      <div class="fc-reset">
            <p class="modal-desc">  Gracias por verte en este espejo.</p>
            <p class="modal-desc">Aunque la belleza no sea lo más importante para ti, está en todas partes: en tu elección de ropa para la entrevista de trabajo, en arreglarse para una cita romántica o para verse con las amigas. Piensa en las historias de las mujeres que leíste y en los hilos que la conforman. Los factores son múltiples y se enredan entre sí.</p>
            <p class="modal-desc">El proyecto quiere informarte, no juzgarte. Espero que la información de esta página te sirva para redefinir lo que tú quieres con la belleza y negociar tu proceso de embellecimiento en los momentos que consideres. Tomes la decisión que tomes, serás juzgada: es parte de la paradoja de la belleza. Pierdes si quieres ser bella, pierdes si no lo quieres. Sin embargo, quiero dar un paso más allá para romper el blanco y negro y ver el enredo en el que tienes que vivir. </p>
            <p class="modal-desc">Espero que encuentres aquí un lugar para pensar la belleza desde una resistencia colectiva. Existirán muchas presiones a lo largo de tu vida y probablemente más con las innovaciones tecnológicas. La belleza es una moneda de cambio tanto por sus beneficios como desventajas. Así que, al igual que tú decides cómo negociar con ella, si aspiras a pasar inadvertida, a la diferenciación o la notoriedad; abraza la incoherencia que viene con ello, mírate al espejo y pregúntale: “Espejito, espejito, ¿de dónde viene este enredo?”</p>
            <p class="modal-desc">Tómate un momento, cuando quieras, continúa. </p>

      </div>
    </section>

    <footer class="modal-footer">
      <button id="btnContinuarFinal" class="btn">Continuar →</button>
    </footer>
  </div>
</div>

        <!-- ============ ESCENARIO ============ -->
        <div id="stage" class="stage" style="flex:1 1 auto; min-width:0; position:relative; overflow:hidden;">

            <!-- Imagen de fondo (selfie u otra). Mantiene proporción -->
            <img id="bg" alt="Imagen de fondo" style="position:absolute; inset:0; width:100%; height:100%;
                    object-fit:contain; z-index:5; user-select:none; -webkit-user-drag:none;">

            <!-- Región del vidrio (misma abertura del marco) -->
            <div id="glass" class="glass">
                <!-- Canvas de pintura DENTRO del vidrio -->
                <canvas id="cv" style="position:absolute; inset:0; width:100%; height:100%;
                                z-index:10; pointer-events:auto; touch-action:none; display:block;"></canvas>

                <!-- Placeholder centrado dentro del vidrio -->
                <div id="placeholder" class="glass-placeholder">
                    <div style="text-align:left; width:100%; max-width:300px;">
                        <div style="font-size:1.1rem; margin-bottom:.25rem;">
                            Cargar una imagen para empezar
                        </div>
                        <div>o dibuja sobre un lienzo en blanco</div>
                    </div>
                </div>
            </div>

            <!-- Marco por encima (no bloquea eventos) -->
            <img id="frame" src="{{ asset('img/tocador.png') }}" alt="Marco" style="position:absolute; inset:0; width:100%; height:100%;
                    object-fit:contain; z-index:15; pointer-events:none;">
        </div>

        <!-- ============ /ESCENARIO ============ -->

        <script>
            (function () {

                // —— Aviso inicial ↔ preguntas
                document.addEventListener('DOMContentLoaded', () => {
                    // ---- Cache de nodos (ids deben coincidir con tu HTML) ----
                    const warnOverlay = document.getElementById('warnOverlay');
                    const btnWarnBack = document.getElementById('btnWarnBack');
                    const btnWarnContinue = document.getElementById('btnWarnContinue');
                    const warnDontShowEl = document.getElementById('warnDontShow');
                    const qFlyPanel = document.getElementById('qFly'); // tu panel de preguntas

                    // Si no existe el modal, no seguimos (evita TypeError)
                    if (!warnOverlay) return;

                    // ---- Mostrar/Ocultar según preferencia guardada ----
                    try {
                        const ok = localStorage.getItem('mirrorConsent');
                        if (ok === 'yes') warnOverlay.classList.add('hidden');
                    } catch (_) {
                        // si el navegador bloquea storage de terceros, seguimos sin guardar preferencia
                    }

                    // ---- Botón “Anterior” ----
                    if (btnWarnBack) {
                        btnWarnBack.addEventListener('click', () => {
                            // Ajusta la ruta a tu “Salón de Espejos”
                            window.location.href = "{{ route('entrevistas.index') }}";
                        });
                    }

                    // ---- Botón “Continuar” ----
                    if (btnWarnContinue) {
                        btnWarnContinue.addEventListener('click', () => {
                            if (warnDontShowEl?.checked) {
                                try { localStorage.setItem('mirrorConsent', 'yes'); } catch { }
                            }
                            warnOverlay.classList.add('hidden');
                            qFlyPanel?.classList.remove('hidden'); // muestra la tarjeta/preguntas si la tenías oculta
                        });
                    }
                });
                // —— Refs
                const file = document.getElementById('file');
                const color = document.getElementById('color');
                const size = document.getElementById('size');
                const sizev = document.getElementById('sizev');
                const modeDraw = document.getElementById('modeDraw');
                const modeErase = document.getElementById('modeErase');
                const stage = document.getElementById('stage');
                const bg = document.getElementById('bg');
                const cv = document.getElementById('cv');
                const ph = document.getElementById('placeholder');
                const undoBtn = document.getElementById('undo');
                const redoBtn = document.getElementById('redo');
                const clearBtn = document.getElementById('clear');
                const ctx = cv.getContext('2d', { willReadFrequently: true });

                // --- Modal de advertencia bloqueante ---


                // —— Estado
                let brushColor = color.value;
                let brushSize = parseInt(size.value, 10);
                let mode = 'draw';                // 'draw' | 'erase'
                let brush = 'lipstick';           // 'lipstick' | 'shadow' | 'blush' | 'eyeliner' | 'remover'
                let bgLoaded = false;

                let drawing = false, lastX = 0, lastY = 0, lastStampX = 0, lastStampY = 0, stampSpacing = 0.35;
                let history = [], redoStack = [], historyLimit = 50;

                // —— Cursores personalizados (pon tus PNGs en /public/img/cursors/)
                const cursorBase = '/PROYECTOS/Belleza/public/img/cursors/';
                function updateCursor() {
                    let path = '';
                    if (mode === 'erase') path = cursorBase + 'borrar.png';
                    else {
                        switch (brush) {
                            case 'lipstick': path = cursorBase + 'labial.png'; break;
                            case 'shadow': path = cursorBase + 'sombra.png'; break;
                            case 'blush': path = cursorBase + 'rubor.png'; break;
                            case 'eyeliner': path = cursorBase + 'delineador.png'; break;
                            case 'remover': path = cursorBase + 'desmaquillante.png'; break;
                            default: path = '';
                        }
                    }
                    if (path) cv.style.cursor = `url("${path}") 16 16, crosshair`;
                    else cv.style.cursor = 'crosshair';
                }

                // —— Util
                function withAlpha(hex, a = 1) {
                    if (!hex) return `rgba(0,0,0,${a})`;
                    if (hex.startsWith('#')) {
                        const c = hex.length === 4 ? hex.replace('#', '').split('').map(ch => ch + ch).join('') : hex.replace('#', '');
                        const r = parseInt(c.slice(0, 2), 16), g = parseInt(c.slice(2, 4), 16), b = parseInt(c.slice(4, 6), 16);
                        return `rgba(${r},${g},${b},${a})`;
                    }
                    return hex;
                }
                function clamp(v, min, max) { return Math.max(min, Math.min(max, v)); }

                // —— Tamaño que no se desborda (85vw x 75% del alto útil)
                function resize() {
                    const dpr = window.devicePixelRatio || 1;

                    // MARCO como fuente de tamaño/proporción
                    const frame = document.getElementById('frame');
                    const fw = frame?.naturalWidth || 900;   // 3:4 por defecto
                    const fh = frame?.naturalHeight || 1200;

                    // Si hay una imagen de fondo y quieres que *también* ajuste, puedes
                    // cambiar a Math.max(fw, bg.naturalWidth) / Math.max(fh, bg.naturalHeight),
                    // pero para el marco fijo, fw/fh es lo correcto.
                    const natW = Math.max(fw, bg.naturalWidth);
                    const natH = Math.max(fh, bg.naturalHeight);

                    const headerH = (document.querySelector('.bar')?.getBoundingClientRect().height || 0) +
                        (document.querySelector('.subbar')?.getBoundingClientRect().height || 0);
                    const maxW_vp = Math.floor(window.innerWidth * 0.85);
                    const maxH_vp = Math.floor((window.innerHeight - headerH) * 0.75);

                    const boxRect = stage.parentElement.getBoundingClientRect();
                    const maxW = Math.max(320, Math.min(maxW_vp, boxRect.width));
                    const maxH = Math.max(240, Math.min(maxH_vp, 2000));

                    const scale = Math.min(maxW / natW, maxH / natH, 1);
                    const dispW = Math.max(1, Math.floor(natW * scale));
                    const dispH = Math.max(1, Math.floor(natH * scale));


                    stage.style.width = dispW + 'px';
                    stage.style.height = dispH + 'px';

                    // fondo y marco llenan el stage
                    Object.assign(bg.style, { width: dispW + 'px', height: dispH + 'px', objectFit: 'contain', display: 'block' });
                    Object.assign(frame.style, { width: dispW + 'px', height: dispH + 'px', objectFit: 'contain', display: 'block' });

                    // canvas del mismo tamaño (HiDPI)
                    cv.style.width = dispW + 'px';
                    cv.style.height = dispH + 'px';
                    cv.width = Math.round(dpr * dispW);
                    cv.height = Math.round(dpr * dispH);
                    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

                    // const dpr = window.devicePixelRatio || 1;

                    // Medimos el vidrio (NO el stage) para la resolución real del canvas
                    const glass = document.getElementById('glass');
                    const rect = glass.getBoundingClientRect();

                    // El canvas ya llena el vidrio con CSS (inset:0), aquí solo resolvemos en píxeles
                    cv.width = Math.max(1, Math.round(rect.width * dpr));
                    cv.height = Math.max(1, Math.round(rect.height * dpr));
                    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

                    const qFly = document.getElementById('qFly');
                    if (qFly) qFly.style.height = dispH + 'px';
                }

                // —— Historial
                function pushHistory() {
                    try {
                        const snap = ctx.getImageData(0, 0, cv.width, cv.height);
                        history.push(snap); if (history.length > historyLimit) history.shift();
                        undoBtn.disabled = history.length === 0;
                        redoBtn.disabled = redoStack.length === 0;
                    } catch (e) {
                        console.warn('Historial deshabilitado (posible CORS).', e);
                    }
                }
                function undo() {
                    if (!history.length) return;
                    const curr = ctx.getImageData(0, 0, cv.width, cv.height);
                    const prev = history.pop(); if (!prev) return;
                    redoStack.push(curr); ctx.putImageData(prev, 0, 0);
                    undoBtn.disabled = history.length === 0;
                    redoBtn.disabled = redoStack.length === 0;
                }
                function redo() {
                    if (!redoStack.length) return;
                    const curr = ctx.getImageData(0, 0, cv.width, cv.height);
                    const next = redoStack.pop(); if (!next) return;
                    history.push(curr); ctx.putImageData(next, 0, 0);
                    undoBtn.disabled = history.length === 0;
                    redoBtn.disabled = redoStack.length === 0;
                }

                // —— Dibujo
                function eventXY(e) {
                    const rect = cv.getBoundingClientRect();
                    const t = e.touches?.[0];
                    const cx = t ? t.clientX : e.clientX;
                    const cy = t ? t.clientY : e.clientY;
                    const x = (cx - rect.left) * (cv.width / rect.width);
                    const y = (cy - rect.top) * (cv.height / rect.height);
                    return { x, y };
                }

                function pointerDown(e) {
                    ctx.shadowBlur = 0; ctx.shadowColor = 'transparent';
                    const { x, y } = eventXY(e);
                    drawing = true; lastX = x; lastY = y; lastStampX = x; lastStampY = y;

                    if (mode === 'erase') {
                        ctx.globalCompositeOperation = 'destination-out';
                        ctx.lineCap = 'round'; ctx.lineJoin = 'round';
                        ctx.lineWidth = brushSize; ctx.strokeStyle = 'rgba(0,0,0,1)';
                        ctx.beginPath(); ctx.moveTo(x, y); return;
                    }
                    ctx.globalCompositeOperation = 'source-over';

                    if (brush === 'eyeliner') {
                        ctx.lineCap = 'butt'; ctx.lineJoin = 'round';
                        ctx.lineWidth = Math.max(1, brushSize * 0.55);
                        ctx.strokeStyle = brushColor;
                        ctx.beginPath(); ctx.moveTo(x, y);
                    } else if (brush === 'lipstick') {
                        ctx.lineCap = 'round'; ctx.lineJoin = 'round';
                        ctx.lineWidth = Math.max(2, brushSize * 0.9);
                        ctx.strokeStyle = withAlpha(brushColor, 0.85);
                        ctx.shadowColor = brushColor; ctx.shadowBlur = Math.floor(brushSize * 0.15);
                        ctx.beginPath(); ctx.moveTo(x, y);
                    }
                }

                function pointerMove(e) {
                    if (!drawing) return;
                    const { x, y } = eventXY(e);

                    if (mode === 'erase') {
                        ctx.lineTo(x, y); ctx.stroke(); lastX = x; lastY = y; return;
                    }

                    if (brush === 'eyeliner' || brush === 'lipstick') {
                        ctx.lineTo(x, y); ctx.stroke(); lastX = x; lastY = y; return;
                    }

                    // stamps (shadow, blush, remover)
                    const dist = Math.hypot(x - lastStampX, y - lastStampY);
                    const step = brushSize * stampSpacing;
                    if (dist >= step) {
                        const n = Math.floor(dist / step);
                        for (let i = 1; i <= n; i++) {
                            const t = i / n, sx = lastStampX + (x - lastStampX) * t, sy = lastStampY + (y - lastStampY) * t;
                            stamp(sx, sy);
                        }
                        lastStampX = x; lastStampY = y;
                    }
                }

                function pointerUp() {
                    if (!drawing) return;
                    drawing = false; try { ctx.closePath(); } catch (_) { }
                    ctx.shadowBlur = 0;
                    pushHistory(); redoStack = [];
                }

                function stamp(x, y) {
                    // shadow & blush: usar bordes del mismo color con alfa 0, y mezcla 'lighter'
                    if (brush === 'shadow') {
                        const r = brushSize * 0.6;
                        const g = ctx.createRadialGradient(x, y, 0, x, y, r);
                        g.addColorStop(0, withAlpha(brushColor, 0.18));
                        g.addColorStop(1, withAlpha(brushColor, 0.00));
                        const prev = ctx.globalCompositeOperation;
                        ctx.globalCompositeOperation = 'lighter';
                        ctx.fillStyle = g; ctx.beginPath(); ctx.arc(x, y, r, 0, Math.PI * 2); ctx.fill();
                        ctx.globalCompositeOperation = prev; return;
                    }
                    if (brush === 'blush') {
                        const R = brushSize * 0.96;
                        const g = ctx.createRadialGradient(x, y, 0, x, y, R);
                        g.addColorStop(0, withAlpha(brushColor, 0.12));
                        g.addColorStop(1, withAlpha(brushColor, 0.00));
                        const prev = ctx.globalCompositeOperation;
                        ctx.globalCompositeOperation = 'lighter';
                        ctx.fillStyle = g; ctx.beginPath(); ctx.arc(x, y, R, 0, Math.PI * 2); ctx.fill();
                        ctx.globalCompositeOperation = prev; return;
                    }
                    if (brush === 'remover') {
                        const r = brushSize * 0.7;
                        const g = ctx.createRadialGradient(x, y, 0, x, y, r);
                        g.addColorStop(0, 'rgba(255,255,255,0.25)');
                        g.addColorStop(0.3, 'rgba(255,255,255,0.10)');
                        g.addColorStop(1, 'rgba(255,255,255,0.00)');
                        const prev = ctx.globalCompositeOperation;
                        ctx.globalCompositeOperation = 'destination-out';
                        ctx.fillStyle = g; ctx.beginPath(); ctx.arc(x, y, r, 0, Math.PI * 2); ctx.fill();
                        ctx.globalCompositeOperation = prev; return;
                    }
                }

                // —— Acciones
                file.addEventListener('change', (e) => {
                    const f = e.target.files?.[0]; if (!f) return;
                    const reader = new FileReader();
                    reader.onload = () => { bg.src = reader.result; };
                    reader.readAsDataURL(f);
                });
                bg.addEventListener('load', () => {
                    bgLoaded = true; ph.style.display = 'none'; resize(); pushHistory(); redoStack = [];
                });

                size.addEventListener('input', () => { brushSize = parseInt(size.value, 10); sizev.textContent = size.value; });
                color.addEventListener('input', () => { brushColor = color.value; });

                modeDraw.addEventListener('click', () => {
                    mode = 'draw'; modeDraw.classList.add('active'); modeErase.classList.remove('active'); updateCursor();
                });
                modeErase.addEventListener('click', () => {
                    mode = 'erase'; modeErase.classList.add('active'); modeDraw.classList.remove('active'); updateCursor();
                });

                document.querySelectorAll('[data-brush]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        document.querySelectorAll('[data-brush]').forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        brush = btn.getAttribute('data-brush');
                        updateCursor();
                    });
                });

                undoBtn.addEventListener('click', undo);
                redoBtn.addEventListener('click', redo);
                clearBtn.addEventListener('click', () => {
                    if (!confirm('¿Limpiar todos los trazos?')) return;
                    ctx.save(); ctx.setTransform(1, 0, 0, 1, 0, 0); ctx.clearRect(0, 0, cv.width, cv.height); ctx.restore();
                    pushHistory(); redoStack = [];
                });
                // --- Listeners robustos sólo en el CANVAS ---
                cv.addEventListener('pointerdown', (e) => {
                    cv.setPointerCapture(e.pointerId); // asegura el drag aunque el puntero salga
                    pointerDown(e);
                });
                cv.addEventListener('pointermove', pointerMove);
                cv.addEventListener('pointerup', pointerUp);
                cv.addEventListener('pointercancel', pointerUp);


                // —— Atajos
                window.addEventListener('keydown', (e) => {
                    const k = e.key.toLowerCase();
                    if ((e.ctrlKey || e.metaKey) && k === 'z') { e.preventDefault(); return undo(); }
                    if ((e.ctrlKey || e.metaKey) && k === 'y') { e.preventDefault(); return redo(); }
                    if (k === 'e') { mode = 'erase'; modeErase.classList.add('active'); modeDraw.classList.remove('active'); updateCursor(); }
                    if (k === 'd') { mode = 'draw'; modeDraw.classList.add('active'); modeErase.classList.remove('active'); updateCursor(); }
                });

                window.addEventListener('resize', () => { resize(); });

                // —— Init
                resize(); updateCursor(); pushHistory();

                // --- Preguntas "quemadas"
                const Q = [
                    "Si pudieras modificar cualquier cosa de tu rostro sin dolor o secuelas, ¿qué cambiarías? Señala en la imagen. CONTINUAR",
                    "Ahora puedes cambiar cosas, pero tienes que hacerte un procedimiento radical. ¿Qué cosas intervendrías con cirugías? Señala en la imagen. CONTINUAR",
                    "Solo puedes utilizar tratamientos no invasivos para cambiar tu rostro: desde plantas, minerales, productos y tratamientos. ¿Qué cosas cambiarías con eso? Señala tu imagen. CONTINUAR",
                    "¿Alguna vez has recurrido a estos procesos radicales o no invasivos? Si es así, ¿por qué? Si no es el caso, ¿por qué no? Raya tu selfie. CONTINUAR",
                    "¿Qué cosas intervienen en tus decisiones y bajo qué condiciones? Si tu entorno fuera diferente, ¿cambiarias tu razonamiento? Raya tu selfie. CONTINUAR"
                ];

                let qIdx = 0;
                const qInput = document.getElementById('qInput');
                const qDownload = document.getElementById('qDownload');

                // Respuestas por índice de pregunta
                const answers = new Array(Q.length).fill('');

                const qFly = document.getElementById('qFly');
                const qText = document.getElementById('qText');
                const qNext = document.getElementById('qNext');

                const SPRING_IN = 'cubic-bezier(.22,1.25,.23,1)';
                const EASE_OUT = 'cubic-bezier(.3,.7,.2,1)';

                let qVisible = false;
                let overStage = false, overCard = false;
                let hideTimer = null;
                let isAnimating = false;

                function cancelAllAnims() {
                    qFly.getAnimations().forEach(a => a.cancel());
                }

                function showQ() {
                    if (qVisible && !qFly.classList.contains('hidden')) return;
                    cancelAllAnims();
                    qFly.classList.remove('hidden');
                    qVisible = true;
                    isAnimating = true;
                    qFly.animate(
                        [
                            { transform: 'translateX(-100px) scale(.92)', opacity: 0, filter: 'blur(4px)' },
                            { transform: 'translateX(0) scale(1)', opacity: 1, filter: 'blur(0)' }
                        ],
                        { duration: 480, easing: SPRING_IN, fill: 'both' }
                    ).onfinish = () => { isAnimating = false; };
                }

                function hideQ() {
                    if (!qVisible || qFly.classList.contains('hidden')) return;
                    cancelAllAnims();
                    isAnimating = true;
                    qFly.animate(
                        [
                            { transform: 'translateX(0) scale(1)', opacity: 1, filter: 'blur(0)' },
                            { transform: 'translateX(-80px) scale(.95)', opacity: 0, filter: 'blur(4px)' }
                        ],
                        { duration: 240, easing: EASE_OUT, fill: 'forwards' }
                    ).onfinish = () => { qFly.classList.add('hidden'); qVisible = false; isAnimating = false; };
                }

                function scheduleHide() {
                    clearTimeout(hideTimer);
                    hideTimer = setTimeout(() => {
                        if (!overStage && !overCard && !isAnimating) hideQ();
                    }, 130); // pequeño debounce para cruzar el gap
                }

                // --- Hover combinado (lienzo + tarjeta) ---
                stage.addEventListener('mouseenter', () => { overStage = true; if (!isAnimating) showQ(); });
                stage.addEventListener('mouseleave', (e) => {
                    overStage = false;
                    if (qFly.contains(e.relatedTarget)) return; // estás yendo a la tarjeta
                    scheduleHide();
                });

                qFly.addEventListener('mouseenter', () => { overCard = true; /* mantener visible */ });
                qFly.addEventListener('mouseleave', (e) => {
                    overCard = false;
                    if (stage.contains(e.relatedTarget)) return; // volviste al lienzo
                    scheduleHide();
                });

                function downloadCurrentQA() {
                    // Fuente de verdad: lo que está actualmente en el textarea
                    const question = Q[qIdx] || '';
                    const answer = (qInput.value || '').trim();

                    // (opcional pero útil) guarda en memoria por si luego vuelves a esta pregunta
                    answers[qIdx] = answer;

                    // ——— lienzo offscreen con soporte HiDPI y auto alto ———
                    const CSS_W = 680;       // ancho en px “CSS”
                    const PAD = 24;        // padding
                    const DPR = Math.max(1, Math.round(window.devicePixelRatio || 1));

                    // primero medimos para calcular alto dinámico
                    const m = document.createElement('canvas').getContext('2d');
                    m.font = '600 18px system-ui, -apple-system, Segoe UI, Roboto, Inter, Arial, sans-serif';
                    const qLines = wrapText(m, question, CSS_W - PAD * 2);
                    m.font = '400 16px system-ui, -apple-system, Segoe UI, Roboto, Inter, Arial, sans-serif';
                    const aLines = (answer ? wrapText(m, answer, CSS_W - PAD * 2) : ['(sin respuesta)']);

                    const LH_Q = 24;  // line-height pregunta
                    const LH_A = 22;  // line-height respuesta
                    const TITLE_H = 14;   // alto del “Pregunta” (texto)
                    const GUTTER1 = 10;   // espacio entre título y pregunta
                    const GUTTER2 = 10;   // espacio entre pregunta y “Tu respuesta”
                    const LABEL_H = 14;   // alto de la etiqueta “Tu respuesta”
                    const GUTTER3 = 8;    // espacio entre etiqueta y respuesta

                    const CSS_H = PAD + TITLE_H + GUTTER1 +
                        qLines.length * LH_Q +
                        GUTTER2 + LABEL_H + GUTTER3 +
                        aLines.length * LH_A +
                        PAD;

                    // canvas real (escalado por DPR para que no se vea borroso)
                    const c = document.createElement('canvas');
                    c.width = Math.round(CSS_W * DPR);
                    c.height = Math.round(CSS_H * DPR);
                    const ctx = c.getContext('2d');
                    ctx.scale(DPR, DPR);

                    // ——— tarjeta ———
                    roundRect(ctx, 0, 0, CSS_W, CSS_H, 16);
                    // sombra suave
                    ctx.save();
                    ctx.shadowColor = 'rgba(2,6,23,0.06)';
                    ctx.shadowBlur = 18;
                    ctx.shadowOffsetY = 6;
                    ctx.fillStyle = '#ffffff';
                    ctx.fill();
                    ctx.restore();
                    // borde
                    ctx.strokeStyle = '#e2e8f0';
                    ctx.lineWidth = 1;
                    ctx.stroke();

                    // título
                    ctx.fillStyle = '#0f172a';
                    ctx.font = '700 14px system-ui, -apple-system, Segoe UI, Roboto, Inter, Arial, sans-serif';
                    ctx.fillText('', PAD, PAD + TITLE_H);

                    // pregunta
                    ctx.font = '600 18px system-ui, -apple-system, Segoe UI, Roboto, Inter, Arial, sans-serif';
                    let y = PAD + TITLE_H + GUTTER1;
                    qLines.forEach(line => { ctx.fillText(line, PAD, y); y += LH_Q; });

                    // etiqueta
                    y += 2; // pequeño respiro
                    ctx.fillStyle = '#64748b';
                    ctx.font = '500 13px system-ui, -apple-system, Segoe UI, Roboto, Inter, Arial, sans-serif';
                    ctx.fillText('Tu respuesta', PAD, y);
                    y += LABEL_H + GUTTER3;

                    // respuesta
                    ctx.fillStyle = '#0f172a';
                    ctx.font = '400 16px system-ui, -apple-system, Segoe UI, Roboto, Inter, Arial, sans-serif';
                    aLines.forEach(line => { ctx.fillText(line, PAD, y); y += LH_A; });

                    // ——— descarga con nombre corto ———
                    const idxStr = String(qIdx + 1).padStart(2, '0');
                    const short = shortSlug(question, 18); // 18 chars máx
                    const aTag = document.createElement('a');
                    aTag.download = `Q${idxStr}-${short || 'pregunta'}.png`;
                    aTag.href = c.toDataURL('image/png');
                    aTag.click();

                    // helpers
                    function roundRect(ctx, x, y, w, h, r) {
                        ctx.beginPath();
                        ctx.moveTo(x + r, y);
                        ctx.arcTo(x + w, y, x + w, y + h, r);
                        ctx.arcTo(x + w, y + h, x, y + h, r);
                        ctx.arcTo(x, y + h, x, y, r);
                        ctx.arcTo(x, y, x + w, y, r);
                        ctx.closePath();
                    }
                    function wrapText(ctx, text, maxWidth) {
                        const words = String(text || '').split(/\s+/);
                        const lines = [];
                        let line = '';
                        for (let i = 0; i < words.length; i++) {
                            const test = (line ? line + ' ' : '') + words[i];
                            if (ctx.measureText(test).width > maxWidth && line) {
                                lines.push(line);
                                line = words[i];
                            } else {
                                line = test;
                            }
                        }
                        if (line) lines.push(line);
                        return lines;
                    }
                    function shortSlug(s, max = 18) {
                        // quita símbolos raros, espacios → guiones, recorta
                        const base = String(s || '').toLowerCase()
                            .replace(/[^\p{L}\p{N}\s]/gu, '')
                            .trim()
                            .replace(/\s+/g, '-');
                        return base.slice(0, max).replace(/-+$/, '');
                    }
                }

                qDownload.addEventListener('click', (e) => {
                    e.stopPropagation();
                    downloadCurrentQA();
                });

// --- Siguiente: salida -> cambio texto -> entrada (sin ocultar por hover) ---

function nextQuestion() {
  clearTimeout(hideTimer);
  overCard = true;
  if (!qVisible) showQ();
  if (isAnimating) return;

  isAnimating = true;
  qNext.disabled = true;

  // animación de salida (la que ya usas)
  qFly.animate(
    [
      { transform: 'translateX(0) scale(1)', opacity: 1, filter: 'blur(0)' },
      { transform: 'translateX(-80px) scale(.95)', opacity: 0, filter: 'blur(4px)' }
    ],
    { duration: 240, easing: EASE_OUT, fill: 'forwards' }
  ).onfinish = () => {
    // si esta era la última, no avances; muestra conclusión
    if (isLast()) {
      showFinalModal();
      // opcional: mantén visible la tarjeta o escóndela
      // hideQ();
      isAnimating = false;
      qNext.disabled = false;
      return;
    }

    // avanzar índice y renderizar la siguiente
    qIdx = Math.min(qIdx + 1, Q.length - 1);
    qText.textContent = cleanQ(Q[qIdx]);
    // Guarda la respuesta actual antes de avanzar
    answers[qIdx - 1] = (qInput.value || '').trim();

    // Limpia o restaura según corresponda
    qInput.value = answers[qIdx] || '';

    // animación de entrada
    qFly.animate(
      [
        { transform: 'translateX(100px) scale(.92)', opacity: 0, filter: 'blur(4px)' },
        { transform: 'translateX(0) scale(1)', opacity: 1, filter: 'blur(0)' }
      ],
      { duration: 420, easing: SPRING_IN, fill: 'both' }
    ).onfinish = () => {
      isAnimating = false;
      qNext.disabled = false;

      // Si ahora estamos en la última, puedes cambiar el texto del botón:
      // qNext.textContent = 'Finalizar';
    };
  };
}


                qNext.addEventListener('click', (e) => {
                    e.stopPropagation();
                    nextQuestion();
                });

                // texto inicial por si las moscas
                qText.textContent = Q[qIdx];

                document.addEventListener('DOMContentLoaded', () => {
                    const warnOverlay = document.getElementById('warnOverlay');
                    const btnWarnBack = document.getElementById('btnWarnBack');
                    const btnWarnContinue = document.getElementById('btnWarnContinue');
                    const warnDontShowEl = document.getElementById('warnDontShow');
                    const qFlyPanel = document.getElementById('qFly');

                    // Si no existe el overlay, salimos sin romper nada
                    if (!warnOverlay) return;

                    // Mostrar/ocultar según preferencia guardada
                    try {
                        const ok = localStorage.getItem('mirrorConsent');
                        if (ok === 'yes') {
                            warnOverlay.classList.add('hidden');
                            // Si tu lógica quiere mostrar el panel al cargar, quita hidden:
                            qFlyPanel?.classList.remove('hidden');
                        }
                    } catch (e) {
                        // ignorar si storage está bloqueado
                    }

                    // Botón “Anterior” → vuelve al "Salón de Espejos"
                    if (btnWarnBack) {
                        btnWarnBack.addEventListener('click', () => {
                            window.location.href = "{{ route('entrevistas.index') }}";
                        });
                    }

                    // Botón “Continuar” → oculta modal y muestra preguntas
                    if (btnWarnContinue) {
                        btnWarnContinue.addEventListener('click', () => {
                            if (warnDontShowEl?.checked) {
                                try { localStorage.setItem('mirrorConsent', 'yes'); } catch { }
                            }
                            warnOverlay.classList.add('hidden');
                            qFlyPanel?.classList.remove('hidden');
                        });
                    }
                });

                //==== REFLEXION  FINAL POP UP ========

function showFinalModal(){
  document.getElementById('finalOverlay').classList.remove('hidden');
  document.body.classList.add('modal-open');
}
document.getElementById('btnContinuarFinal').onclick = () => {
  document.body.classList.remove('modal-open');
  window.location.href = "/netrevistas";
};
                function cleanQ(s) {
                    return String(s || '').replace(/\s*CONTINUAR\s*$/i, '').trim();
                }

                function renderQ() {
                    qText.textContent = cleanQ(Q[qIdx]);

                }
                function isLast() {
                    return qIdx >= Q.length - 1;
                }


                function showFinalModal(){
                const overlay = document.getElementById('finalOverlay');
                overlay.classList.remove('hidden');
                document.body.classList.add('modal-open');

                document.getElementById('btnContinuarFinal').onclick = () => {
                    document.body.classList.remove('modal-open');
                    window.location.href = "{{ route('espejo.paint') }}";
                };
                }



            })();
        </script>
</body>

</html>
