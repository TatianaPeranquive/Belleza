@extends('layouts.app')

@section('title', 'Hitos - Proyecto Espejo')

@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Ajusta este padding-top para compensar la altura de tu menú fijo (ej. 80px ≈ pt-20) --}}
<div x-data="hitosUI()" id="hitos-top" class="mx-auto max-w-6xl px-4 pt-20 pb-12 scroll-mt-24">

  {{-- 1) TÍTULO visible (no tapado) --}}
  <h1 class="mb-4 text-3xl font-extrabold tracking-tight uppercase">HITOS</h1>

  {{-- 2) PÁRRAFO EXPLICATIVO (recuadro gris) --}}
  <div class="mb-6 rounded-xl border border-gray-200 bg-gray-100 p-4 text-gray-800">
    <p class="text-sm leading-relaxed">
      Selecciona un hito para explorar sus etapas. Pasa el cursor o haz clic para resaltar una tarjeta;
      las demás se atenuarán para ayudarte a enfocarte. Luego, elige una de las tres tarjetas asociadas a cada hito.
    </p>
  </div>

  {{-- 3) BOTÓN "CONTINUAR" (muestra las slides al hacer clic) --}}
  <div class="mb-8">
    <button
      type="button"
      @click="started = true; $nextTick(() => document.getElementById('grid-hitos')?.scrollIntoView({behavior:'smooth', block:'start'}))"
      :disabled="started"
      class="group inline-flex items-center gap-2 rounded-2xl px-6 py-3 text-base font-semibold text-white
             transition transform-gpu focus:outline-none focus:ring-4
             disabled:opacity-60 disabled:cursor-not-allowed
             bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] focus:ring-indigo-300"
    >
      <svg class="h-5 w-5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
      </svg>
      <span x-text="started ? 'Listo' : 'Continuar'"></span>
    </button>
  </div>

  {{-- NIVEL 1: GRID DE HITOS (solo se muestra tras pulsar Continuar) --}}
  <div id="grid-hitos" x-show="started" x-transition.opacity.duration.300ms>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <template x-for="it in items" :key="it.id">
        <button
          type="button"
          @mouseenter="hovered = it.id"
          @mouseleave="hovered = null"
          @focus="hovered = it.id"
          @blur="hovered = null"
          @click="selectHito(it.id)"
          class="relative text-left focus:outline-none transition will-change-transform transform-gpu"
          :class="{
            'scale-105 z-10': activeId === it.id || hovered === it.id,
            'opacity-40': (hovered || activeId) && (hovered ?? activeId) !== it.id
          }"
        >
          <div class="rounded-2xl border bg-white/90 shadow-sm transition p-5">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-lg font-semibold" x-text="it.title"></h3>
                <p class="mt-2 text-sm text-gray-600" x-text="it.text"></p>
              </div>
              <span
                class="shrink-0 rounded-full px-2 py-0.5 text-xs font-medium transition"
                :class="(activeId === it.id) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'">
                <span x-text="(activeId === it.id) ? 'Seleccionado' : 'Explorar'"></span>
              </span>
            </div>
            <div class="mt-4 text-xs text-gray-500">ID: <span x-text="it.id"></span></div>
          </div>
        </button>
      </template>
    </div>

    {{-- NIVEL 2: TARJETAS DEL HITO SELECCIONADO --}}
    <div class="mt-8">
      <template x-if="activeId !== null">
        <div>
          <div class="mb-3 flex items-center justify-between">
            <h2 class="text-xl font-semibold">
              <span x-text="`Detalles de ${items.find(i => i.id === activeId)?.title}`"></span>
            </h2>
            <button
              type="button"
              class="text-sm text-indigo-700 hover:underline"
              @click="clearSelection()"
            >
              Limpiar selección
            </button>
          </div>

          <div x-transition.opacity class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <template x-for="sub in currentSubs" :key="sub.id">
              <button
                type="button"
                @mouseenter="subHovered = sub.id"
                @mouseleave="subHovered = null"
                @focus="subHovered = sub.id"
                @blur="subHovered = null"
                @click="subSelected = sub.id"
                class="relative text-left focus:outline-none transition will-change-transform transform-gpu"
                :class="{
                  'scale-105 z-10': (subHovered === sub.id) || (subSelected === sub.id),
                  'opacity-40': (subHovered || subSelected) && (subHovered ?? subSelected) !== sub.id
                }"
              >
                <div class="rounded-2xl border bg-white/90 shadow-sm transition p-5">
                  <div class="flex items-start justify-between gap-4">
                    <div>
                      <h3 class="text-lg font-semibold" x-text="sub.title"></h3>
                      <p class="mt-2 text-sm text-gray-600" x-text="sub.text"></p>
                    </div>
                    <span
                      class="shrink-0 rounded-full px-2 py-0.5 text-xs font-medium transition"
                      :class="(subSelected === sub.id) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'">
                      <span x-text="(subSelected === sub.id) ? 'Elegido' : 'Explorar'"></span>
                    </span>
                  </div>
                </div>
              </button>
            </template>
          </div>
        </div>
      </template>
    </div>
  </div>
</div>

<script>
function hitosUI () {
  return {
    // Control de inicio (Continuar)
    started: false,

    // Estado nivel 1
    hovered: null,
    activeId: null,
    items: [
      { id: 1, title: 'Hito 1', text: 'Breve descripción del hito 1.' },
      { id: 2, title: 'Hito 2', text: 'Breve descripción del hito 2.' },
      { id: 3, title: 'Hito 3', text: 'Breve descripción del hito 3.' },
    ],

    // Estado nivel 2
    subHovered: null,
    subSelected: null,

    // Tres tarjetas por hito
    details: {
      1: [
        { id: '1A', title: 'H1 - Tarjeta A', text: 'Contenido específico del Hito 1 A.' },
        { id: '1B', title: 'H1 - Tarjeta B', text: 'Contenido específico del Hito 1 B.' },
        { id: '1C', title: 'H1 - Tarjeta C', text: 'Contenido específico del Hito 1 C.' },
      ],
      2: [
        { id: '2A', title: 'H2 - Tarjeta A', text: 'Contenido específico del Hito 2 A.' },
        { id: '2B', title: 'H2 - Tarjeta B', text: 'Contenido específico del Hito 2 B.' },
        { id: '2C', title: 'H2 - Tarjeta C', text: 'Contenido específico del Hito 2 C.' },
      ],
      3: [
        { id: '3A', title: 'H3 - Tarjeta A', text: 'Contenido específico del Hito 3 A.' },
        { id: '3B', title: 'H3 - Tarjeta B', text: 'Contenido específico del Hito 3 B.' },
        { id: '3C', title: 'H3 - Tarjeta C', text: 'Contenido específico del Hito 3 C.' },
      ],
    },

    get currentSubs () {
      return this.activeId ? (this.details[this.activeId] ?? []) : [];
    },

    selectHito (id) {
      this.activeId = (this.activeId === id) ? null : id;
      this.subHovered = null;
      this.subSelected = null;
    },

    clearSelection () {
      this.activeId = null;
      this.hovered = null;
      this.subHovered = null;
      this.subSelected = null;
    }
  }
}
</script>
@endsection
