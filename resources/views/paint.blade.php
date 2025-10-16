@extends('layouts.app')
@section('title', 'Dentro del Espejo')

@section('content')

<div x-data="paintBoard()" x-init="init()" class="min-h-screen bg-slate-50">
  {{-- Barra fija superior --}}
{{-- Barra fija superior (navegación principal) --}}
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
  <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-3">
    <a href="{{ url()->previous() }}" class="text-slate-600 hover:text-slate-900 text-sm">← Volver</a>
    <h1 class="font-semibold text-slate-800">Dibujar sobre imagen</h1>

    <div class="ml-auto flex items-center gap-2 text-sm">
      <!-- Cargar imagen -->
      <label class="inline-flex items-center px-3 py-1.5 rounded-xl border border-slate-300 hover:bg-slate-100 cursor-pointer">
        <input type="file" accept="image/*" class="hidden" @change="onLoadImage($event)">
        Cargar imagen
      </label>

      <!-- Descargar -->
      <button @click="downloadMerged()" class="px-3 py-1.5 rounded-xl border border-emerald-300 text-emerald-700 hover:bg-emerald-50">
        Descargar
      </button>
    </div>
  </div>

  {{-- Sub-barra de herramientas (opciones de dibujo) --}}
  <div class="border-t border-slate-200 bg-white/80">
    <div class="max-w-6xl mx-auto px-4 py-2 flex items-center gap-3 text-sm overflow-x-auto">
      <!-- Color -->
      <label class="flex items-center gap-2 px-2 py-1.5 rounded-xl border border-slate-300 whitespace-nowrap">
        <span class="text-slate-600">Color</span>
        <input type="color" x-model="brushColor" class="w-8 h-8 p-0 border-0 outline-none bg-transparent cursor-pointer">
      </label>

      <!-- Grosor -->
      <label class="flex items-center gap-2 px-2 py-1.5 rounded-xl border border-slate-300 whitespace-nowrap">
        <span class="text-slate-600">Grosor</span>
        <input type="range" min="1" max="60" step="1" x-model.number="brushSize" class="w-32">
        <span class="tabular-nums w-8 text-right" x-text="brushSize"></span>
      </label>

      <!-- Modo -->
      <div class="flex rounded-xl overflow-hidden border border-slate-300">
        <button @click="setMode('draw')" :class="mode==='draw' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                class="px-3 py-1.5">Dibujar</button>
        <button @click="setMode('erase')" :class="mode==='erase' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                class="px-3 py-1.5">Borrar</button>
      </div>
    <!-- Pinceles (cosméticos) -->
    <div class="flex items-center gap-2">
    <span class="text-slate-600 text-sm">Pincel</span>
    <div class="flex gap-1">
        <button @click="setBrush('lipstick')"
                :class="brush==='lipstick' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-300'"
                class="px-2.5 py-1.5 rounded-xl text-sm whitespace-nowrap">💄 Labial</button>

     <button @click="setBrush('remover')"
        :class="brush==='remover' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-300'"
        class="px-2.5 py-1.5 rounded-xl text-sm whitespace-nowrap">🧴 Desmaquillante</button>

        <button @click="setBrush('shadow')"
                :class="brush==='shadow' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-300'"
                class="px-2.5 py-1.5 rounded-xl text-sm whitespace-nowrap">🎨 Sombra</button>

        <button @click="setBrush('eyeliner')"
                :class="brush==='eyeliner' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-300'"
                class="px-2.5 py-1.5 rounded-xl text-sm whitespace-nowrap">✒️ Delineador</button>

        <button @click="setBrush('blush')"
                :class="brush==='blush' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-300'"
                class="px-2.5 py-1.5 rounded-xl text-sm whitespace-nowrap">🌸 Rubor</button>
    </div>
    </div>


      <!-- Deshacer / Rehacer -->
      <button @click="undo()" :disabled="!canUndo"
              class="px-3 py-1.5 rounded-xl border border-slate-300 disabled:opacity-40 whitespace-nowrap">↶ Deshacer</button>
      <button @click="redo()" :disabled="!canRedo"
              class="px-3 py-1.5 rounded-xl border border-slate-300 disabled:opacity-40 whitespace-nowrap">↷ Rehacer</button>

      <!-- Limpiar -->
      <button @click="clearCanvasConfirm()"
              class="px-3 py-1.5 rounded-xl border border-rose-300 text-rose-700 hover:bg-rose-50 whitespace-nowrap">Limpiar</button>
    </div>
  </div>
