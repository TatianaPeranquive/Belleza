@extends('layouts.app')
@section('title', 'Hitos - Proyecto Espejo (peek effect)')
@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
window.hitosUI = function (ds) {
  const useMock = (ds.mock && ds.mock.toString() === 'true');
  return {
    loading: false,
    error: '',
    items: [],
    activeId: null,
    activeName: '',
    sub: {
      1: { options: [], selected: null, selectedTitle: '', title: 'Nivel 1' },
      2: { options: [], selected: null, selectedTitle: '', title: 'Nivel 2' },
      3: { options: [], selected: null, selectedTitle: '', title: 'Nivel 3' },
      4: { options: [], selected: null, selectedTitle: '', title: 'Nivel 4' },
    },
    applied: { hito: '', sub1: '', sub2: '', sub3: '', sub4: '' },
    results: [],
    showResults: false,
    hoveredRes: null,
    activeResId: null,
// --- getters (reactivos) ---
get hasSelection(){
  return !!(this.activeId || this.sub[1].selected || this.sub[2].selected || this.sub[3].selected || this.sub[4].selected);
},
get previewChips(){
  return [
    this.activeName ? {k:'Hito', v:this.activeName} : null,
    this.sub[1].selectedTitle ? {k:'N1', v:this.sub[1].selectedTitle} : null,
    this.sub[2].selectedTitle ? {k:'N2', v:this.sub[2].selectedTitle} : null,
    this.sub[3].selectedTitle ? {k:'N3', v:this.sub[3].selectedTitle} : null,
    this.sub[4].selectedTitle ? {k:'N4', v:this.sub[4].selectedTitle} : null,
  ].filter(Boolean);
},

    ep: {
      get hitos() { return ds.epHitos; },
      sub1(h){ return ds.epSub1 + '?hito=' + encodeURIComponent(h) },
      sub2(h,s1){ return ds.epSub2 + '?hito=' + encodeURIComponent(h) + '&sub1=' + encodeURIComponent(s1) },
      sub3(h,s1,s2){ return ds.epSub3 + '?hito=' + encodeURIComponent(h) + '&sub1=' + encodeURIComponent(s1) + '&sub2=' + encodeURIComponent(s2) },
      sub4(h,s1,s2,s3){ return (ds.epSub4 || '').toString() + '?hito=' + encodeURIComponent(h) + '&sub1=' + encodeURIComponent(s1) + '&sub2=' + encodeURIComponent(s2) + '&sub3=' + encodeURIComponent(s3) },
      buscar(p){ return ds.epBuscar + '?' + p.toString() },
    },

    pick(){ for(let i=0;i<arguments.length;i++){ const v = arguments[i]; if(v!==undefined && v!==null && v!=='') return v; } },
    toArrayFromAny(payload){ if(Array.isArray(payload)) return payload;
      if(payload && typeof payload==='object'){
        for(const k of ['items','data','hitos','result','results']){ if(Array.isArray(payload[k])) return payload[k]; }
        const entries = Object.entries(payload);
        if(entries.length && typeof entries[0][0]==='string'){ return entries.map(([k,v])=>({id:k,title:k,text:String(v??'')})); }
      } return []; },
    normalizeList(list){
      return list.map((it, idx)=>{
        const id    = this.pick(it.id, it.key, it.value, idx+1);
        const title = this.pick(it.title, it.nombre, it.name, it.label, it.hito, it.categoria_1, it.categoria, `Elemento ${idx+1}`);
        const text  = this.pick(it.text, it.descripcion, it.description, it.detalle, it.resumen, '');
        return { id, title, text };
      });
    },
    normalizeResults(list){
      return list.map((row, idx)=>{
        const id    = this.pick(row.id, row.key, row.pk, idx+1);
        const title = this.pick(row.titulo, row.title, row.asunto, row.categoria_4, row.categoria_3, row.categoria_2, row.categoria_1, `Comentario ${id}`);
        const text  = this.pick(row.comentario, row.comentarios, row.observacion, row.observaciones, row.descripcion, row.description, '');
        const user  = this.pick(row.usuario, row.user, row.autor, row.creado_por, row.responsable, '');
        const meeting = this.pick(row.reunion, row.reunión, row.meeting, row.sesion, row.session, row.evento, row.fecha_reunion, row.fecha, '');
        const summary = text ? String(text) : 'Sin comentario';
        return { id, title: String(title||''), text: summary, user: String(user||''), meeting: String(meeting||''), raw: row };
      });
    },
    updateQueryParam(name, value){
      const url = new URL(window.location.href);
      if (value === null || value === undefined || value === '') {
        url.searchParams.delete(name);
      } else {
        url.searchParams.set(name, String(value));
      }
      window.history.replaceState({}, '', url.toString());
    },

    async init(){
      this.loading = true; this.error = '';
      try {
        let j;
        if(useMock){
          j = [{id:1,title:'Primer hito'}, {id:2,title:'Segundo hito'},{id:3,title:'Tercer hito'}];
        } else {
          const r = await fetch(this.ep.hitos, { headers: {'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.items = this.normalizeList(arr);

        const params = new URLSearchParams(window.location.search);
        const pre = params.get('hito');
        if (pre) {
          const preId = Number(pre);
          const preItem = this.items.find(i => String(i.id) === String(preId));
          if (preItem) {
            this.selectHito(preItem.id, {silent:true, nameOverride: preItem.title});
            await this.loadSub1();
          }
        }
      } catch (e) {
        console.error('Error /hitos:', e);
        this.error = 'Error cargando hitos: '+e.message;
        this.items = [];
      } finally { this.loading = false; }
    },

    async loadSub1(){
      if(!this.activeId) return;
      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){ j = [{id:1,title:'Aprendizajes de la belleza'},{id:2,title:'Lo femenino'}]; } else {
          const r = await fetch(this.ep.sub1(this.activeId), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.sub[1].options = this.normalizeList(arr);
      }catch(e){
        this.error = 'Error nivel 1: '+e.message;
        this.sub[1].options = [];
      }finally{ this.loading=false; }
    },
    async loadSub2(){
      if(!this.activeId || !this.sub[1].selected) return;
      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){ j = [{id:1,title:'Hábitos'},{id:2,title:'Influencia'}]; } else {
          const r = await fetch(this.ep.sub2(this.activeId, this.sub[1].selected), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.sub[2].options = this.normalizeList(arr);
      }catch(e){
        this.error = 'Error nivel 2: '+e.message;
        this.sub[2].options = [];
      }finally{ this.loading=false; }
    },
    async loadSub3(){
      if(!this.activeId || !this.sub[1].selected || !this.sub[2].selected) return;
      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){ j = [{id:1,title:'Clase'},{id:2,title:'Costumbres'}]; } else {
          const r = await fetch(this.ep.sub3(this.activeId, this.sub[1].selected, this.sub[2].selected), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.sub[3].options = this.normalizeList(arr);
      }catch(e){
        this.error = 'Error nivel 3: '+e.message;
        this.sub[3].options = [];
      }finally{ this.loading=false; }
    },
    async loadSub4(){
      if(!(ds.epSub4) || !this.activeId) return;
      if(!this.sub[1].selected || !this.sub[2].selected || !this.sub[3].selected) return;
      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){ j = [{id:1,title:'Opción 4-1'},{id:2,title:'Opción 4-2'}]; } else {
          const r = await fetch(this.ep.sub4(this.activeId, this.sub[1].selected, this.sub[2].selected, this.sub[3].selected), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.sub[4].options = this.normalizeList(arr);
      }catch(e){
        this.error = 'Error nivel 4: '+e.message;
        this.sub[4].options = [];
      }finally{ this.loading=false; }
    },

    selectHito(id, opts={silent:false, nameOverride:null}){
      this.activeId = id;
      const it = this.items.find(i=>i.id===id);
      this.activeName = opts.nameOverride ?? (it ? (it.title||'') : '');
      this.updateQueryParam('hito', id);
      if (!opts.silent) {
        for (let k=1;k<=4;k++){ this.sub[k].selected = null; this.sub[k].selectedTitle=''; this.sub[k].options = []; }
        this.results = []; this.showResults = false; this.activeResId = null;
        this.loadSub1();
      }
    },
choose(lvl, opt){
  // 1) aplicar selección del nivel actual
  this.sub[lvl].selected      = opt.id;
  this.sub[lvl].selectedTitle = opt.title || String(opt.id);

  // 2) resetear niveles inferiores
  for (let k = lvl + 1; k <= 4; k++) {
    this.sub[k].selected = null;
    this.sub[k].selectedTitle = '';
    this.sub[k].options = [];
  }

  // 3) ocultar resultados y limpiar el carrusel
  this.showResults = false;   // <- clave: vuelve a "Vista previa"
  this.results = [];          // opcional: si prefieres cachear, quita esta línea
  this.activeResId = null;

  // 4) cargar el siguiente nivel (si aplica)
  if (lvl === 1) this.loadSub2();
  if (lvl === 2) this.loadSub3();
  if (lvl === 3) this.loadSub4();

  // 5) enfocar/scroll al bloque central (opcional, pero útil)
  this.$nextTick(() => {
    document.getElementById('resultados')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
},

    nextRes(){
      if(!this.results.length) return;
      const i = this.results.findIndex(r => r.id === this.activeResId);
      const ni = (i + 1) % this.results.length;
      this.activeResId = this.results[ni].id;
    },
    prevRes(){
      if(!this.results.length) return;
      const i = this.results.findIndex(r => r.id === this.activeResId);
      const ni = (i - 1 + this.results.length) % this.results.length;
      this.activeResId = this.results[ni].id;
    },

    async buscar(){
      this.applied = {
        hito: this.activeName || '',
        sub1: this.sub[1].selectedTitle || '',
        sub2: this.sub[2].selectedTitle || '',
        sub3: this.sub[3].selectedTitle || '',
        sub4: this.sub[4].selectedTitle || ''
      };

      const p = new URLSearchParams();
      p.set('hito', this.activeId || '');
      if(this.sub[1].selected) p.set('sub1', this.sub[1].selected);
      if(this.sub[2].selected) p.set('sub2', this.sub[2].selected);
      if(this.sub[3].selected) p.set('sub3', this.sub[3].selected);
      if(this.sub[4].selected) p.set('sub4', this.sub[4].selected);

      this.loading = true; this.error='';
      try{
        let j;
        if(useMock){
          j = [
            { comentario: 'Comentario 1 '.repeat(100), usuario:'Ana', reunion:'Kickoff 2025-01-10' },
            { comentario: 'Comentario 2 '.repeat(120), usuario:'Luis', reunion:'Revisión 2025-02-02' },
            { comentario: 'Comentario 3 '.repeat(80), usuario:'Marta', reunion:'Cierre 2025-03-15' }
          ];
        } else {
          const r = await fetch(this.ep.buscar(p), { headers:{'Accept':'application/json'} });
          if(!r.ok) throw new Error('HTTP '+r.status);
          j = await r.json();
        }
        const arr = this.toArrayFromAny(j);
        this.results = this.normalizeResults(arr);
        this.showResults = true;
        this.activeResId = (this.results.length ? this.results[0].id : null);
        await this.$nextTick();
        const lane = document.querySelector('#resultados .lane');
        lane?.focus({preventScroll:true});
        document.getElementById('resultados')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        console.log('Resultados cargados:', this.results.length);
      } catch(e){
        this.error = 'Error consultando resultados: '+e.message;
        this.results = []; this.showResults = true;
        console.error(e);
      } finally { this.loading=false; }
    },

    rCardClasses(id){
      const isActive = this.activeResId === id;
      const isHover  = this.hoveredRes === id;
      return [
        isActive ? 'z-30' : 'z-10',
        'transition-transform transition-opacity duration-300',
        isActive ? 'opacity-100' : 'opacity-80 hover:opacity-90',
        (isActive || isHover) ? '' : '',
      ].join(' ');
    },
    rCardStyle(id, idx){
      if (this.activeResId == null && this.results.length) {
        this.activeResId = this.results[0].id;
      }
      const activeIdx = Math.max(0, this.results.findIndex(i => i.id === this.activeResId));
      let tx=0, ty=0, rot=0, scale=1, extra='';
      if(id !== this.activeResId){
        const dir = idx < activeIdx ? -1 : 1;
        tx = dir * 56;   // más desplazamiento para que se vean los bordes
        rot = dir * -4;  // giro suave
        scale = 0.90;    // más pequeño atrás
        ty = dir * 2;    // leve offset vertical
        extra = 'box-shadow: 0 6px 18px rgba(0,0,0,.12);';
      } else {
        extra = 'box-shadow: 0 12px 28px rgba(0,0,0,.20);';
      }
      return `position:absolute; inset:0; margin:auto; width:560px; height:560px; transform: translate(${tx}%, ${ty}px) rotate(${rot}deg) scale(${scale}); ${extra}`;
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
  {{-- data-ep-sub4="{{ url('/api/resumen/sub4') }}" --}}
  data-ep-buscar="{{ url('/api/resumen/buscar') }}"
  data-mock="false"
  x-init="init()"
  class="mx-auto max-w-7xl px-4 pt-20 pb-12"
>
  <h1 class="mb-4 text-3xl font-extrabold tracking-tight uppercase">HITOS</h1>

  <template x-if="error">
    <div class="mb-4 rounded border border-red-300 bg-red-50 px-3 py-2 text-sm text-red-700" x-text="error"></div>
  </template>

  <!-- TOP BAR centrada -->
  <section class="mb-6">
    <div class="rounded-xl border bg-white/70 backdrop-blur px-4 py-3">
      <div class="mx-auto flex justify-center gap-3 overflow-x-auto no-scrollbar">
        <template x-for="(it, idx) in items" :key="it.id">
          <button type="button"
            @click="selectHito(it.id)"
            class="shrink-0 rounded-full border px-4 py-2 text-sm bg-white hover:shadow focus:outline-none transition flex items-center justify-center text-center"
            :class="{'ring-2 ring-indigo-500': activeId === it.id}">
            <span class="font-medium text-center" x-text="it.title"></span>
          </button>
        </template>
      </div>
    </div>
     <br>
         <div class="mb-4 flex items-center justify-center">
        <button type="button" @click="buscar()"
          class="inline-flex items-center gap-2 rounded-2xl px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 disabled:opacity-50"
          :disabled="!activeId">
          Mostrar comentarios
        </button>
        <br><br>
      </div>
  </section>

  <!-- GRID: centro más ancho -->
  <div class="grid grid-cols-1 lg:grid-cols-3 xl:[grid-template-columns:1fr_1.8fr_1fr] gap-8">
    <!-- Columna izquierda: N1 + N2 -->
    <section class="grid grid-rows-2 gap-8 relative z-10">
      <div>
        <div class="flex items-center justify-between mb-2">
          <h2 class="text-sm font-semibold text-slate-600">Nivel 1</h2>
          <span class="text-xs text-slate-500" x-text="sub[1].selectedTitle ? 'Sel.: '+ sub[1].selectedTitle : ''"></span>
        </div>
        <div class="grid gap-3 sm:grid-cols-2">
          <template x-for="opt in sub[1].options" :key="opt.id">
            <button type="button"
              @click="choose(1,opt)"
              class="rounded-lg border bg-white px-3 py-2 text-left text-sm hover:shadow focus:outline-none"
              :class="{'ring-2 ring-indigo-500': sub[1].selected === opt.id}">
              <span class="font-medium" x-text="opt.title"></span>
            </button>
          </template>
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between mb-2">
          <h2 class="text-sm font-semibold text-slate-600">Nivel 2</h2>
          <span class="text-xs text-slate-500" x-text="sub[2].selectedTitle ? 'Sel.: '+ sub[2].selectedTitle : ''"></span>
        </div>
        <div class="grid gap-3 sm:grid-cols-2">
          <template x-for="opt in sub[2].options" :key="opt.id">
            <button type="button"
              @click="choose(2,opt)"
              class="rounded-lg border bg-white px-3 py-2 text-left text-sm hover:shadow focus:outline-none"
              :class="{'ring-2 ring-indigo-500': sub[2].selected === opt.id}">
              <span class="font-medium" x-text="opt.title"></span>
            </button>
          </template>
        </div>
      </div>

    </section>

    <!-- Centro: botón + carril resultados -->
    <section class="relative z-0">

<!-- PREVIEW (antes de buscar) -->
<div class="lane relative overflow-hidden rounded-xl border bg-white/40 backdrop-blur-sm outline-none"
     style="height: 420px;"
     x-show="!showResults && hasSelection">
  <div class="absolute inset-0 m-auto w-[min(680px,92vw)] h-[360px] rounded-2xl border border-dashed bg-white/70 p-6">
    <h3 class="text-lg font-semibold text-slate-700">Vista previa</h3>
    <p class="mt-1 text-sm text-slate-600">
      Selecciona más filtros o pulsa <strong>“Mostrar comentarios”</strong> para ver coincidencias.
    </p>

    <div class="mt-4 flex flex-wrap gap-2">
      <template x-for="chip in previewChips" :key="chip.k">
        <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 text-slate-700 border border-slate-200 px-2 py-1 text-sm">
          <strong x-text="chip.k+':'"></strong> <span x-text="chip.v"></span>
        </span>
      </template>
    </div>

    <div class="mt-6 text-xs text-slate-500">
      Los comentarios no se consultan hasta que presiones el botón.
    </div>
  </div>
</div>

      <section id="resultados" class="mt-2 relative isolate">
        <div class="mb-3 flex items-end justify-between"
            x-show="showResults"
            x-transition.opacity
            x-cloak>
        <h2 class="text-xl font-semibold">
            Comentarios <span class="text-slate-500 text-sm" x-text="`(${results.length})`"></span>
        </h2>
        </div>

        <!-- Estado vacío -->
        <div x-show="showResults && results.length === 0" class="rounded-xl border bg-white px-4 py-10 text-center text-slate-500">
          No hay resultados para los filtros seleccionados.
        </div>

        <!-- Carril con máscaras de borde para reforzar la pila -->
        <div class="lane relative overflow-hidden rounded-xl border bg-white/40 backdrop-blur-sm outline-none"
             style="height: 640px;"
             x-show="results.length > 0"
             tabindex="0"
             @keydown.left.prevent="prevRes()"
             @keydown.right.prevent="nextRes()">
          <!-- edge masks (no bloquean clics) -->
          <div style="pointer-events:none; position:absolute; left:0; top:0; bottom:0; width:56px; background:linear-gradient(to right, rgba(255,255,255,.92), rgba(255,255,255,0)); z-index:25;"></div>
          <div style="pointer-events:none; position:absolute; right:0; top:0; bottom:0; width:56px; background:linear-gradient(to left, rgba(255,255,255,.92), rgba(255,255,255,0)); z-index:25;"></div>

          <!-- flechas -->
          <button type="button" @click="prevRes()"
                  class="absolute left-2 top-1/2 -translate-y-1/2 z-30 rounded-full bg-white/90 border shadow px-3 py-2 hover:bg-white">
            ←
          </button>
          <button type="button" @click="nextRes()"
                  class="absolute right-2 top-1/2 -translate-y-1/2 z-30 rounded-full bg-white/90 border shadow px-3 py-2 hover:bg-white">
            →
          </button>

          <template x-for="(r, idx) in results" :key="r.id">
            <div
              @mouseenter="hoveredRes = r.id" @mouseleave="hoveredRes = null"
              @click="activeResId = r.id"
              class="absolute inset-0 mx-auto cursor-pointer select-none"
              :style="rCardStyle(r.id, idx)"
              :class="rCardClasses(r.id)">
              <div class="w-full h-full rounded-2xl border bg-white shadow-md transition p-5 overflow-hidden flex flex-col">
                <div class="flex items-start justify-between gap-3">
                  <div class="min-w-0">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Usuario</div>
                    <div class="text-xl font-extrabold text-indigo-700 leading-tight" x-text="r.user || '—'"></div>
                  </div>
                  <div class="shrink-0 text-right">
                    <div class="text-xs text-slate-500">Reunión</div>
                    <div class="text-sm font-semibold text-slate-700" x-text="r.meeting || '—'"></div>
                  </div>
                </div>
                <h3 class="mt-2 text-sm font-semibold text-slate-800 truncate" x-text="r.title"></h3>
                <div class="mt-2 flex-1 overflow-auto pr-2" style="max-height: 28rem;"
                     class="text-sm text-gray-900 whitespace-pre-line"
                     x-text="r.text && r.text.trim() !== '' ? r.text : 'Sin comentario'"></div>
                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                  <template x-if="applied.hito">
                    <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 px-2 py-1">
                      <strong>Hito:</strong> <span x-text="applied.hito"></span>
                    </span>
                  </template>
                  <template x-if="applied.sub1">
                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 text-slate-700 border border-slate-200 px-2 py-1">
                      <strong>N1:</strong> <span x-text="applied.sub1"></span>
                    </span>
                  </template>
                  <template x-if="applied.sub2">
                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 text-slate-700 border border-slate-200 px-2 py-1">
                      <strong>N2:</strong> <span x-text="applied.sub2"></span>
                    </span>
                  </template>
                  <template x-if="applied.sub3">
                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 text-slate-700 border border-slate-200 px-2 py-1">
                      <strong>N3:</strong> <span x-text="applied.sub3"></span>
                    </span>
                  </template>
                  <template x-if="applied.sub4">
                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 text-slate-700 border border-slate-200 px-2 py-1">
                      <strong>N4:</strong> <span x-text="applied.sub4"></span>
                    </span>
                  </template>
                </div>
              </div>
            </div>
          </template>
        </div>
      </section>
    </section>

    <!-- Columna derecha: N3 + N4 -->
    <section class="grid grid-rows-2 gap-8 relative z-10">
      <div>
        <div class="flex items-center justify-between mb-2">
          <h2 class="text-sm font-semibold text-slate-600">Nivel 3</h2>
          <span class="text-xs text-slate-500" x-text="sub[3].selectedTitle ? 'Sel.: '+ sub[3].selectedTitle : ''"></span>
        </div>
        <div class="grid gap-3 sm:grid-cols-2">
          <template x-for="opt in sub[3].options" :key="opt.id">
            <button type="button"
              @click="choose(3,opt)"
              class="rounded-lg border bg-white px-3 py-2 text-left text-sm hover:shadow focus:outline-none"
              :class="{'ring-2 ring-indigo-500': sub[3].selected === opt.id}">
              <span class="font-medium" x-text="opt.title"></span>
            </button>
          </template>
        </div>
      </div>

      <div x-show="sub[4].options.length > 0">
        <div class="flex items-center justify-between mb-2">
          <h2 class="text-sm font-semibold text-slate-600">Nivel 4</h2>
          <span class="text-xs text-slate-500" x-text="sub[4].selectedTitle ? 'Sel.: '+ sub[4].selectedTitle : ''"></span>
        </div>
        <div class="grid gap-3 sm:grid-cols-2">
          <template x-for="opt in sub[4].options" :key="opt.id">
            <button type="button"
              @click="choose(4,opt)"
              class="rounded-lg border bg-white px-3 py-2 text-left text-sm hover:shadow focus:outline-none"
              :class="{'ring-2 ring-indigo-500': sub[4].selected === opt.id}">
              <span class="font-medium" x-text="opt.title"></span>
            </button>
          </template>
        </div>
      </div>
    </section>
  </div>

  <template x-if="loading">
    <div class="mt-6 text-sm text-slate-500">Cargando…</div>
  </template>
</div>
@endsection
