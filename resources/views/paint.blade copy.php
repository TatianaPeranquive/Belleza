{{-- resources/views/paint.blade.php --}}
@extends('layouts.app')

@section('title', 'Dentro Del Espejo — Paint')

@section('content')
<nav class="fixed top-0 left-0 w-full h-16 flex items-center px-4 z-[1200] bg-black/80 text-white">
  <a href="{{ route('hitos.index', ['hito' => 1]) }}#hitos-top" class="font-semibold">&larr; Volver</a>
</nav>

<main class="max-w-6xl mx-auto px-4 pt-20 pb-12">
  {{-- Barra 1: Cámara --}}
  <div class="flex items-center gap-3 mb-3">
    <button id="openCam"  class="px-3 py-2 rounded-xl border border-slate-300 bg-white">📷 Abrir cámara</button>
    <button id="flipCam"  class="px-3 py-2 rounded-xl border border-slate-300 bg-white" disabled>🔁 Cambiar cámara</button>
    <button id="shot"     class="px-3 py-2 rounded-xl border border-emerald-300 bg-emerald-50" disabled>📸 Tomar selfie</button>
    <button id="closeCam" class="px-3 py-2 rounded-xl border border-slate-300 bg-white" hidden>✖️ Cerrar</button>
    <button id="download" class="ml-auto px-3 py-2 rounded-xl border border-slate-300 bg-white">⬇️ Descargar</button>
  </div>

  {{-- Barra 2: Herramientas --}}
  <div class="flex flex-wrap items-center gap-3 mb-4">
    <button id="back" class="px-3 py-2 rounded-xl border border-slate-300 bg-white">&larr; Volver</button>

    <h2 class="mx-auto font-semibold">Dentro Del Espejo</h2>

    <div class="flex items-center gap-2">
      <label class="text-sm">Color</label>
      <input id="color" type="color" value="#1f2937" class="h-8 w-10 rounded">
    </div>

    <div class="flex items-center gap-2">
      <label class="text-sm">Grosor</label>
      <input id="size" type="range" min="2" max="60" value="8">
      <span id="sizeVal" class="text-sm">8</span>
    </div>

    <div class="flex items-center gap-1">
      <span class="text-sm">Pincel</span>
      <button class="tool" data-brush="lipstick">💄 Labial</button>
      <button class="tool" data-brush="shadow">🌸 Sombra</button>
      <button class="tool" data-brush="blush">🌺 Rubor</button>
      <span class="mx-1 text-slate-400">/</span>
      <button class="tool" data-brush="eraser">🧽 Borrar</button>
      <span class="mx-1 text-slate-400">/</span>
      <button id="modeDraw"  class="tool tool--active" data-mode="draw">Dibujar</button>
      <button id="modeErase" class="tool" data-mode="erase">Borrar</button>
    </div>
  </div>

  {{-- Escenario --}}
  <div id="stage"
     class="relative w-full h-[70vh] min-h-[420px] bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden select-none">

  <!-- Imagen de fondo (se ajusta) -->
  <img id="bg" alt="Imagen de fondo"
       class="absolute inset-0 w-full h-full object-contain" src="">

  <!-- Lienzo -->
  <canvas id="cv" class="absolute inset-0 w-full h-full"></canvas>

  <!-- Cámara -->
  <video id="cam"
         class="absolute inset-0 hidden w-full h-full object-contain mirror z-[5]"
         autoplay playsinline muted></video>

  <!-- Auxiliar captura -->
  <canvas id="shotCanvas" class="hidden"></canvas>

  <div id="placeholder"
       class="absolute inset-0 grid place-items-center text-slate-400 text-sm pointer-events-none">
    <div class="px-6 py-10 text-center">
      <div class="text-lg mb-2">Tómate una selfie para empezar</div>
      <div>o dibuja sobre un lienzo en blanco y descarga</div>
    </div>
  </div>
</div>
<!-- Modal de previsualización -->
<div id="selfieModal"
     class="fixed inset-0 z-[1300] hidden bg-black/70 backdrop-blur-sm">
  <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2
              bg-white rounded-2xl shadow-xl p-4 w-[min(92vw,720px)]">
    <h3 class="text-lg font-semibold mb-3">Previsualización</h3>
    <img id="selfiePreview" class="w-full h-[50vh] object-contain rounded-xl bg-slate-50" alt="Selfie">
    <div class="mt-4 flex justify-end gap-2">
      <button id="retryShot" class="px-3 py-2 rounded-xl border border-slate-300 bg-white">Repetir</button>
      <button id="useShot" class="px-3 py-2 rounded-xl border border-emerald-300 bg-emerald-50">Usar foto</button>
    </div>
  </div>