</header>


  {{-- Lienzo --}}
  <main class="max-w-6xl mx-auto px-4 py-6">
    <div class="relative w-full bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
      <!-- Contenedor que mantiene relación y se ajusta -->
      <div class="relative w-full" x-ref="stageWrap" @mousedown="pointerDown" @touchstart.passive="pointerDown"
           @mousemove="pointerMove" @touchmove.passive="pointerMove" @mouseleave="pointerUp" @mouseup="pointerUp" @touchend="pointerUp">

        <!-- Imagen de fondo -->
        <img x-ref="bg"
            :src="bgSrc"
            alt="Imagen de fondo"
            class="block select-none"
            @load="onBgLoaded">

        <!-- Canvas (mismo tamaño visual que la imagen)
        <canvas x-ref="canvas" class="absolute inset-0"></canvas>-->
        <canvas x-ref="canvas" class="absolute inset-0" style="background: transparent;"></canvas>

        <!-- Placeholders cuando no hay imagen -->
        <template x-if="!bgLoaded">
          <div class="absolute inset-0 grid place-items-center text-slate-400 text-sm pointer-events-none">
            <div class="text-center px-6 py-10">
              <div class="text-xl mb-2">Cargar una imagen para empezar</div>
              <div>o dibuja sobre un lienzo en blanco (Descargar combinará fondo y trazos)</div>
            </div>
          </div>
        </template>
      </div>
    </div>

    {{-- Ayudas / atajos --}}
    <div class="mt-4 text-xs text-slate-500 leading-relaxed">
      <p><span class="font-medium text-slate-700">Atajos:</span> Ctrl+Z (Deshacer), Ctrl+Y / Ctrl+Shift+Z (Rehacer), E (Borrar), D (Dibujar), Ctrl+S (Descargar).</p>
      <p>Compatibilidad touch: mantén el dedo o stylus para dibujar/borrar.</p>
    </div>
  </main>
</div>

