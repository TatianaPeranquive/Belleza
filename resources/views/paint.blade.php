{{-- Vista mínima: sin Alpine, sin Tailwind build, sin dependencias raras --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dibujar sobre imagen</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root { --bar-h: 48px; --subbar-h: 44px; }
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial,sans-serif;background:#f8fafc;color:#0f172a}
    .bar{position:sticky;top:0;display:flex;align-items:center;gap:.5rem;height:var(--bar-h);padding:0 .75rem;background:#fff;backdrop-filter:saturate(180%) blur(8px);border-bottom:1px solid #e2e8f0;z-index:50}
    .subbar{position:sticky;top:var(--bar-h);display:flex;align-items:center;gap:.5rem;height:var(--subbar-h);padding:0 .75rem;background:#ffffffcc;border-bottom:1px solid #e2e8f0;z-index:49;overflow-x:auto}
    .btn{padding:.4rem .7rem;border:1px solid #cbd5e1;border-radius:.6rem;background:#fff;color:#334155;font-size:.9rem;cursor:pointer}
    .btn[disabled]{opacity:.5;cursor:not-allowed}
    .btn-primary{border-color:#34d399;color:#065f46;background:#ecfdf5}
    .chip{padding:.4rem .7rem;border:1px solid #cbd5e1;border-radius:6rem;background:#fff;color:#334155;font-size:.85rem;cursor:pointer;white-space:nowrap}
    .chip.active{background:#0f172a;color:#fff;border-color:#0f172a}
    .wrap{max-width:1200px;margin:0 auto;padding:12px}
    .stage-box{position:relative;background:#fff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.04);overflow:hidden}
    .stage{position:relative;touch-action:none}
    .bg{display:block;user-select:none;-webkit-user-drag:none}
    canvas{position:absolute;inset:0;background:transparent;z-index:10}
    .help{color:#64748b;font-size:.8rem;margin-top:.5rem}
    .spacer{height:.5rem}
    .field{display:flex;align-items:center;gap:.4rem}
    .field input[type="range"]{width:160px}
  </style>
</head>
<body>

<!-- Barra superior -->
<div class="bar">
  <!-- Bloque izquierdo -->
  <div style="display:flex;align-items:center;gap:.5rem;">
    <a class="btn" href="javascript:history.back()">← Volver</a>

    <label class="btn" style="cursor:pointer">
      <input id="file" type="file" accept="image/*" style="display:none">
      Cargar imagen
    </label>

    <button id="download" class="btn btn-primary">Descargar</button>
  </div>

  <!-- Título centrado -->
  <strong style="margin:0 auto;">Dentro Del Espejo</strong>
</div>


  <!-- Sub-barra de herramientas -->
  <div class="subbar">
    <div class="field">
      <span>Color</span>
      <input id="color" type="color" value="#111827">
    </div>
    <div class="field">
      <span>Grosor</span>
      <input id="size" type="range" min="1" max="60" step="1" value="8"><span id="sizev">8</span>
    </div>



    <div class="field">
      <span>Pincel</span>
      <button class="chip active" data-brush="lipstick">💄 Labial</button>
      <button class="chip" data-brush="shadow">🎨 Sombra</button>
      <button class="chip" data-brush="blush">🌸 Rubor</button>
      <button class="chip" data-brush="eyeliner">✒️ Delineador</button>
      <button class="chip" data-brush="remover">🧴 Desmaquillante</button>
    </div>

    <button id="undo" class="btn">↶ Deshacer</button>
    <button id="redo" class="btn">↷ Rehacer</button>
    <button id="clear" class="btn">Limpiar Todo</button>


      <button id="modeDraw" style="
              position:absolute;
              right:0.75rem;
              top:50%;
              transform:translateY(-50%);
              white-space:nowrap;" class="chip active">Dibujar</button>
      <button id="modeErase" style="
              position:absolute;
              right:5rem;
              top:50%;
              transform:translateY(-50%);
              white-space:nowrap;" class="chip">Borrar</button>
  </div>

<!-- Tercera sub-barra de preguntas -->
<div id="quizbar" class="subbar" style="top:calc(var(--bar-h) + var(--subbar-h)); z-index:48;">

  <div style="
      display:flex;
      align-items:center;
      justify-content:center;
      width:100%;
      position:relative;
      text-align:center;
    ">
    <!-- Pregunta centrada -->
    <div id="question"
         style="font-weight:500;
                color:#0f172a;
                font-size:1rem;
                text-align:center;">
      ¿Qué no estoy mirando?
    </div>

    <!-- Botón Siguiente al lado derecho -->
    <button id="nextQ"
            class="btn btn-primary"
            style="
              position:absolute;
              right:0.75rem;
              top:50%;
              transform:translateY(-50%);
              white-space:nowrap;">
      Siguiente →
    </button>
  </div>
</div>


  <!-- Lienzo -->
  <div class="wrap">
    <div class="stage-box">
      <div id="stage" class="stage">
        <img id="bg" class="bg" alt="Imagen de fondo">
        <canvas id="cv"></canvas>
        <div id="placeholder" style="position:absolute;inset:0;display:grid;place-items:center;color:#94a3b8;text-align:center;pointer-events:none">
          <div>
            <div style="font-size:1.1rem;margin-bottom:.25rem">Cargar una imagen para empezar</div>
            <div>o dibuja sobre un lienzo en blanco</div>
          </div>
        </div>
      </div>
    </div>
    <div class="help">
      Atajos: Ctrl+Z / Ctrl+Y, E (Borrar), D (Dibujar), Ctrl+S (Descargar).
    </div>
    <div class="spacer"></div>
  </div>

<script>
(function(){
  // —— Refs
  const file = document.getElementById('file');
  const downloadBtn = document.getElementById('download');
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

  const ctx = cv.getContext('2d', { willReadFrequently:true });

  // —— Estado
  let brushColor = color.value;
  let brushSize = parseInt(size.value,10);
  let mode = 'draw';                // 'draw' | 'erase'
  let brush = 'lipstick';           // 'lipstick' | 'shadow' | 'blush' | 'eyeliner' | 'remover'
  let bgLoaded = false;

  let drawing = false, lastX=0, lastY=0, lastStampX=0, lastStampY=0, stampSpacing = 0.35;
  let history=[], redoStack=[], historyLimit=50;

  // —— Cursores personalizados (pon tus PNGs en /public/img/cursors/)
  const cursorBase = '/PROYECTOS/Belleza/public/img/cursors/';
  function updateCursor(){
    let path = '';
    if (mode==='erase') path = cursorBase + 'borrar.png';
    else {
      switch (brush){
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
  function withAlpha(hex, a=1){
    if(!hex) return `rgba(0,0,0,${a})`;
    if(hex.startsWith('#')){
      const c = hex.length===4 ? hex.replace('#','').split('').map(ch=>ch+ch).join('') : hex.replace('#','');
      const r = parseInt(c.slice(0,2),16), g = parseInt(c.slice(2,4),16), b = parseInt(c.slice(4,6),16);
      return `rgba(${r},${g},${b},${a})`;
    }
    return hex;
  }
  function clamp(v,min,max){return Math.max(min,Math.min(max,v));}

  // —— Tamaño que no se desborda (85vw x 75% del alto útil)
  function resize(){
    const dpr = window.devicePixelRatio || 1;
    const natW = bg.naturalWidth || 1600;
    const natH = bg.naturalHeight || 900;

    const headerH = (document.querySelector('.bar')?.getBoundingClientRect().height || 0) +
                    (document.querySelector('.subbar')?.getBoundingClientRect().height || 0);
    const maxW_vp = Math.floor(window.innerWidth * 0.85);
    const maxH_vp = Math.floor((window.innerHeight - headerH) * 0.75);

    const boxRect = stage.parentElement.getBoundingClientRect();
    const maxW = clamp(Math.min(maxW_vp, boxRect.width), 320, 2000);
    const maxH = clamp(maxH_vp, 240, 2000);

    const scale = Math.min(maxW / natW, maxH / natH, 1);
    const dispW = Math.max(1, Math.floor(natW * scale));
    const dispH = Math.max(1, Math.floor(natH * scale));

    stage.style.width = dispW+'px';
    stage.style.height = dispH+'px';
    Object.assign(bg.style, { width:dispW+'px', height:dispH+'px', objectFit:'contain', display:'block' });

    cv.style.width = dispW+'px';
    cv.style.height = dispH+'px';
    cv.width = Math.round(dpr * dispW);
    cv.height = Math.round(dpr * dispH);
    ctx.setTransform(dpr,0,0,dpr,0,0);
  }

  // —— Historial
  function pushHistory(){
    try{
      const snap = ctx.getImageData(0,0,cv.width,cv.height);
      history.push(snap); if(history.length>historyLimit) history.shift();
      undoBtn.disabled = history.length===0;
      redoBtn.disabled = redoStack.length===0;
    }catch(e){
      console.warn('Historial deshabilitado (posible CORS).', e);
    }
  }
  function undo(){
    if(!history.length) return;
    const curr = ctx.getImageData(0,0,cv.width,cv.height);
    const prev = history.pop(); if(!prev) return;
    redoStack.push(curr); ctx.putImageData(prev,0,0);
    undoBtn.disabled = history.length===0;
    redoBtn.disabled = redoStack.length===0;
  }
  function redo(){
    if(!redoStack.length) return;
    const curr = ctx.getImageData(0,0,cv.width,cv.height);
    const next = redoStack.pop(); if(!next) return;
    history.push(curr); ctx.putImageData(next,0,0);
    undoBtn.disabled = history.length===0;
    redoBtn.disabled = redoStack.length===0;
  }

  // —— Dibujo
  function eventXY(e){
    const rect = cv.getBoundingClientRect();
    const t = e.touches?.[0];
    const cx = t ? t.clientX : e.clientX;
    const cy = t ? t.clientY : e.clientY;
    const x = (cx - rect.left) * (cv.width / rect.width);
    const y = (cy - rect.top) * (cv.height / rect.height);
    return {x,y};
  }

  function pointerDown(e){
    ctx.shadowBlur = 0; ctx.shadowColor = 'transparent';
    const {x,y} = eventXY(e);
    drawing = true; lastX=x; lastY=y; lastStampX=x; lastStampY=y;

    if(mode==='erase'){
      ctx.globalCompositeOperation='destination-out';
      ctx.lineCap='round'; ctx.lineJoin='round';
      ctx.lineWidth=brushSize; ctx.strokeStyle='rgba(0,0,0,1)';
      ctx.beginPath(); ctx.moveTo(x,y); return;
    }
    ctx.globalCompositeOperation='source-over';

    if(brush==='eyeliner'){
      ctx.lineCap='butt'; ctx.lineJoin='round';
      ctx.lineWidth=Math.max(1, brushSize*0.55);
      ctx.strokeStyle=brushColor;
      ctx.beginPath(); ctx.moveTo(x,y);
    }else if(brush==='lipstick'){
      ctx.lineCap='round'; ctx.lineJoin='round';
      ctx.lineWidth=Math.max(2, brushSize*0.9);
      ctx.strokeStyle=withAlpha(brushColor,0.85);
      ctx.shadowColor=brushColor; ctx.shadowBlur=Math.floor(brushSize*0.15);
      ctx.beginPath(); ctx.moveTo(x,y);
    }
  }

  function pointerMove(e){
    if(!drawing) return;
    const {x,y} = eventXY(e);

    if(mode==='erase'){
      ctx.lineTo(x,y); ctx.stroke(); lastX=x; lastY=y; return;
    }

    if(brush==='eyeliner' || brush==='lipstick'){
      ctx.lineTo(x,y); ctx.stroke(); lastX=x; lastY=y; return;
    }

    // stamps (shadow, blush, remover)
    const dist = Math.hypot(x-lastStampX, y-lastStampY);
    const step = brushSize * stampSpacing;
    if(dist >= step){
      const n = Math.floor(dist/step);
      for(let i=1;i<=n;i++){
        const t=i/n, sx=lastStampX+(x-lastStampX)*t, sy=lastStampY+(y-lastStampY)*t;
        stamp(sx,sy);
      }
      lastStampX=x; lastStampY=y;
    }
  }

  function pointerUp(){
    if(!drawing) return;
    drawing=false; try{ctx.closePath();}catch(_){}
    ctx.shadowBlur=0;
    pushHistory(); redoStack=[];
  }

  function stamp(x,y){
    // shadow & blush: usar bordes del mismo color con alfa 0, y mezcla 'lighter'
    if(brush==='shadow'){
      const r = brushSize*0.6;
      const g = ctx.createRadialGradient(x,y,0,x,y,r);
      g.addColorStop(0, withAlpha(brushColor,0.18));
      g.addColorStop(1, withAlpha(brushColor,0.00));
      const prev = ctx.globalCompositeOperation;
      ctx.globalCompositeOperation='lighter';
      ctx.fillStyle=g; ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fill();
      ctx.globalCompositeOperation=prev; return;
    }
    if(brush==='blush'){
      const R = brushSize*0.96;
      const g = ctx.createRadialGradient(x,y,0,x,y,R);
      g.addColorStop(0, withAlpha(brushColor,0.12));
      g.addColorStop(1, withAlpha(brushColor,0.00));
      const prev = ctx.globalCompositeOperation;
      ctx.globalCompositeOperation='lighter';
      ctx.fillStyle=g; ctx.beginPath(); ctx.arc(x,y,R,0,Math.PI*2); ctx.fill();
      ctx.globalCompositeOperation=prev; return;
    }
    if(brush==='remover'){
      const r = brushSize*0.7;
      const g = ctx.createRadialGradient(x,y,0,x,y,r);
      g.addColorStop(0,'rgba(255,255,255,0.25)');
      g.addColorStop(0.3,'rgba(255,255,255,0.10)');
      g.addColorStop(1,'rgba(255,255,255,0.00)');
      const prev = ctx.globalCompositeOperation;
      ctx.globalCompositeOperation='destination-out';
      ctx.fillStyle=g; ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fill();
      ctx.globalCompositeOperation=prev; return;
    }
  }

  // —— Acciones
  file.addEventListener('change', (e)=>{
    const f = e.target.files?.[0]; if(!f) return;
    const reader = new FileReader();
    reader.onload = () => { bg.src = reader.result; };
    reader.readAsDataURL(f);
  });
  bg.addEventListener('load', ()=>{
    bgLoaded = true; ph.style.display='none'; resize(); pushHistory(); redoStack=[];
  });

  size.addEventListener('input', ()=>{ brushSize = parseInt(size.value,10); sizev.textContent=size.value; });
  color.addEventListener('input', ()=>{ brushColor = color.value; });

  modeDraw.addEventListener('click', ()=>{
    mode='draw'; modeDraw.classList.add('active'); modeErase.classList.remove('active'); updateCursor();
  });
  modeErase.addEventListener('click', ()=>{
    mode='erase'; modeErase.classList.add('active'); modeDraw.classList.remove('active'); updateCursor();
  });

  document.querySelectorAll('[data-brush]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      document.querySelectorAll('[data-brush]').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      brush = btn.getAttribute('data-brush');
      updateCursor();
    });
  });

  undoBtn.addEventListener('click', undo);
  redoBtn.addEventListener('click', redo);
  clearBtn.addEventListener('click', ()=>{
    if(!confirm('¿Limpiar todos los trazos?')) return;
    ctx.save(); ctx.setTransform(1,0,0,1,0,0); ctx.clearRect(0,0,cv.width,cv.height); ctx.restore();
    pushHistory(); redoStack=[];
  });

  downloadBtn.addEventListener('click', downloadMerged);
  function downloadMerged(){
    const dpr = window.devicePixelRatio || 1;
    const cssW = parseInt(cv.style.width,10) || cv.width/dpr;
    const cssH = parseInt(cv.style.height,10) || cv.height/dpr;

    const out = document.createElement('canvas'); out.width=cssW; out.height=cssH;
    const o = out.getContext('2d');
    if(bgLoaded) o.drawImage(bg,0,0,cssW,cssH); else { o.fillStyle='#fff'; o.fillRect(0,0,cssW,cssH); }
    o.drawImage(cv,0,0,cssW,cssH);

    const a = document.createElement('a'); a.download='dibujo.png'; a.href=out.toDataURL('image/png'); a.click();
  }

  // —— Eventos pointer
  stage.addEventListener('mousedown', pointerDown);
  stage.addEventListener('mousemove', pointerMove);
  stage.addEventListener('mouseup', pointerUp);
  stage.addEventListener('mouseleave', pointerUp);
  stage.addEventListener('touchstart', pointerDown, {passive:true});
  stage.addEventListener('touchmove', pointerMove, {passive:true});
  stage.addEventListener('touchend', pointerUp);

  // —— Atajos
  window.addEventListener('keydown',(e)=>{
    const k = e.key.toLowerCase();
    if((e.ctrlKey||e.metaKey) && k==='z'){ e.preventDefault(); return undo(); }
    if((e.ctrlKey||e.metaKey) && k==='y'){ e.preventDefault(); return redo(); }
    if((e.ctrlKey||e.metaKey) && k==='s'){ e.preventDefault(); return downloadMerged(); }
    if(k==='e'){ mode='erase'; modeErase.classList.add('active'); modeDraw.classList.remove('active'); updateCursor(); }
    if(k==='d'){ mode='draw'; modeDraw.classList.add('active'); modeErase.classList.remove('active'); updateCursor(); }
  });

  window.addEventListener('resize', ()=>{ resize(); });

  // —— Init
  resize(); updateCursor(); pushHistory();

    // --- Preguntas "quemadas"
  const preguntas = [
"¿Cómo crees que cambiaria tu aspecto si hubieras nacido en una familia con mucho dinero?",
"¿Cómo crees que lucirías si te hubieran educado como a un cuerpo masculino?",
"¿Cómo crees que lucirías si nunca hubieras hecho ejercicio?",
"¿Cómo crees que lucirías si hubieras nacido en un país diferente?",
"¿Cómo crees que lucirías si  te cepillaras los dientes de vez en cuando?",
"¿Cómo crees que lucirías si la familia de tu mejor amigue te hubiera criado?",
"¿Cómo crees que lucirías si te hubiera dicho que eras la mujer más hermosa del mundo?",
"¿Cómo crees que lucirías si nunca hubieras visto a alguien igual que tu en una revista?",
"¿Cómo crees que lucirías si en la infancia solo hubieras utilizado el color blanco?",
"¿Cómo crees que lucirías si ni los espejos, ni las máquinas existieran?"

  ];
  let indexQ = 0;
  const qEl = document.getElementById('question');
  const nextBtn = document.getElementById('nextQ');

  nextBtn.addEventListener('click', ()=>{
    indexQ++;
    if(indexQ >= preguntas.length) indexQ = 0; // vuelve al inicio en bucle
    qEl.textContent = preguntas[indexQ];
  });

})();
</script>
</body>
</html>
