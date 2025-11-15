  {{-- HITOS ESTETICA COLUMNA IZQUIERDA HITOS--}}

 @extends('layouts.app')
@section('title', 'Hitos - Proyecto Espejo')
@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
window.hitosUI = function (ds) {
  const useMock = (ds.mock && ds.mock.toString() === 'true');
  return {
    /* ===== Estado ===== */
    loading: false,
    error: '',
    hovered: null,
    activeId: null,
    activeName: '',
    // filtros
    items: [],
    sub: {
      1: { options: [], selected: null, title: 'Seleccione opción nivel 1' },
      2: { options: [], selected: null, title: 'Seleccione opción nivel 2' },
      3: { options: [], selected: null, title: 'Seleccione opción nivel 3' }
    },
    // resultados
    results: [],           // [{id, title, text, raw}]
    hoveredRes: null,
    activeResId: null,
    showResults: false,

    /* ===== Endpoints desde data-* ===== */
    ep: {
      get hitos() { return ds.epHitos; },
      sub1(h){ return ds.epSub1 + '?hito=' + encodeURIComponent(h) },
      sub2(h,s1){ return ds.epSub2 + '?hito=' + encodeURIComponent(h) + '&sub1=' + encodeURIComponent(s1) },
      sub3(h,s1,s2){ return ds.epSub3 + '?hito=' + encodeURIComponent(h) + '&sub1=' + encodeURIComponent(s1) + '&sub2=' + encodeURIComponent(s2) },
      buscar(p){ return ds.epBuscar + '?' + p.toString() },
      buscarTexto(q){ return ds.epBuscarTexto + '?q=' + encodeURIComponent(q) }
    },

    /* ===== Helpers ===== */
    pick(){ for(let i=0;i<arguments.length;i++){ const v = arguments[i]; if(v!==undefined && v!==null && v!=='') return v; } },
    toArrayFromAny(payload){ if(Array.isArray(payload)) return payload;
      if(payload && typeof payload==='object'){
        for(const k of ['items','data','hitos','result','results']){ if(Array.isArray(payload[k])) return payload[k]; }
        const entries = Object.entries(payload);
        if(entries.length && typeof entries[0][0]==='string'){ return entries.map(([k,v])=>({id:k,title:k,text:String(v??'')})); }
      } return []; },
    normalizeList(list, kind='hitos'){
      return list.map((it, idx)=>{
        const id    = this.pick(it.id, it.key, idx+1);
        const title = this.pick(it.title, it.nombre, it.name, it.label, it.hito, it.categoria_1, it.categoria, `Elemento ${idx+1}`);
        const text  = this.pick(it.text, it.descripcion, it.description, it.detalle, it.resumen, '');
        return { id, title, text };
      });
    },
    normalizeResults(list){
      return list.map((row, idx)=>{
        const id    = idx+1;
        const title = this.pick(row.titulo, row.title, row.asunto, row.categoria_4, row.categoria_3, row.categoria_2, row.categoria_1, `Comentario ${id}`);
        const text  = this.pick(row.comentario, row.comentarios, row.observacion, row.observaciones, row.descripcion, row.description, '');
        const summary = text ? String(text) : JSON.stringify(row).slice(0,200);
        return { id, title: String(title), text: summary, raw: row };
      });
    },

    /* ===== Ciclo de vida ===== */
    async init(){
      this.loading = true; this.error = '';
      try {
        let j;
        if(useMock){
          j = [{id:1,title:'Hito 1'}, {id:2,title:'Hito 2'},{id:3,title:'Hito 3'}];
        } else {
          const r = await fetch(this.ep.hitos, { headers: {'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.items = this.normalizeList(arr, 'hitos');

        // Preselección por ?hito=<id>
        const params = new URLSearchParams(window.location.search);
        const pre = params.get('hito');
        if (pre) {
          const preId = Number(pre);
          if (this.items.some(i => i.id === preId)) {
            this.selectHito(preId, {silent:true});
            await this.loadSub1(); // auto abre nivel 1 con el hito dado
          }
        }
      } catch (e) {
        console.error('Error /hitos:', e);
        this.error = 'Error cargando hitos: '+e.message;
        this.items = [];
      } finally { this.loading = false; }
    },

    /* ===== Acciones de filtros ===== */
    async loadSub1(){
      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){ j = [{id:1,title:'A'},{id:2,title:'B'}]; } else {
          const r = await fetch(this.ep.sub1(this.activeId), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.sub[1].options = this.normalizeList(arr, 'sub1');
      }catch(e){
        this.error = 'Error sub1: '+e.message;
        this.sub[1].options = [];
      }finally{ this.loading=false; }
    },
    async loadSub2(){
      if(!this.sub[1].selected) return;
      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){ j = [{id:1,title:'A1'},{id:2,title:'B1'}]; } else {
          const r = await fetch(this.ep.sub2(this.activeId, this.sub[1].selected), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.sub[2].options = this.normalizeList(arr, 'sub2');
      }catch(e){
        this.error = 'Error sub2: '+e.message;
        this.sub[2].options = [];
      }finally{ this.loading=false; }
    },
    async loadSub3(){
      if(!this.sub[2].selected) return;
      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){ j = [{id:1,title:'A2'},{id:2,title:'B2'}]; } else {
          const r = await fetch(this.ep.sub3(this.activeId, this.sub[1].selected, this.sub[2].selected), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.sub[3].options = this.normalizeList(arr, 'sub3');
      }catch(e){
        this.error = 'Error sub3: '+e.message;
        this.sub[3].options = [];
      }finally{ this.loading=false; }
    },

    selectHito(id, opts={silent:false}){
      this.activeId = id;
      const it = this.items.find(i=>i.id===id);
      this.activeName = it ? (it.title||'') : '';
      if (!opts.silent) {
        // al cambiar hito, limpiar subniveles y resultados
        this.sub[1].selected = null; this.sub[2].selected = null; this.sub[3].selected = null;
        this.sub[1].options = []; this.sub[2].options = []; this.sub[3].options = [];
        this.results = []; this.activeResId = null; this.showResults = false;
        this.loadSub1();
      }
    },

    async buscar(){
      const p = new URLSearchParams();
      p.set('hito', this.activeId || '');
      if(this.sub[1].selected) p.set('sub1', this.sub[1].selected);
      if(this.sub[2].selected) p.set('sub2', this.sub[2].selected);
      if(this.sub[3].selected) p.set('sub3', this.sub[3].selected);

      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){
          j = [
            { comentario: 'Comentario de prueba 1. Lorem ipsum dolor sit amet.' , categoria_2:'X'},
            { comentario: 'Comentario de prueba 2. Sed do eiusmod tempor.' , categoria_2:'Y'},
            { comentario: 'Comentario de prueba 3. Ut enim ad minim veniam.' , categoria_2:'Z'}
          ];
        } else {
          const r = await fetch(this.ep.buscar(p), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.results = this.normalizeResults(arr);
        this.showResults = true;
        this.activeResId = this.results.length ? this.results[0].id : null;
      } catch(e){
        this.error = 'Error consultando resultados: '+e.message;
        this.results = []; this.showResults = true;
      } finally { this.loading=false; }
    },

    /* ===== Estética: tarjetas apiladas HORIZONTALES para resultados ===== */
    rCardClasses(id){
      const isActive = this.activeResId === id;
      const isHover  = this.hoveredRes === id;
      return [
        isActive ? 'z-20' : 'z-10',
        'transition-transform transition-opacity duration-300',
        isActive ? 'opacity-100' : 'opacity-80 hover:opacity-95',
        (isActive || isHover) ? 'scale-100' : 'scale-[0.98]',
        'mx-auto w-[720px] max-w-full h-40'
      ].join(' ');
    },
    rCardStyle(id, idx){
      const activeIdx = this.results.findIndex(i => i.id === this.activeResId);
      let translateX='0%', rotate=0, scale=1;
      if(id !== this.activeResId){
        const dir = idx < activeIdx ? -1 : 1; // izq/der
        translateX = (dir * 44) + '%';
        rotate     = dir * -4;
        scale      = 0.92;
      }
      return 'position:absolute; top:0; bottom:0; left:0; right:0; margin:auto; transform: translateX('+translateX+') rotate('+rotate+'deg) scale('+scale+');';
    }
  }
}
</script>

<div id="hitos-top"
  x-data="hitosUI($el.dataset)"
  data-ep-hitos="{{ url('/api/resumen/hitos') }}"
  data-ep-sub1="{{ url('/api/resumen/sub1') }}"
  data-ep-sub2="{{ url('/api/resumen/sub2') }}"
  data-ep-sub3="{{ url('/api/resumen/sub3') }}"
  data-ep-buscar="{{ url('/api/resumen/buscar') }}"
  data-ep-buscar-texto="{{ url('/api/resumen/buscar-texto') }}"
  data-mock="false"
  x-init="init()"
  class="mx-auto max-w-7xl px-4 pt-20 pb-12"
>
  <h1 class="mb-6 text-3xl font-extrabold tracking-tight uppercase">HITOS</h1>

  <template x-if="error">
    <div class="mb-4 rounded border border-red-300 bg-red-50 px-3 py-2 text-sm text-red-700" x-text="error"></div>
  </template>

  <!-- Layout: Hitos (izq) + Filtros (der) -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Columna izquierda: lista de Hitos SIEMPRE visible -->
    <section class="lg:col-span-1">
      <h2 class="mb-2 text-sm font-semibold text-slate-600">Hitos</h2>
      <div class="grid gap-1">
        <template x-for="(it, idx) in items" :key="it.id">
          <button type="button"
            @click="selectHito(it.id)"
            @mouseenter="hovered = it.id" @mouseleave="hovered = null" @focus="hovered = it.id" @blur="hovered = null"
            class="rounded-xl border bg--[#34113F]/90 shadow-sm transition px-4 h-12 flex items-center justify-between text-left focus:outline-none"
            :class="{'ring-2 ring-indigo-500': activeId === it.id}">
            <h3 class="text-sm font-semibold truncate" x-text="it.title"></h3>
            <span class="rounded-full px-2 py-0.5 text-[10px] font-medium"
              :class="activeId === it.id ? 'bg-indigo-600 text--[#34113F]' : 'bg-gray-200 text-gray-700'"
              x-text="activeId === it.id ? 'Elegido' : 'Elegir'"></span>
          </button>
        </template>
      </div>
    </section>

    <!-- Columna derecha: filtros de categorías (subniveles) -->
    <section class="lg:col-span-2">
      <h2 class="mb-2 text-sm font-semibold text-slate-600">Categorías</h2>

      <!-- Nivel 1 -->
      <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
          <h3 class="text-base font-semibold">Nivel 1</h3>
          <span class="text-xs text-slate-500" x-text="sub[1].selected ? 'Seleccionado: '+ sub[1].selected : ''"></span>
        </div>
        <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-4">
          <template x-for="opt in sub[1].options" :key="opt.id">
            <button type="button"
              @click="sub[1].selected = opt.id; loadSub2();"
              class="rounded-lg border bg--[#34113F] px-3 py-2 text-left text-sm hover:shadow focus:outline-none"
              :class="{'ring-2 ring-indigo-500': sub[1].selected === opt.id}">
              <span class="font-medium" x-text="opt.title"></span>
            </button>
          </template>
        </div>
      </div>

      <!-- Nivel 2 -->
      <div class="mb-6" x-show="sub[1].selected">
        <div class="flex items-center justify-between mb-2">
          <h3 class="text-base font-semibold">Nivel 2</h3>
          <span class="text-xs text-slate-500" x-text="sub[2].selected ? 'Seleccionado: '+ sub[2].selected : ''"></span>
        </div>
        <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-4">
          <template x-for="opt in sub[2].options" :key="opt.id">
            <button type="button"
              @click="sub[2].selected = opt.id; loadSub3();"
              class="rounded-lg border bg--[#34113F] px-3 py-2 text-left text-sm hover:shadow focus:outline-none"
              :class="{'ring-2 ring-indigo-500': sub[2].selected === opt.id}">
              <span class="font-medium" x-text="opt.title"></span>
            </button>
          </template>
        </div>
      </div>

      <!-- Nivel 3 -->
      <div class="mb-6" x-show="sub[2].selected">
        <div class="flex items-center justify-between mb-2">
          <h3 class="text-base font-semibold">Nivel 3</h3>
          <span class="text-xs text-slate-500" x-text="sub[3].selected ? 'Seleccionado: '+ sub[3].selected : ''"></span>
        </div>
        <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-4">
          <template x-for="opt in sub[3].options" :key="opt.id">
            <button type="button"
              @click="sub[3].selected = opt.id"
              class="rounded-lg border bg--[#34113F] px-3 py-2 text-left text-sm hover:shadow focus:outline-none"
              :class="{'ring-2 ring-indigo-500': sub[3].selected === opt.id}">
              <span class="font-medium" x-text="opt.title"></span>
            </button>
          </template>
        </div>
      </div>

      <div class="mt-4">
        <button type="button" @click="buscar()"
          class="inline-flex items-center gap-2 rounded-2xl px-6 py-3 text-base font-semibold text--[#34113F] bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 disabled:opacity-50"
          :disabled="!activeId">
          Mostrar comentarios
        </button>
      </div>
    </section>
  </div>

  <!-- RESULTADOS: tarjetas apiladas HORIZONTALES con comentarios -->
  <section id="resultados" x-show="showResults" x-transition.opacity class="mt-12">
    <div class="mb-3 flex items-end justify-between">
      <h2 class="text-xl font-semibold">Comentarios encontrados <span class="text-slate-500 text-sm" x-text="`(${results.length})`"></span></h2>
      <template x-if="results.length === 0">
        <span class="text-sm text-slate-500">No hay resultados para los filtros seleccionados.</span>
      </template>
    </div>

    <div class="relative h-[420px]" x-show="results.length > 0">
      <template x-for="(r, idx) in results" :key="r.id">
        <div
          @mouseenter="hoveredRes = r.id" @mouseleave="hoveredRes = null"
          @click="activeResId = r.id"
          class="absolute inset-0 mx-auto cursor-pointer select-none"
          :style="rCardStyle(r.id, idx)"
          :class="rCardClasses(r.id)">
          <div class="w-full h-full rounded-2xl border bg--[#34113F] shadow-md transition p-5 overflow-hidden flex flex-col justify-between">
            <h3 class="text-base font-semibold truncate" x-text="r.title"></h3>
            <p class="mt-1 text-sm text-gray-700 line-clamp-3" x-text="r.text"></p>
          </div>
        </div>
      </template>
    </div>
  </section>

  <template x-if="loading">
    <div class="mt-4 text-sm text-slate-500">Cargando…</div>
  </template>
</div>
@endsection