{{-- Alpine.js (si tu layout ya lo incluye, omite esta línea) --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function withAlpha(hexOrRgb, a=1){
  if(hexOrRgb?.startsWith('#')){
    const c = hexOrRgb.length===4 ? hexOrRgb.replace('#','').split('').map(ch=>ch+ch).join('')
                                  : hexOrRgb.replace('#','');
    const r = parseInt(c.slice(0,2),16), g = parseInt(c.slice(2,4),16), b = parseInt(c.slice(4,6),16);
    return `rgba(${r},${g},${b},${a})`;
  }
  return hexOrRgb?.startsWith('rgb(') ? hexOrRgb.replace('rgb(','rgba(').replace(')',`,`+a+`)`) : hexOrRgb;
}

function paintBoard() {
  return {
    // --- Estado ---
    canvas:null, ctx:null, bgEl:null, stageWrap:null,
    bgSrc:'', bgLoaded:false,
    drawing:false, lastX:0, lastY:0,
    brushColor:'#111827', brushSize:8, mode:'draw',
    brush:'lipstick', lastStampX:null, lastStampY:null, stampSpacing:0.35,

    history:[], redoStack:[], historyLimit:50,

    get canUndo(){ return this.history.length>0; },
    get canRedo(){ return this.redoStack.length>0; },

    // --- Init ---
    init(){
      this.canvas = this.$refs.canvas;
      this.ctx = this.canvas.getContext('2d', { willReadFrequently:true });
      this.bgEl = this.$refs.bg;
      this.stageWrap = this.$refs.stageWrap;

      this.resizeToWrapper();
      this.pushHistory();

      // Atajos
      window.addEventListener('keydown',(e)=>{
        const k = e.key.toLowerCase();
        if((e.ctrlKey||e.metaKey) && k==='z'){ e.preventDefault(); return e.shiftKey ? this.redo() : this.undo(); }
        if((e.ctrlKey||e.metaKey) && k==='y'){ e.preventDefault(); return this.redo(); }
        if((e.ctrlKey||e.metaKey) && k==='s'){ e.preventDefault(); return this.downloadMerged(); }
        if(k==='e'){ this.setMode('erase'); }
        if(k==='d'){ this.setMode('draw'); }
      });

      window.addEventListener('resize', ()=>this.redrawPreserving(), {passive:true});
    },

    // --- UI helpers ---
    setMode(m){ this.mode=m; },
    setBrush(name){ this.brush=name; },

    // --- Cargar imagen ---
    onLoadImage(evt){
      const file = evt.target.files?.[0];
      if(!file) return;
      const reader = new FileReader();
      reader.onload = () => { this.bgSrc = reader.result; };
      reader.readAsDataURL(file);
      this.redoStack = [];
    },
    onBgLoaded(){ this.bgLoaded = true; this.redrawPreserving(); },

    // --- Dibujo ---
    pointerDown(e){
      const {x,y} = this.eventXY(e);
      this.drawing = true; this.lastX=x; this.lastY=y; this.lastStampX=x; this.lastStampY=y;
        this.ctx.shadowBlur = 0;
        this.ctx.shadowColor = 'transparent';
      if(this.mode==='erase'){
        this.ctx.globalCompositeOperation='destination-out';
        this.ctx.lineCap='round'; this.ctx.lineJoin='round';
        this.ctx.lineWidth=this.brushSize; this.ctx.strokeStyle='rgba(0,0,0,1)';
        this.ctx.beginPath(); this.ctx.moveTo(x,y); return;
      }

      this.ctx.globalCompositeOperation='source-over';

      if(this.brush==='eyeliner'){
        this.ctx.lineCap='butt'; this.ctx.lineJoin='round';
        this.ctx.lineWidth=Math.max(1, this.brushSize*0.55);
        this.ctx.strokeStyle=this.brushColor;
        this.ctx.beginPath(); this.ctx.moveTo(x,y);
      } else if(this.brush==='lipstick'){
        this.ctx.lineCap='round'; this.ctx.lineJoin='round';
        this.ctx.lineWidth=Math.max(2, this.brushSize*0.9);
        this.ctx.strokeStyle=withAlpha(this.brushColor,0.85);
        this.ctx.shadowColor=this.brushColor; this.ctx.shadowBlur=Math.floor(this.brushSize*0.15);
        this.ctx.beginPath(); this.ctx.moveTo(x,y);
      }
      // gloss/shadow/blush se hacen por “stamps” en pointerMove
    },

    pointerMove(e){
      if(!this.drawing) return;
      const {x,y} = this.eventXY(e);

      if(this.mode==='erase'){
        this.ctx.lineTo(x,y); this.ctx.stroke();
        this.lastX=x; this.lastY=y; return;
      }

      if(this.brush==='eyeliner' || this.brush==='lipstick'){
        this.ctx.lineTo(x,y); this.ctx.stroke();
        this.lastX=x; this.lastY=y; return;
      }

      // stamps
      const dist = Math.hypot(x-this.lastStampX, y-this.lastStampY);
      const step = this.brushSize * this.stampSpacing;
      if(dist >= step){
        const n = Math.floor(dist/step);
        for(let i=1;i<=n;i++){
          const t=i/n, sx=this.lastStampX+(x-this.lastStampX)*t, sy=this.lastStampY+(y-this.lastStampY)*t;
          this.stamp(sx,sy);
        }
        this.lastStampX=x; this.lastStampY=y;
      }
    },

    pointerUp(){
      if(!this.drawing) return;
      this.drawing=false;
      try{ this.ctx.closePath(); }catch(_){}
      this.ctx.shadowBlur=0;
      this.pushHistory();
      this.redoStack=[];
    },

    eventXY(e){
      const rect = this.canvas.getBoundingClientRect();
      const t = e.touches?.[0];
      const cx = t ? t.clientX : e.clientX;
      const cy = t ? t.clientY : e.clientY;
      const x = (cx - rect.left) * (this.canvas.width / rect.width);
      const y = (cy - rect.top) * (this.canvas.height / rect.height);
      return {x,y};
    },

    // --- Stamps (pinceles difusos) ---
// --- reemplazo total de la función ---
stamp(x,y){
  const ctx = this.ctx;

  // ===== SOMBRA (🎨) =====
  if (this.brush === 'shadow') {
    const r = this.brushSize * 0.6;
    const colIn  = withAlpha(this.brushColor, 0.18);
    const colOut = withAlpha(this.brushColor, 0.00); // <- mismo color, alfa 0 (no negro)

    const g = ctx.createRadialGradient(x, y, 0, x, y, r);
    g.addColorStop(0, colIn);
    g.addColorStop(1, colOut);

    const prevOp = ctx.globalCompositeOperation;
    ctx.globalCompositeOperation = 'lighter'; // suma, no oscurece
    ctx.fillStyle = g;
    ctx.beginPath(); ctx.arc(x, y, r, 0, Math.PI * 2); ctx.fill();
    ctx.globalCompositeOperation = prevOp;
    return;
  }

  // ===== DESMAQUILLANTE (🧴) =====
  if (this.brush === 'remover') {
    const r = this.brushSize * 0.7;
    const g = ctx.createRadialGradient(x, y, 0, x, y, r);
    g.addColorStop(0, 'rgba(255,255,255,0.25)');
    g.addColorStop(0.30, 'rgba(255,255,255,0.10)');
    g.addColorStop(1,  'rgba(255,255,255,0.00)');

    const prevOp = ctx.globalCompositeOperation;
    ctx.globalCompositeOperation = 'destination-out'; // borra suave
    ctx.fillStyle = g;
    ctx.beginPath(); ctx.arc(x, y, r, 0, Math.PI * 2); ctx.fill();
    ctx.globalCompositeOperation = prevOp;
    return;
  }

  // ===== (OPCIONAL) GLOSS heredado =====
  if (this.brush === 'gloss') {
    const r = this.brushSize * 0.6;
    const g = ctx.createRadialGradient(x, y, 0, x, y, r);
    g.addColorStop(0, withAlpha(this.brushColor, 0.28));
    g.addColorStop(0.60, withAlpha(this.brushColor, 0.15));
    g.addColorStop(1, withAlpha(this.brushColor, 0.00)); // <- no blanco/negro
    ctx.fillStyle = g;
    ctx.beginPath(); ctx.arc(x, y, r, 0, Math.PI * 2); ctx.fill();
    ctx.fillStyle = 'rgba(255,255,255,0.25)';
    ctx.beginPath(); ctx.ellipse(x - r*0.25, y - r*0.25, r*0.22, r*0.14, 0, 0, Math.PI * 2); ctx.fill();
    return;
  }

  // ===== RUBOR (🌸) =====
  if (this.brush === 'blush') {
    const R = this.brushSize * 0.96;
    const colIn  = withAlpha(this.brushColor, 0.12);
    const colOut = withAlpha(this.brushColor, 0.00); // <- mismo color, alfa 0

    const g = ctx.createRadialGradient(x, y, 0, x, y, R);
    g.addColorStop(0, colIn);
    g.addColorStop(1, colOut);

    const prevOp = ctx.globalCompositeOperation;
    ctx.globalCompositeOperation = 'lighter'; // suma luminosa
    ctx.fillStyle = g;
    ctx.beginPath(); ctx.arc(x, y, R, 0, Math.PI * 2); ctx.fill();
    ctx.globalCompositeOperation = prevOp;
    return;
  }
},

    // --- Historial ---
    pushHistory(){
      try{
        const snap = this.ctx.getImageData(0,0,this.canvas.width,this.canvas.height);
        this.history.push(snap); if(this.history.length>this.historyLimit) this.history.shift();
      }catch(e){ console.warn('Historial no disponible (CORS en imagen).'); }
    },
    undo(){
      if(!this.canUndo) return;
      const curr = this.ctx.getImageData(0,0,this.canvas.width,this.canvas.height);
      const prev = this.history.pop(); if(!prev) return;
      this.redoStack.push(curr); this.ctx.putImageData(prev,0,0);
    },
    redo(){
      if(!this.canRedo) return;
      const curr = this.ctx.getImageData(0,0,this.canvas.width,this.canvas.height);
      const next = this.redoStack.pop(); if(!next) return;
      this.history.push(curr); this.ctx.putImageData(next,0,0);
    },
    clearCanvasConfirm(){
      if(!confirm('¿Limpiar todos los trazos?')) return;
      this.clearCanvas(); this.pushHistory(); this.redoStack=[];
    },
    clearCanvas(){
      this.ctx.save(); this.ctx.setTransform(1,0,0,1,0,0);
      this.ctx.clearRect(0,0,this.canvas.width,this.canvas.height);
      this.ctx.restore();
    },

    // --- Resize / Redibujo ---
    redrawPreserving(){
      const current = this.ctx.getImageData(0,0,this.canvas.width,this.canvas.height);
      this.resizeToWrapper();
      const tmp = document.createElement('canvas'); tmp.width=current.width; tmp.height=current.height;
      tmp.getContext('2d').putImageData(current,0,0);
      this.ctx.clearRect(0,0,this.canvas.width,this.canvas.height);
      this.ctx.drawImage(tmp,0,0,this.canvas.width,this.canvas.height);
      this.pushHistory(); this.redoStack=[];
    },
 resizeToWrapper(){
  const dpr = window.devicePixelRatio || 1;

  // Tamaño natural (o fallback si no hay imagen aún)
  const natW = (this.bgEl?.naturalWidth)  || 1600;
  const natH = (this.bgEl?.naturalHeight) || 900;

  // LÍMITES DUROS relativos a la ventana (no se desborda)
  const headerH = (document.querySelector('header')?.getBoundingClientRect().height) || 0;
  const maxW_vp = Math.floor(window.innerWidth  * 0.90);             // 90% del viewport en ancho
  const maxH_vp = Math.floor((window.innerHeight - headerH) * 0.70);  // 70% del viewport útil en alto

  // LÍMITE del contenedor blanco (por si es más pequeño)
  const contRect = this.stageWrap.parentElement.getBoundingClientRect();
  const maxW_box = Math.floor(contRect.width);

  const maxW = Math.max(320, Math.min(maxW_vp, maxW_box));
  const maxH = Math.max(240, maxH_vp);

  // Escala tipo "contain"
  const scale = Math.min(maxW / natW, maxH / natH, 1);

  const dispW = Math.floor(natW * scale);
  const dispH = Math.floor(natH * scale);

  // Fijar marco exacto
  this.stageWrap.style.width  = dispW + 'px';
  this.stageWrap.style.height = dispH + 'px';

  // Imagen y canvas del mismo tamaño
  Object.assign(this.bgEl.style, { width: dispW+'px', height: dispH+'px', objectFit: 'contain', display: 'block' });
  this.canvas.style.width  = dispW + 'px';
  this.canvas.style.height = dispH + 'px';

  // Resolución real (retina) y sistema de coordenadas
  this.canvas.width  = Math.round(dpr * dispW);
  this.canvas.height = Math.round(dpr * dispH);
  this.ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
},

    // --- Descarga ---
    downloadMerged(){
      const dpr = window.devicePixelRatio || 1;
      const cssW = parseInt(this.canvas.style.width,10) || this.canvas.width/dpr;
      const cssH = parseInt(this.canvas.style.height,10) || this.canvas.height/dpr;

      const out = document.createElement('canvas'); out.width=cssW; out.height=cssH;
      const octx = out.getContext('2d');

      if(this.bgLoaded){ octx.drawImage(this.bgEl,0,0,cssW,cssH); }
      else { octx.fillStyle='#ffffff'; octx.fillRect(0,0,cssW,cssH); }

      octx.drawImage(this.canvas,0,0,cssW,cssH);
      const link = document.createElement('a'); link.download='dibujo.png'; link.href=out.toDataURL('image/png'); link.click();
    },
  }
}
</script>

@endsection
