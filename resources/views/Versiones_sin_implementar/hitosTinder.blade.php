
  {{-- HITOS - TINDER  --}}
@extends('layouts.app')

@section('title', 'Hitos - Proyecto Espejo')

@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="hitosUI()" class="mx-auto max-w-6xl px-4 pt-20 pb-12">

  {{-- Título: cambia cuando hay hito seleccionado --}}
  <h1 class="mb-4 text-3xl font-extrabold tracking-tight uppercase">
    <span x-text="activeId ? items.find(i => i.id === activeId).title : 'HITOS'"></span>
  </h1>

  {{-- CONTENEDOR DE SLIDES (NIVEL 1) --}}
  <section class="relative w-full">
    {{-- Layout normal (sin selección): grid 3 col con hover/atenuado --}}
    <div
      x-show="!activeId"
      x-transition.opacity
      class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3"
    >
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
            'scale-105 z-10': hovered === it.id,
            'opacity-40': hovered && hovered !== it.id
          }"
        >
          <div class="rounded-2xl border bg--[#34113F]/90 shadow-sm transition p-6">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-lg font-semibold" x-text="it.title"></h3>
                <p class="mt-2 text-sm text-gray-600" x-text="it.text"></p>
              </div>
              <span class="rounded-full bg-gray-200 text-gray-700 px-2 py-0.5 text-xs font-medium">Explorar</span>
            </div>
          </div>
        </button>
      </template>
    </div>

    {{-- Layout seleccionado (una grande al centro; las demás detrás/asomadas) --}}
    <div
      x-show="activeId"
      x-transition
      class="relative h-[480px] sm:h-[520px] lg:h-[560px]"
    >
      <template x-for="(it, idx) in items" :key="it.id">
        <button
          type="button"
          @click="selectHito(it.id)"
          @mouseenter="hovered = it.id"
          @mouseleave="hovered = null"
          class="absolute inset-0 mx-auto focus:outline-none transition will-change-transform transform-gpu"
          :style="cardStyle(it.id, idx)"
          :class="cardClasses(it.id)"
        >
          <div class="h-full w-full rounded-3xl border bg--[#34113F] shadow-xl transition p-6 overflow-hidden">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-xl font-semibold" x-text="it.title"></h3>
                <p class="mt-2 text-sm text-gray-600" x-text="it.text"></p>
              </div>
              <span
                class="rounded-full px-2 py-0.5 text-xs font-medium transition"
                :class="activeId === it.id ? 'bg-indigo-600 text--[#34113F]' : 'bg-gray-200 text-gray-700'">
                <span x-text="activeId === it.id ? 'Seleccionado' : 'Cambiar'"></span>
              </span>
            </div>

            {{-- Área simulada de contenido del hito (ilustrativa) --}}
            <div class="mt-6 h-[70%] rounded-2xl border border-dashed bg-gray-50"></div>
          </div>
        </button>
      </template>
    </div>
  </section>

  {{-- BOTÓN CONTINUAR (aparece cuando hay hito seleccionado) --}}
  <div x-show="activeId && !showSubs" x-transition.opacity class="mt-6">
    <button
      type="button"
      @click="showSubs = true; $nextTick(() => document.getElementById('subs')?.scrollIntoView({behavior:'smooth'}))"
      class="group inline-flex items-center gap-2 rounded-2xl px-6 py-3 text-base font-semibold text--[#34113F]
             transition transform-gpu focus:outline-none focus:ring-4
             bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] focus:ring-indigo-300"
    >
      <svg class="h-5 w-5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
      </svg>
      Continuar
    </button>
  </div>

  {{-- SUB-NIVEL: 3 tarjetas correspondientes al hito seleccionado --}}
  <section id="subs" x-show="showSubs" x-transition.opacity class="mt-10">
    <h2 class="mb-3 text-xl font-semibold">
      <span x-text="`Detalles de ${items.find(i => i.id === activeId)?.title}`"></span>
    </h2>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
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
          <div class="rounded-2xl border bg--[#34113F]/90 shadow-sm transition p-5">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-lg font-semibold" x-text="sub.title"></h3>
                <p class="mt-2 text-sm text-gray-600" x-text="sub.text"></p>
              </div>
              <span
                class="shrink-0 rounded-full px-2 py-0.5 text-xs font-medium transition"
                :class="(subSelected === sub.id) ? 'bg-indigo-600 text--[#34113F]' : 'bg-gray-200 text-gray-700'">
                <span x-text="(subSelected === sub.id) ? 'Elegido' : 'Explorar'"></span>
              </span>
            </div>
          </div>
        </button>
      </template>
    </div>
  </section>
</div>

<script>
function hitosUI () {
  return {
    // Estado general
    hovered: null,
    activeId: null,        // hito seleccionado
    showSubs: false,       // muestra sub-nivel tras "Continuar"

    // Estado sub-nivel
    subHovered: null,
    subSelected: null,

    // Datos
    items: [
      { id: 1, title: 'Hito 1', text: 'Breve descripción del hito 1.' },
      { id: 2, title: 'Hito 2', text: 'Breve descripción del hito 2.' },
      { id: 3, title: 'Hito 3', text: 'Breve descripción del hito 3.' },
    ],
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

    // Computado
    get currentSubs () {
      return this.activeId ? (this.details[this.activeId] ?? []) : [];
    },

    // Acciones
    selectHito (id) {
      // Seleccionar o cambiar hito
      this.activeId = id;
      // Al cambiar de hito, ocultar sub-nivel hasta presionar "Continuar"
      this.showSubs = false;
      this.subHovered = null;
      this.subSelected = null;
    },

    // Clases de la tarjeta según si es activa o no
    cardClasses (id) {
      const isActive = this.activeId === id;
      const isHover = this.hovered === id;
      return [
        isActive ? 'z-30' : 'z-10',
        'transition-transform transition-opacity duration-300',
        isActive ? 'opacity-100' : 'opacity-70 hover:opacity-90',
        isActive || isHover ? 'scale-100' : 'scale-90',
        'max-w-[920px]'
      ].join(' ');
    },

    // Posicionamiento cuando hay activo: centramos activo y “asomamos” los otros
    cardStyle (id, idx) {
      if (!this.activeId) return '';
      const activeIdx = this.items.findIndex(i => i.id === this.activeId);

      // Base: centrado
      let translateX = '0%';
      let rotate = 0;
      let scale = 1;

      if (id !== this.activeId) {
        // Acomodo left/right según posición relativa al activo
        const dir = idx < activeIdx ? -1 : 1; // izq: -1, der: 1
        translateX = `${dir * 44}%`;          // cuánto “asoma”
        rotate = dir * -4;                    // leve rotación
        scale = 0.88;                         // un poco más pequeña
      }

      // Altura y márgenes para que la activa “ocupe”
      return `
        transform: translateX(${translateX}) rotate(${rotate}deg) scale(${scale});
        top: 0; bottom: 0; left: 0; right: 0;
        margin-left: auto; margin-right: auto;
        height: 100%;
      `;
    }
  }
}
</script>
@endsection