</div>

<section id="qaZone" class="relative max-w-6xl mx-auto mt-6">
  <!-- Tarjeta animada (oculta hasta pasar sobre el lienzo) -->
  <div id="qaCard"
       class="pointer-events-auto hidden absolute -left-2 top-0 w-[min(420px,42vw)]
              bg-white/95 rounded-2xl shadow-xl border border-slate-200 p-4">
    <h4 id="qaTitle" class="font-semibold mb-2">Pregunta</h4>
    <p id="qaText" class="text-sm text-slate-700 mb-3"></p>
    <textarea id="qaAnswer"
              class="w-full h-28 border rounded-lg p-2 text-sm"
              placeholder="Escribe tu respuesta..."></textarea>
    <div class="mt-3 flex justify-between items-center">
      <button id="qaPrev" class="px-3 py-1.5 rounded-lg border">Anterior</button>
      <div class="flex gap-2">
        <button id="qaDownload" class="px-3 py-1.5 rounded-lg border">Descargar</button>
        <button id="qaNext" class="px-3 py-1.5 rounded-lg border bg-slate-50">Siguiente</button>
      </div>
    </div>
  </div>
</section>

</main>

<style>
  .tool { padding:.4rem .7rem; border-radius: .75rem; border:1px solid #e2e8f0; background:#fff; font-size:.875rem;}
  .tool--active { background:#0f172a; color:#fff; border-color:#0f172a; }
  .mirror{ transform: scaleX(-1); }
  canvas { touch-action: none; }
</style>

<script>
// ---------- Bloque de preguntas con “spring” + descarga de respuesta ---------------
document.addEventListener('DOMContentLoaded', () => {
  const stage = document.getElementById('stage');
  const qaCard = document.getElementById('qaCard');
  const qaTitle = document.getElementById('qaTitle');
  const qaText  = document.getElementById('qaText');
  const qaAns   = document.getElementById('qaAnswer');
  const qaPrev  = document.getElementById('qaPrev');
  const qaNext  = document.getElementById('qaNext');
  const qaDl    = document.getElementById('qaDownload');

  if(!(stage && qaCard)) return;

  // Preguntas “quemadas”
  const Q = [
    {t:'¿Qué es la belleza?', d:'Para mí, la belleza es…'},
    {t:'¿Qué ves cuando te miras al espejo?', d:'Hoy me veo…'},
    {t:'¿Qué te gustaría decirte?', d:'Me diría…'}
  ];
  let i = 0;

  function renderQ(){
    qaTitle.textContent = Q[i].t;
    qaText.textContent  = Q[i].d;
    qaAns.value = (qaAns.value && qaAns.dataset.idx==i) ? qaAns.value : '';
    qaAns.dataset.idx = i;
  }
  renderQ();

  // Mostrar al entrar al lienzo, ocultar al salir
  stage.addEventListener('mouseenter', () => {
    qaCard.classList.remove('hidden');
    qaCard.animate(
      [{transform:'translateX(-24px) scale(.96)', opacity:.0, filter:'blur(4px)'},
       {transform:'translateX(0) scale(1)',      opacity:1,  filter:'blur(0)'}],
      {duration:420, easing:'cubic-bezier(.17,.89,.32,1.27)'}
    );
  });
  stage.addEventListener('mouseleave', () => {
    qaCard.animate(
      [{transform:'translateX(0) scale(1)',      opacity:1,  filter:'blur(0)'},
       {transform:'translateX(-24px) scale(.96)', opacity:.0, filter:'blur(4px)'}],
      {duration:280, easing:'ease-out'}
    ).onfinish = ()=> qaCard.classList.add('hidden');
  });

  // Navegación
  qaNext.addEventListener('click', ()=>{ i = (i+1)%Q.length; renderQ(); });
  qaPrev.addEventListener('click', ()=>{ i = (i-1+Q.length)%Q.length; renderQ(); });

  // Descarga tarjeta (png con pregunta + respuesta)
  qaDl.addEventListener('click', ()=>{
    const W = 700, H = 420;
    const c = document.createElement('canvas');
    c.width=W; c.height=H;
    const x = c.getContext('2d');
    // fondo
    x.fillStyle = '#ffffff'; x.fillRect(0,0,W,H);
    x.fillStyle = '#0f172a'; x.font = 'bold 22px system-ui, Segoe UI, Arial';
    x.fillText(Q[i].t, 24, 40);
    x.fillStyle = '#334155'; x.font='16px system-ui, Segoe UI, Arial';
    wrapText(x, Q[i].d, 24, 72, W-48, 22);
    x.fillStyle = '#111827'; x.font='17px system-ui, Segoe UI, Arial';
    wrapText(x, qaAns.value || '(sin respuesta)', 24, 130, W-48, 24);
    const a = document.createElement('a');
    a.download = `Pregunta-${i+1}.png`;
    a.href = c.toDataURL('image/png');
    a.click();
  });

  function wrapText(ctx, text, x, y, maxWidth, lineHeight){
    const words = (text||'').split(/\s+/); let line='', yy=y;
    words.forEach((w,idx)=>{
      const test = line? line+' '+w : w;
      if (ctx.measureText(test).width > maxWidth && line){
        ctx.fillText(line, x, yy); yy += lineHeight; line = w;
      } else { line = test; }
      if(idx===words.length-1){ ctx.fillText(line, x, yy); }
    });
  }
});
// ---------- Fin preguntas -------------------
document.addEventListener('DOMContentLoaded', () => {
  // ---------- helpers ----------
  const $ = id => document.getElementById(id);
  const on = (el,ev,fn,opt)=> el && el.addEventListener(ev,fn,opt);

  // ---------- nodos ----------
  const stage = $('stage');
  const bg    = $('bg');
  const cv    = $('cv');
  const ctx   = cv.getContext('2d');
  const cam   = $('cam');
  const shotC = $('shotCanvas');
  const ph    = $('placeholder');

  const btnOpen  = $('openCam');
  const btnFlip  = $('flipCam');
  const btnShot  = $('shot');
  const btnClose = $('closeCam');
  const btnDown  = $('download');
  const btnBack  = $('back');

  const color = $('color');
  const size  = $('size');
  const sizeVal = $('sizeVal');

  const tools = document.querySelectorAll('.tool');
  const modeDraw = $('modeDraw');
  const modeErase = $('modeErase');

  // ---------- estado dibujo ----------
  let drawing = false;
  let lastX = 0, lastY = 0;
  let brush = 'lipstick';
  let mode  = 'draw'; // 'draw' | 'erase'
  let brushColor = color.value;
  let brushSize  = +size.value;

  sizeVal.textContent = brushSize;

  function setActiveTool(btn){
    tools.forEach(b=>b.classList.remove('tool--active'));
    if (btn) btn.classList.add('tool--active');
  }

  tools.forEach(b=>{
    on(b,'click', ()=>{
      if (b.dataset.mode){
        mode = b.dataset.mode;
        setActiveTool(b);
      } else if (b.dataset.brush){
        brush = b.dataset.brush;
        setActiveTool(b);
      }
    })
  });

  on(color,'input', e => brushColor = e.target.value);
  on(size,'input',  e => { brushSize = +e.target.value; sizeVal.textContent = brushSize; });

  // ---------- resize ----------
 function resize(){
  const stage = document.getElementById('stage');
  const cv    = document.getElementById('cv');
  if(!stage || !cv) return;

  const r   = stage.getBoundingClientRect();
  const dpr = Math.max(1, Math.round(window.devicePixelRatio || 1));

  cv.width  = Math.round(r.width  * dpr);
  cv.height = Math.round(r.height * dpr);
  cv.style.width  = r.width  + 'px';
  cv.style.height = r.height + 'px';

  const ctx = cv.getContext('2d');
  ctx.setTransform(dpr,0,0,dpr,0,0);
}
window.resize = resize;
window.addEventListener('resize', resize, {passive:true});
resize();


  // ---------- pintar ----------
  function stamp(x,y){
    if (mode === 'erase' || brush==='eraser'){
      // goma dura
      ctx.save();
      ctx.globalCompositeOperation = 'destination-out';
      ctx.beginPath();
      ctx.arc(x,y,brushSize/2,0,Math.PI*2);
      ctx.fill();
      ctx.restore();
      return;
    }

    if (brush === 'lipstick'){ // trazo sólido
      ctx.lineCap='round'; ctx.lineJoin='round';
      ctx.strokeStyle = brushColor;
      ctx.lineWidth = brushSize;
      ctx.beginPath();
      ctx.moveTo(lastX,lastY);
      ctx.lineTo(x,y);
      ctx.stroke();
    } else if (brush === 'shadow'){ // difuso
      const r = brushSize*0.6;
      const g = ctx.createRadialGradient(x,y,0,x,y,r);
      g.addColorStop(0, withAlpha(brushColor,0.20));
      g.addColorStop(1, 'rgba(0,0,0,0)');
      ctx.fillStyle = g;
      ctx.beginPath();
      ctx.arc(x,y,r,0,Math.PI*2);
      ctx.fill();
    } else if (brush === 'blush'){ // rubor suave
      const R = brushSize*0.95;
      const g = ctx.createRadialGradient(x,y,0,x,y,R);
      g.addColorStop(0, withAlpha(brushColor,0.12));
      g.addColorStop(1, 'rgba(0,0,0,0)');
      ctx.fillStyle = g;
      ctx.beginPath();
      ctx.arc(x,y,R,0,Math.PI*2);
      ctx.fill();
    }
  }
  function withAlpha(hex, a){
    const c = hex.replace('#','');
    const r = parseInt(c.substring(0,2),16);
    const g = parseInt(c.substring(2,4),16);
    const b = parseInt(c.substring(4,6),16);
    return `rgba(${r},${g},${b},${a})`;
  }

  function posFromEvent(e){
    const rect = cv.getBoundingClientRect();
    const t = e.touches ? e.touches[0] : e;
    return { x: t.clientX - rect.left, y: t.clientY - rect.top };
  }

  function pointerDown(e){
    e.preventDefault();
    const {x,y} = posFromEvent(e);
    drawing = true;
    lastX = x; lastY = y;
    stamp(x,y);
  }
  function pointerMove(e){
    if (!drawing) return;
    const {x,y} = posFromEvent(e);
    stamp(x,y);
    lastX = x; lastY = y;
  }
  function pointerUp(){ drawing = false; }

  on(cv,'mousedown',pointerDown);
  on(cv,'mousemove',pointerMove);
  on(cv,'mouseup',pointerUp);
  on(cv,'mouseleave',pointerUp);
  on(cv,'touchstart',pointerDown,{passive:false});
  on(cv,'touchmove',pointerMove,{passive:false});
  on(cv,'touchend',pointerUp);

  // ---------- descargar (fondo + trazos) ----------
  on(btnDown,'click', ()=>{
    // Componer: dibujamos img + trazos en un canvas temporal
    const rect = stage.getBoundingClientRect();
    const DPR = Math.max(1, Math.round(window.devicePixelRatio || 1));
    const w = Math.round(rect.width * DPR);
    const h = Math.round(rect.height * DPR);
    const c = document.createElement('canvas');
    c.width=w; c.height=h;
    const x = c.getContext('2d');
    x.scale(DPR,DPR);
    // fondo
    if (bg && bg.src) {
      x.drawImage(bg, 0, 0, rect.width, rect.height);
    } else {
      x.fillStyle = '#fff'; x.fillRect(0,0,rect.width,rect.height);
    }
    // trazos (copiamos bitmap del canvas visible)
    x.drawImage(cv, 0, 0, rect.width, rect.height);

    const a = document.createElement('a');
    a.download = 'selfie-paint.png';
    a.href = c.toDataURL('image/png');
    a.click();
  });

  // ---------- back ----------
  on(btnBack,'click', ()=> history.back());

  // ======================================================
  //                    CÁMARA / SELFIE
  // ======================================================
  let camStream = null;
  let usingUserFacing = true;
  let hasMultipleCameras = false;

  // detectar múltiples cámaras
  if (navigator.mediaDevices?.enumerateDevices){
    navigator.mediaDevices.enumerateDevices().then(ds=>{
      hasMultipleCameras = ds.filter(d=>d.kind==='videoinput').length>1;
      if (btnFlip) btnFlip.disabled = !hasMultipleCameras;
    }).catch(()=>{ /* ignore */ });
  }

  function setUI({open=true, flip=false, shot=false, close=false}){
    if (btnOpen)  btnOpen.disabled = !open;
    if (btnFlip)  btnFlip.disabled = !flip;
    if (btnShot)  btnShot.disabled = !shot;
    if (btnClose) btnClose.hidden  = !close;
  }
  function setDrawingEnabled(v){ cv.style.pointerEvents = v ? 'auto' : 'none'; }

  async function startCamera(){
    try{
      setDrawingEnabled(false);
      setUI({open:false, flip:false, shot:false, close:true});

      const constraints = {
        video: {
          facingMode: usingUserFacing ? { ideal:'user' } : { ideal:'environment' },
          width: { ideal:1920 }, height:{ ideal:1080 }
        }, audio:false
      };

      camStream = await navigator.mediaDevices.getUserMedia(constraints);
      cam.srcObject = camStream;
      cam.hidden = false;
      await cam.play();
      ph && (ph.style.display='none');

      setUI({open:false, flip:hasMultipleCameras, shot:true, close:true});
      resize();
    }catch(err){
      console.error('No se pudo abrir la cámara:', err);
      alert('No se pudo abrir la cámara. Verifica permisos (https/localhost).');
      stopCamera();
    }
  }
  function stopCamera(){
    if (camStream){ camStream.getTracks().forEach(t=>t.stop()); camStream=null; }
    cam.srcObject = null;
    cam.hidden = true;
    setUI({open:true, flip:false, shot:false, close:false});
    setDrawingEnabled(true);
  }
document.addEventListener('DOMContentLoaded', () => {
  const $ = id => document.getElementById(id);
  const on = (el,ev,fn,opt)=> el && el.addEventListener(ev,fn,opt);

  const stage = $('stage'), bg = $('bg'), cv=$('cv'), ctx=cv.getContext('2d');
  const cam   = $('cam'), shotC=$('shotCanvas'), ph=$('placeholder');

  const btnOpen=$('openCam'), btnFlip=$('flipCam'), btnShot=$('shot'), btnClose=$('closeCam');

  // ---- Modal ----
  const modal   = $('selfieModal');
  const prevImg = $('selfiePreview');
  const useBtn  = $('useShot');
  const retryBtn= $('retryShot');

  let camStream=null, usingUserFacing=true, hasMultiple=false, pendingDataURL=null;

  // cámaras disponibles
  navigator.mediaDevices?.enumerateDevices?.().then(ds=>{
    hasMultiple = ds.filter(d=>d.kind==='videoinput').length>1;
    if(btnFlip) btnFlip.disabled = !hasMultiple;
  });

  function uiCamera({open=true, flip=false, shot=false, close=false}){
    if(btnOpen)  btnOpen.disabled = !open;
    if(btnFlip)  btnFlip.disabled = !flip;
    if(btnShot)  btnShot.disabled = !shot;
    if(btnClose) btnClose.hidden  = !close;
  }
  function setDrawing(v){ if(cv) cv.style.pointerEvents = v ? 'auto' : 'none'; }

  async function startCamera(){
    try{
      setDrawing(false);
      uiCamera({open:false, flip:false, shot:false, close:true});
      const constraints = {
        video: { facingMode: usingUserFacing?{ideal:'user'}:{ideal:'environment'},
                 width:{ideal:1920}, height:{ideal:1080} }, audio:false
      };
      camStream = await navigator.mediaDevices.getUserMedia(constraints);
      cam.srcObject = camStream; cam.hidden = false; await cam.play();
      ph && (ph.style.display='none');
      uiCamera({open:false, flip:hasMultiple, shot:true, close:true});
      resize();
    }catch(e){
      console.error(e); alert('No se pudo abrir la cámara. Revisa permisos / https.');
      stopCamera();
    }
  }
  function stopCamera(){
    camStream?.getTracks().forEach(t=>t.stop());
    camStream=null; cam.srcObject=null; cam.hidden=true;
    uiCamera({open:true, flip:false, shot:false, close:false});
    setDrawing(true);
  }

  // Tomar selfie → previsualizar (NO aplica aún)
  function takeShot(){
    if(!camStream || cam.readyState<2) return;
    const r = stage.getBoundingClientRect();
    shotC.width = r.width; shotC.height = r.height;
    const s = shotC.getContext('2d');

    // des-espejar
    s.save(); s.translate(r.width,0); s.scale(-1,1);
    const vw=cam.videoWidth||1280, vh=cam.videoHeight||720;
    const sc = Math.min(r.width/vw, r.height/vh);
    const dw=Math.round(vw*sc), dh=Math.round(vh*sc);
    const dx=Math.round((r.width-dw)/2), dy=Math.round((r.height-dh)/2);
    s.drawImage(cam, dx, dy, dw, dh);
    s.restore();

    pendingDataURL = shotC.toDataURL('image/jpeg', 0.92);
    prevImg.src = pendingDataURL;
    modal.classList.remove('hidden');
  }

  // Usar selfie (ahora sí aplicamos al fondo)
  function applyShot(){
    if(!pendingDataURL) return;
    bg.onload = ()=> resize();
    bg.src = pendingDataURL;
    pendingDataURL = null;
    modal.classList.add('hidden');
    stopCamera();
  }

  // Repetir (cerrar modal y seguir con cámara)
  function retryShot(){
    pendingDataURL = null;
    modal.classList.add('hidden');
  }

  // Eventos cámara
  on(btnOpen,'click', startCamera);
  on(btnClose,'click', stopCamera);
  on(btnFlip,'click', async ()=>{
    if(!hasMultiple) return; usingUserFacing=!usingUserFacing;
    stopCamera(); await startCamera();
  });
  on(btnShot,'click', takeShot);

  // Eventos modal
  on(useBtn,'click', applyShot);
  on(retryBtn,'click', retryShot);

  // ====== DIBUJO (si ya lo tienes, deja el tuyo; si no, este es mínimo) ======
  let drawing=false, lastX=0,lastY=0, brush='lipstick', mode='draw';
  let brushColor = (document.getElementById('color')?.value || '#1f2937');
  let brushSize  = +(document.getElementById('size')?.value || 8);

  const withAlpha=(hex,a)=>{const c=hex.replace('#','');const r=parseInt(c.slice(0,2),16),g=parseInt(c.slice(2,4),16),b=parseInt(c.slice(4,6),16);return `rgba(${r},${g},${b},${a})`;};
  function pos(e){ const r=cv.getBoundingClientRect(); const t=e.touches?e.touches[0]:e; return {x:t.clientX-r.left,y:t.clientY-r.top}; }
  function stamp(x,y){
    if(mode==='erase'){ ctx.save(); ctx.globalCompositeOperation='destination-out'; ctx.beginPath(); ctx.arc(x,y,brushSize/2,0,Math.PI*2); ctx.fill(); ctx.restore(); return; }
    if(brush==='lipstick'){ ctx.lineCap='round';ctx.lineJoin='round';ctx.strokeStyle=brushColor;ctx.lineWidth=brushSize;ctx.beginPath();ctx.moveTo(lastX,lastY);ctx.lineTo(x,y);ctx.stroke(); }
    else if(brush==='shadow'){ const r=brushSize*0.6,g=ctx.createRadialGradient(x,y,0,x,y,r); g.addColorStop(0,withAlpha(brushColor,0.2)); g.addColorStop(1,'rgba(0,0,0,0)'); ctx.fillStyle=g; ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fill();}
    else if(brush==='blush'){ const R=brushSize*0.95,g=ctx.createRadialGradient(x,y,0,x,y,R); g.addColorStop(0,withAlpha(brushColor,0.12)); g.addColorStop(1,'rgba(0,0,0,0)'); ctx.fillStyle=g; ctx.beginPath(); ctx.arc(x,y,R,0,Math.PI*2); ctx.fill();}
  }
  function down(e){ e.preventDefault(); drawing=true; const p=pos(e); lastX=p.x; lastY=p.y; stamp(p.x,p.y); }
  function move(e){ if(!drawing) return; const p=pos(e); stamp(p.x,p.y); lastX=p.x; lastY=p.y; }
  function up(){ drawing=false; }

  ['mousedown','touchstart'].forEach(ev=>cv.addEventListener(ev,down,{passive:false}));
  ['mousemove','touchmove'].forEach(ev=>cv.addEventListener(ev,move,{passive:false}));
  ['mouseup','mouseleave','touchend'].forEach(ev=>cv.addEventListener(ev,up));
});

 on(btnShot, 'click', takeShot);

//=======================================================================
//
//=======================================================================


});
</script>
@endsection
