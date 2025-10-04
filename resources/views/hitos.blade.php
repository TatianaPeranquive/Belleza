@extends('layouts.app')
@section('title', 'Hitos - Proyecto Espejo')
@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
  .dbg-badge{font-size:11px;padding:2px 6px;border-radius:6px;background:#eef;border:1px solid #99f;color:#223}
</style>

<script>
window.hitosUI = function (ds) {
  const MOCK_ITEMS = [
    { id: 1, title: 'Hito 1 (MOCK)', text: 'Demo mientras conectamos el API.' },
    { id: 2, title: 'Hito 2 (MOCK)', text: 'Selecciona y prueba los subniveles.' },
    { id: 3, title: 'Hito 3 (MOCK)', text: 'Puedes cambiar entre hitos.' },
  ];
  const MOCK_SUB = [
    { id: 'A', title: 'Opción A (MOCK)', text: 'Subdetalle A.' },
    { id: 'B', title: 'Opción B (MOCK)', text: 'Subdetalle B.' },
    { id: 'C', title: 'Opción C (MOCK)', text: 'Subdetalle C.' },
  ];

  const useMock = (ds.mock && ds.mock.toString() === 'true');

  return {
    // ===== Helpers de normalización =====
pick(...vals) {                 // primer valor definido y no vacío
  for (const v of vals) { if (v !== undefined && v !== null && v !== '') return v; }
  return undefined;
},

toArrayFromAny(payload) {       // extrae array desde {items|data|hitos|result} o desde objeto plano
  if (Array.isArray(payload)) return payload;
  if (payload && typeof payload === 'object') {
    for (const k of ['items','data','hitos','result','results']) {
      if (Array.isArray(payload[k])) return payload[k];
    }
    // Si es {clave: valor} -> volverlo [{id: clave, title: clave, text: valor}]
    const entries = Object.entries(payload);
    if (entries.length && typeof entries[0][0] === 'string') {
      return entries.map(([k, v]) => ({ id: k, title: k, text: String(v ?? '') }));
    }
  }
  return [];
},

normalizeList(list, kind='hitos') {
  return list.map((it, idx) => {
    const id = this.pick(it.id, it.key, it.value, it.slug, it.codigo, it.cod, idx+1);
    const title = this.pick(
      it.title, it.nombre, it.name, it.label, it.etiqueta,
      it.hito, it.categoria_1, it.categoria, it.grupo, it.tipo,
      (id !== undefined ? `${kind.slice(0,-1)} ${id}` : `Elemento ${idx+1}`)
    );
    const text = this.pick(
      it.text, it.descripcion, it.description, it.detalle, it.details,
      it.resumen, it.comentario, ''
    );
    return { id, title, text };
  });
},

    // ===== Estado =====
    loading: false,
    error: '',
    hovered: null,
    activeId: null,
    activeName: '',
    showSubs: false,

    items: [],
    sub: {
      1: { visible: false, options: [], selected: null, title: 'Seleccione opción nivel 1' },
      2: { visible: false, options: [], selected: null, title: 'Seleccione opción nivel 2' },
      3: { visible: false, options: [], selected: null, title: 'Seleccione opción nivel 3' }
    },

    // ===== Endpoints desde data-* =====
    ep: {
      get hitos() { return ds.epHitos; },
      sub1(h){ return ds.epSub1 + '?hito=' + encodeURIComponent(h) },
      sub2(h,s1){ return ds.epSub2 + '?hito=' + encodeURIComponent(h) + '&sub1=' + encodeURIComponent(s1) },
      sub3(h,s1,s2){ return ds.epSub3 + '?hito=' + encodeURIComponent(h) + '&sub1=' + encodeURIComponent(s1) + '&sub2=' + encodeURIComponent(s2) },
      buscar(p){ return ds.epBuscar + '?' + p.toString() },
      buscarTexto(q){ return ds.epBuscarTexto + '?q=' + encodeURIComponent(q) }
    },

    // ===== Ciclo de vida =====
 async init(){
  this.loading = true; this.error = '';
  try {
    let j;
    if ((ds.mock && ds.mock.toString() === 'true')) {
      j = [
        { id: 1, hito: 'Hito Demo', descripcion: 'UI en modo prueba.' },
        { id: 2, hito: 'Otro Hito', descripcion: 'Para testear subniveles.' }
      ];
    } else {
      const r = await fetch(this.ep.hitos, { headers: { 'Accept':'application/json' }});
      if (!r.ok) throw new Error('HTTP '+r.status);
      j = await r.json();
    }
    console.log('[HITOS]/hitos →', j);
    const arr = this.toArrayFromAny(j);
    this.items = this.normalizeList(arr, 'hitos');
    if (!this.items.length) this.error = 'El endpoint /hitos respondió vacío o con campos inesperados.';
  } catch (e) {
    console.error('Error cargando /hitos:', e);
    this.error = 'Error cargando /hitos: ' + e.message;
    this.items = [];
  } finally {
    this.loading = false;
  }
},


    // ===== Acciones =====
    selectHito(id){
      this.activeId = id;
      const it = this.items.find(i=>i.id===id);
      this.activeName = it ? (it.title||'') : '';
      this.showSubs = false;
      this.resetFrom(1);
    },

    async continuarNivel(lvl){
      if(!this.activeId) return;
      if(lvl===1){ await this.mostrarSubNivel(1); this.showSubs = true; this.sub[1].visible = true; }
      if(lvl===2 && this.sub[1].selected){ await this.mostrarSubNivel(2); this.sub[2].visible = true; }
      if(lvl===3 && this.sub[2].selected){ await this.mostrarSubNivel(3); this.sub[3].visible = true; }
    },

   async mostrarSubNivel(lvl){
  this.loading = true; this.error='';
  try{
    let url = '';
    if (lvl===1) url = this.ep.sub1(this.activeId);
    if (lvl===2) url = this.ep.sub2(this.activeId, this.sub[1].selected);
    if (lvl===3) url = this.ep.sub3(this.activeId, this.sub[1].selected, this.sub[2].selected);

    let j;
    if ((ds.mock && ds.mock.toString() === 'true')) {
      j = [
        { id: 'A', nombre:'Opción A', descripcion:'Demo' },
        { id: 'B', nombre:'Opción B', descripcion:'Demo' },
        { id: 'C', nombre:'Opción C', descripcion:'Demo' },
      ];
    } else {
      const r = await fetch(url, { headers:{ 'Accept':'application/json' }});
      if(!r.ok) throw new Error('HTTP '+r.status);
      j = await r.json();
    }
    console.log(`[HITOS] sub${lvl} →`, j);
    const arr = this.toArrayFromAny(j);
    this.sub[lvl].options = this.normalizeList(arr, `sub${lvl}`);
  }catch(e){
    console.error('Error sub'+lvl+':', e);
    this.error = 'Error sub'+lvl+': ' + e.message;
    this.sub[lvl].options = [];
  }finally{
    this.loading = false;
  }
},


    volverNivel(lvl){ if(lvl===2){ this.resetFrom(2); this.sub[1].visible=true } if(lvl===3){ this.resetFrom(3); this.sub[2].visible=true } },

    finalizar(){
      const p = new URLSearchParams();
      p.set('hito', this.activeId || '');
      p.set('sub1', this.sub[1].selected || '');
      p.set('sub2', this.sub[2].selected || '');
      p.set('sub3', this.sub[3].selected || '');
      console.log('[HITOS] finalizar →', Object.fromEntries(p.entries()));
      // fetch(this.ep.buscar(p))
    },

    // Estética cards
    cardClasses(id){
      const isActive = this.activeId === id;
      const isHover = this.hovered === id;
      return [
        isActive ? 'z-30' : 'z-10',
        'transition-transform transition-opacity duration-300',
        isActive ? 'opacity-100' : 'opacity-70 hover:opacity-90',
        (isActive || isHover) ? 'scale-100' : 'scale-95',
        'max-w-[920px]'
      ].join(' ');
    },
    cardStyle(id, idx){
      if(!this.activeId) return '';
      const activeIdx = this.items.findIndex(i => i.id === this.activeId);
      let translateX='0%', rotate=0, scale=1;
      if(id !== this.activeId){
        const dir = idx < activeIdx ? -1 : 1;
        translateX = (dir*44)+'%'; rotate = dir*-4; scale = 0.9;
      }
      return 'transform: translateX('+translateX+') rotate('+rotate+'deg) scale('+scale+'); top:0; bottom:0; left:0; right:0; margin-left:auto; margin-right:auto; height:100%;';
    },

    resetFrom(lvl){ for(let k=lvl;k<=3;k++){ this.sub[k].visible=false; this.sub[k].options=[]; this.sub[k].selected=null; } }
  }
}
</script>

<div
  x-data="hitosUI($el.dataset)"
  data-ep-hitos="{{ url('/api/resumen/hitos') }}"
  data-ep-sub1="{{ url('/api/resumen/sub1') }}"
  data-ep-sub2="{{ url('/api/resumen/sub2') }}"
  data-ep-sub3="{{ url('/api/resumen/sub3') }}"
  data-ep-buscar="{{ url('/api/resumen/buscar') }}"
  data-ep-buscar-texto="{{ url('/api/resumen/buscar-texto') }}"
  {{-- Activa mock rápido si el API falla --}}
  data-mock="false"
  x-init="init()"
  class="mx-auto max-w-6xl px-4 pt-20 pb-12"
>
  <h1 class="mb-4 text-3xl font-extrabold tracking-tight uppercase">
    <span x-text="activeId ? (activeName || 'HITOS') : 'HITOS'"></span>
  </h1>

  <template x-if="error">
    <div class="mb-4 rounded border border-red-300 bg-red-50 px-3 py-2 text-sm text-red-700" x-text="error"></div>
  </template>

  <template x-if="loading">
    <div class="mb-4 text-sm text-slate-500">Cargando…</div>
  </template>

  <!-- GRID inicial -->
  <section class="relative w-full">
    <div x-show="!activeId" x-transition.opacity class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <template x-for="(it, idx) in items" :key="it.id">
        <button type="button"
          @click="selectHito(it.id)"
          @mouseenter="hovered = it.id" @mouseleave="hovered = null" @focus="hovered = it.id" @blur="hovered = null"
          class="relative text-left focus:outline-none transition will-change-transform transform-gpu"
          :class="{'scale-105 z-10': hovered === it.id, 'opacity-40': hovered && hovered !== it.id}">
          <div class="rounded-2xl border bg-white/90 shadow-sm transition p-6">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-lg font-semibold" x-text="it.title"></h3>
                <p class="mt-1 text-sm text-gray-600" x-text="it.text"></p>
              </div>
              <span class="dbg-badge">Explorar</span>
            </div>
          </div>
        </button>
      </template>
    </div>

    <!-- Tarjetas apiladas -->
    <div x-show="activeId" x-transition class="relative h-[480px] sm:h-[520px] lg:h-[560px]">
      <template x-for="(it, idx) in items" :key="it.id">
        <button type="button"
          @click="selectHito(it.id)"
          @mouseenter="hovered = it.id" @mouseleave="hovered = null" @focus="hovered = it.id" @blur="hovered = null"
          class="absolute inset-0 mx-auto focus:outline-none transition will-change-transform transform-gpu"
          :style="cardStyle(it.id, idx)" :class="cardClasses(it.id)">
          <div class="h-full w-full rounded-3xl border bg-white shadow-xl transition p-6 overflow-hidden">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-xl font-semibold" x-text="it.title"></h3>
                <p class="mt-2 text-sm text-gray-600" x-text="it.text"></p>
              </div>
              <span class="dbg-badge" :class="activeId === it.id ? '' : ''" x-text="activeId === it.id ? 'Seleccionado' : 'Cambiar'"></span>
            </div>
          </div>
        </button>
      </template>
    </div>
  </section>

  <!-- Botón continuar -->
  <div x-show="activeId && !showSubs" x-transition.opacity class="mt-6">
    <button type="button" @click="continuarNivel(1)"
      class="group inline-flex items-center gap-2 rounded-2xl px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300">
      Continuar
    </button>
  </div>

  <!-- Subniveles -->
  <section id="subs" x-show="showSubs" x-transition.opacity class="mt-10 space-y-10">
    <template x-for="lvl in [1,2,3]" :key="'lvl-'+lvl">
      <div x-show="sub[lvl].visible">
        <div class="flex items-center justify-between mb-3">
          <h2 class="text-xl font-semibold" x-text="sub[lvl].title"></h2>
          <div class="flex gap-2">
            <button type="button" class="rounded-xl border px-4 py-2 text-sm" x-show="lvl>1" @click="volverNivel(lvl)">Volver</button>
            <button type="button" class="rounded-xl bg-indigo-600 text-white px-4 py-2 text-sm disabled:opacity-50"
              :disabled="!sub[lvl].selected" @click="continuarNivel(lvl+1)" x-show="lvl<3">Continuar</button>
            <button type="button" class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm disabled:opacity-50"
              :disabled="!sub[3].selected" @click="finalizar()" x-show="lvl===3">Finalizar</button>
          </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <template x-for="subopt in sub[lvl].options" :key="subopt.id">
            <button type="button"
              @click="sub[lvl].selected = subopt.id"
              class="relative text-left focus:outline-none transition will-change-transform transform-gpu"
              :class="{'scale-[1.02] z-10': sub[lvl].selected === subopt.id}">
              <div class="rounded-2xl border bg-white/90 shadow-sm transition p-6">
                <div class="flex items-start justify-between gap-4">
                  <div>
                    <h3 class="text-lg font-semibold" x-text="subopt.title"></h3>
                    <p class="mt-1 text-sm text-gray-600" x-text="subopt.text"></p>
                  </div>
                  <span class="dbg-badge" x-text="(sub[lvl].selected === subopt.id) ? 'Elegido' : 'Explorar'"></span>
                </div>
              </div>
            </button>
          </template>
        </div>
      </div>
    </template>
  </section>
</div>
@endsection
