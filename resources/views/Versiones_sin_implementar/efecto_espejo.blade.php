
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />

  <style>
    body, html {
      margin: 0;
      height: 200vh; /* Para tener scroll */
      background: black;
      overflow-x: hidden;
    }

    svg {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100vmin;
      height: 100vmin;
    }

    polygon {
      transition: transform 0.3s ease-out;
    }
  </style>
</head>
<body>

<svg viewBox="0 0 500 500" id="mirror">
  <defs>
    <pattern id="mirrorImg" patternUnits="userSpaceOnUse" width="500" height="500">
      <image   href="{{ asset('espejo.png') }}"
                xlink:href="{{ asset('espejo.png') }}"
                width="500" height="500"/>
         <!-- background-image: url('vidrio_fragmentado.jpg');
          <a href='https://es.pngtree.com/freepng/antique-round-oval-gold-picture-mirror-frame-isolated-on-transparent-background_20229280.html'>Imagen PNG de es.pngtree.com/</a>-->
    </pattern>
  </defs>

  <!-- Fragmentos tipo cristal -->
<polygon points="500,500 497,179 500,0" fill="url(#mirrorImg)" />
<polygon points="0,500 53,492 133,500" fill="url(#mirrorImg)" />
<polygon points="493,420 497,179 500,500" fill="url(#mirrorImg)" />
<polygon points="497,179 493,420 481,244" fill="url(#mirrorImg)" />
<polygon points="101,465 53,492 26,434" fill="url(#mirrorImg)" />
<polygon points="19,459 53,492 0,500" fill="url(#mirrorImg)" />
<polygon points="53,492 19,459 26,434" fill="url(#mirrorImg)" />
<polygon points="409,7 398,12 243,18" fill="url(#mirrorImg)" />
<polygon points="500,0 409,7 0,0" fill="url(#mirrorImg)" />
<polygon points="409,7 243,18 0,0" fill="url(#mirrorImg)" />
<polygon points="282,83 191,44 243,18" fill="url(#mirrorImg)" />
<polygon points="251,474 328,429 359,463" fill="url(#mirrorImg)" />
<polygon points="164,486 251,474 133,500" fill="url(#mirrorImg)" />
<polygon points="251,474 500,500 133,500" fill="url(#mirrorImg)" />
<polygon points="475,351 487,403 447,389" fill="url(#mirrorImg)" />
<polygon points="493,420 487,403 481,244" fill="url(#mirrorImg)" />
<polygon points="487,403 475,351 481,244" fill="url(#mirrorImg)" />
<polygon points="393,280 385,295 346,250" fill="url(#mirrorImg)" />
<polygon points="393,280 418,273 385,295" fill="url(#mirrorImg)" />
<polygon points="475,351 435,276 481,244" fill="url(#mirrorImg)" />
<polygon points="418,273 435,276 385,295" fill="url(#mirrorImg)" />
<polygon points="450,158 467,157 497,179" fill="url(#mirrorImg)" />
<polygon points="435,276 463,246 481,244" fill="url(#mirrorImg)" />
<polygon points="463,246 435,276 418,273" fill="url(#mirrorImg)" />
<polygon points="463,246 497,179 481,244" fill="url(#mirrorImg)" />
<polygon points="463,246 450,158 497,179" fill="url(#mirrorImg)" />
<polygon points="2,122 0,500 0,0" fill="url(#mirrorImg)" />
<polygon points="53,492 86,492 133,500" fill="url(#mirrorImg)" />
<polygon points="101,465 86,492 53,492" fill="url(#mirrorImg)" />
<polygon points="409,7 430,20 398,12" fill="url(#mirrorImg)" />
<polygon points="398,12 308,52 243,18" fill="url(#mirrorImg)" />
<polygon points="308,52 282,83 243,18" fill="url(#mirrorImg)" />
<polygon points="282,83 308,52 310,123" fill="url(#mirrorImg)" />
<polygon points="321,310 264,276 346,250" fill="url(#mirrorImg)" />
<polygon points="385,295 321,310 346,250" fill="url(#mirrorImg)" />
<polygon points="264,276 252,241 346,250" fill="url(#mirrorImg)" />
<polygon points="230,467 251,474 164,486" fill="url(#mirrorImg)" />
<polygon points="251,474 288,420 328,429" fill="url(#mirrorImg)" />
<polygon points="328,429 288,420 327,375" fill="url(#mirrorImg)" />
<polygon points="487,403 476,426 447,389" fill="url(#mirrorImg)" />
<polygon points="476,426 487,403 493,420" fill="url(#mirrorImg)" />
<polygon points="476,426 493,420 500,500" fill="url(#mirrorImg)" />
<polygon points="362,374 321,310 385,295" fill="url(#mirrorImg)" />
<polygon points="362,374 328,429 327,375" fill="url(#mirrorImg)" />
<polygon points="328,429 362,374 359,463" fill="url(#mirrorImg)" />
<polygon points="362,374 426,399 359,463" fill="url(#mirrorImg)" />
<polygon points="426,399 413,380 447,389" fill="url(#mirrorImg)" />
<polygon points="413,380 475,351 447,389" fill="url(#mirrorImg)" />
<polygon points="413,380 362,374 385,295" fill="url(#mirrorImg)" />
<polygon points="362,374 413,380 426,399" fill="url(#mirrorImg)" />
<polygon points="413,380 435,276 475,351" fill="url(#mirrorImg)" />
<polygon points="435,276 413,380 385,295" fill="url(#mirrorImg)" />
<polygon points="482,107 467,157 450,158" fill="url(#mirrorImg)" />
<polygon points="482,107 450,158 408,83" fill="url(#mirrorImg)" />
<polygon points="482,107 485,96 497,179" fill="url(#mirrorImg)" />
<polygon points="467,157 482,107 497,179" fill="url(#mirrorImg)" />
<polygon points="345,205 252,241 255,198" fill="url(#mirrorImg)" />
<polygon points="252,241 345,205 346,250" fill="url(#mirrorImg)" />
<polygon points="463,246 411,202 450,158" fill="url(#mirrorImg)" />
<polygon points="411,202 463,246 418,273" fill="url(#mirrorImg)" />
<polygon points="393,280 411,202 418,273" fill="url(#mirrorImg)" />
<polygon points="38,44 10,92 0,0" fill="url(#mirrorImg)" />
<polygon points="10,92 2,122 0,0" fill="url(#mirrorImg)" />
<polygon points="50,22 38,44 0,0" fill="url(#mirrorImg)" />
<polygon points="72,18 50,22 0,0" fill="url(#mirrorImg)" />
<polygon points="50,22 72,18 38,44" fill="url(#mirrorImg)" />
<polygon points="86,492 123,486 133,500" fill="url(#mirrorImg)" />
<polygon points="123,486 86,492 101,465" fill="url(#mirrorImg)" />
<polygon points="123,486 164,486 133,500" fill="url(#mirrorImg)" />
<polygon points="123,486 101,465 164,486" fill="url(#mirrorImg)" />
<polygon points="295,355 194,346 264,276" fill="url(#mirrorImg)" />
<polygon points="197,426 230,467 164,486" fill="url(#mirrorImg)" />
<polygon points="447,71 482,107 408,83" fill="url(#mirrorImg)" />
<polygon points="448,18 409,7 500,0" fill="url(#mirrorImg)" />
<polygon points="448,18 430,20 409,7" fill="url(#mirrorImg)" />
<polygon points="448,18 447,71 430,20" fill="url(#mirrorImg)" />
<polygon points="308,52 396,48 408,83" fill="url(#mirrorImg)" />
<polygon points="396,48 308,52 398,12" fill="url(#mirrorImg)" />
<polygon points="430,20 396,48 398,12" fill="url(#mirrorImg)" />
<polygon points="396,48 447,71 408,83" fill="url(#mirrorImg)" />
<polygon points="447,71 396,48 430,20" fill="url(#mirrorImg)" />
<polygon points="312,327 295,355 264,276" fill="url(#mirrorImg)" />
<polygon points="321,310 312,327 264,276" fill="url(#mirrorImg)" />
<polygon points="187,131 171,181 93,138" fill="url(#mirrorImg)" />
<polygon points="285,117 282,83 310,123" fill="url(#mirrorImg)" />
<polygon points="238,158 187,131 282,83" fill="url(#mirrorImg)" />
<polygon points="285,117 238,158 282,83" fill="url(#mirrorImg)" />
<polygon points="230,467 243,453 251,474" fill="url(#mirrorImg)" />
<polygon points="288,420 243,453 246,421" fill="url(#mirrorImg)" />
<polygon points="243,453 288,420 251,474" fill="url(#mirrorImg)" />
<polygon points="243,453 197,426 246,421" fill="url(#mirrorImg)" />
<polygon points="197,426 243,453 230,467" fill="url(#mirrorImg)" />
<polygon points="452,480 476,426 500,500" fill="url(#mirrorImg)" />
<polygon points="345,205 369,205 346,250" fill="url(#mirrorImg)" />
<polygon points="369,205 345,205 370,204" fill="url(#mirrorImg)" />
<polygon points="369,205 393,280 346,250" fill="url(#mirrorImg)" />
<polygon points="369,205 411,202 393,280" fill="url(#mirrorImg)" />
<polygon points="411,202 369,205 370,204" fill="url(#mirrorImg)" />
<polygon points="345,205 348,140 370,204" fill="url(#mirrorImg)" />
<polygon points="348,140 308,52 408,83" fill="url(#mirrorImg)" />
<polygon points="308,52 348,140 310,123" fill="url(#mirrorImg)" />
<polygon points="348,140 411,202 370,204" fill="url(#mirrorImg)" />
<polygon points="450,158 348,140 408,83" fill="url(#mirrorImg)" />
<polygon points="411,202 348,140 450,158" fill="url(#mirrorImg)" />
<polygon points="72,18 66,71 38,44" fill="url(#mirrorImg)" />
<polygon points="78,78 66,71 72,18" fill="url(#mirrorImg)" />
<polygon points="66,71 10,92 38,44" fill="url(#mirrorImg)" />
<polygon points="132,39 191,44 183,52" fill="url(#mirrorImg)" />
<polygon points="194,346 292,369 246,421" fill="url(#mirrorImg)" />
<polygon points="292,369 194,346 295,355" fill="url(#mirrorImg)" />
<polygon points="292,369 288,420 246,421" fill="url(#mirrorImg)" />
<polygon points="292,369 295,355 327,375" fill="url(#mirrorImg)" />
<polygon points="288,420 292,369 327,375" fill="url(#mirrorImg)" />
<polygon points="194,346 183,301 264,276" fill="url(#mirrorImg)" />
<polygon points="183,301 194,346 159,352" fill="url(#mirrorImg)" />
<polygon points="194,346 186,368 159,352" fill="url(#mirrorImg)" />
<polygon points="186,368 194,346 246,421" fill="url(#mirrorImg)" />
<polygon points="197,426 186,368 246,421" fill="url(#mirrorImg)" />
<polygon points="101,465 102,409 164,486" fill="url(#mirrorImg)" />
<polygon points="102,409 197,426 164,486" fill="url(#mirrorImg)" />
<polygon points="186,368 102,409 159,352" fill="url(#mirrorImg)" />
<polygon points="102,409 186,368 197,426" fill="url(#mirrorImg)" />
<polygon points="102,409 101,465 26,434" fill="url(#mirrorImg)" />
<polygon points="12,322 19,459 0,500" fill="url(#mirrorImg)" />
<polygon points="19,459 12,322 26,434" fill="url(#mirrorImg)" />
<polygon points="2,122 12,322 0,500" fill="url(#mirrorImg)" />
<polygon points="447,71 469,76 482,107" fill="url(#mirrorImg)" />
<polygon points="448,18 469,76 447,71" fill="url(#mirrorImg)" />
<polygon points="295,355 318,342 327,375" fill="url(#mirrorImg)" />
<polygon points="312,327 318,342 295,355" fill="url(#mirrorImg)" />
<polygon points="318,342 362,374 327,375" fill="url(#mirrorImg)" />
<polygon points="362,374 318,342 321,310" fill="url(#mirrorImg)" />
<polygon points="318,342 312,327 321,310" fill="url(#mirrorImg)" />
<polygon points="10,92 9,129 2,122" fill="url(#mirrorImg)" />
<polygon points="171,181 206,186 192,200" fill="url(#mirrorImg)" />
<polygon points="206,186 171,181 187,131" fill="url(#mirrorImg)" />
<polygon points="238,158 206,186 187,131" fill="url(#mirrorImg)" />
<polygon points="247,181 238,158 285,117" fill="url(#mirrorImg)" />
<polygon points="247,181 285,117 310,123" fill="url(#mirrorImg)" />
<polygon points="206,186 247,181 255,198" fill="url(#mirrorImg)" />
<polygon points="247,181 206,186 238,158" fill="url(#mirrorImg)" />
<polygon points="391,472 452,480 500,500" fill="url(#mirrorImg)" />
<polygon points="251,474 391,472 500,500" fill="url(#mirrorImg)" />
<polygon points="391,472 251,474 359,463" fill="url(#mirrorImg)" />
<polygon points="426,399 391,472 359,463" fill="url(#mirrorImg)" />
<polygon points="452,480 440,432 476,426" fill="url(#mirrorImg)" />
<polygon points="440,432 426,399 447,389" fill="url(#mirrorImg)" />
<polygon points="476,426 440,432 447,389" fill="url(#mirrorImg)" />
<polygon points="440,432 391,472 426,399" fill="url(#mirrorImg)" />
<polygon points="391,472 440,432 452,480" fill="url(#mirrorImg)" />
<polygon points="348,140 333,141 310,123" fill="url(#mirrorImg)" />
<polygon points="333,141 345,205 255,198" fill="url(#mirrorImg)" />
<polygon points="247,181 333,141 255,198" fill="url(#mirrorImg)" />
<polygon points="333,141 247,181 310,123" fill="url(#mirrorImg)" />
<polygon points="67,154 81,122 93,138" fill="url(#mirrorImg)" />
<polygon points="113,21 78,78 72,18" fill="url(#mirrorImg)" />
<polygon points="243,18 113,21 0,0" fill="url(#mirrorImg)" />
<polygon points="113,21 72,18 0,0" fill="url(#mirrorImg)" />
<polygon points="191,44 113,21 243,18" fill="url(#mirrorImg)" />
<polygon points="132,39 113,21 191,44" fill="url(#mirrorImg)" />
<polygon points="113,21 124,70 78,78" fill="url(#mirrorImg)" />
<polygon points="124,70 113,21 132,39" fill="url(#mirrorImg)" />
<polygon points="124,70 132,39 183,52" fill="url(#mirrorImg)" />
<polygon points="206,186 217,241 192,200" fill="url(#mirrorImg)" />
<polygon points="217,241 252,241 264,276" fill="url(#mirrorImg)" />
<polygon points="183,301 217,241 264,276" fill="url(#mirrorImg)" />
<polygon points="252,241 217,241 255,198" fill="url(#mirrorImg)" />
<polygon points="217,241 206,186 255,198" fill="url(#mirrorImg)" />
<polygon points="102,409 93,324 159,352" fill="url(#mirrorImg)" />
<polygon points="93,324 102,409 60,342" fill="url(#mirrorImg)" />
<polygon points="217,241 124,243 192,200" fill="url(#mirrorImg)" />
<polygon points="124,243 217,241 183,301" fill="url(#mirrorImg)" />
<polygon points="35,379 102,409 26,434" fill="url(#mirrorImg)" />
<polygon points="102,409 35,379 60,342" fill="url(#mirrorImg)" />
<polygon points="12,322 35,379 26,434" fill="url(#mirrorImg)" />
<polygon points="5,132 7,135 20,175" fill="url(#mirrorImg)" />
<polygon points="12,322 5,132 20,175" fill="url(#mirrorImg)" />
<polygon points="5,132 12,322 2,122" fill="url(#mirrorImg)" />
<polygon points="9,129 5,132 2,122" fill="url(#mirrorImg)" />
<polygon points="5,132 9,129 7,135" fill="url(#mirrorImg)" />
<polygon points="482,107 476,82 485,96" fill="url(#mirrorImg)" />
<polygon points="469,76 476,82 482,107" fill="url(#mirrorImg)" />
<polygon points="339,142 348,140 345,205" fill="url(#mirrorImg)" />
<polygon points="333,141 339,142 345,205" fill="url(#mirrorImg)" />
<polygon points="339,142 333,141 348,140" fill="url(#mirrorImg)" />
<polygon points="81,122 83,118 93,138" fill="url(#mirrorImg)" />
<polygon points="83,118 124,70 93,138" fill="url(#mirrorImg)" />
<polygon points="69,94 9,129 10,92" fill="url(#mirrorImg)" />
<polygon points="66,71 69,94 10,92" fill="url(#mirrorImg)" />
<polygon points="69,94 83,118 81,122" fill="url(#mirrorImg)" />
<polygon points="69,94 66,71 78,78" fill="url(#mirrorImg)" />
<polygon points="179,92 187,131 93,138" fill="url(#mirrorImg)" />
<polygon points="124,70 179,92 93,138" fill="url(#mirrorImg)" />
<polygon points="179,92 124,70 183,52" fill="url(#mirrorImg)" />
<polygon points="187,131 179,92 282,83" fill="url(#mirrorImg)" />
<polygon points="191,44 179,92 183,52" fill="url(#mirrorImg)" />
<polygon points="282,83 179,92 191,44" fill="url(#mirrorImg)" />
<polygon points="156,192 171,181 192,200" fill="url(#mirrorImg)" />
<polygon points="124,243 156,192 192,200" fill="url(#mirrorImg)" />
<polygon points="171,181 156,192 93,138" fill="url(#mirrorImg)" />
<polygon points="156,192 67,154 93,138" fill="url(#mirrorImg)" />
<polygon points="108,303 124,243 183,301" fill="url(#mirrorImg)" />
<polygon points="108,303 183,301 159,352" fill="url(#mirrorImg)" />
<polygon points="93,324 108,303 159,352" fill="url(#mirrorImg)" />
<polygon points="497,56 476,82 469,76" fill="url(#mirrorImg)" />
<polygon points="497,56 448,18 500,0" fill="url(#mirrorImg)" />
<polygon points="497,56 469,76 448,18" fill="url(#mirrorImg)" />
<polygon points="476,82 497,56 485,96" fill="url(#mirrorImg)" />
<polygon points="497,179 497,56 500,0" fill="url(#mirrorImg)" />
<polygon points="485,96 497,56 497,179" fill="url(#mirrorImg)" />
<polygon points="69,94 40,149 9,129" fill="url(#mirrorImg)" />
<polygon points="40,149 69,94 81,122" fill="url(#mirrorImg)" />
<polygon points="40,149 81,122 67,154" fill="url(#mirrorImg)" />
<polygon points="9,129 40,149 7,135" fill="url(#mirrorImg)" />
<polygon points="40,149 67,154 20,175" fill="url(#mirrorImg)" />
<polygon points="7,135 40,149 20,175" fill="url(#mirrorImg)" />
<polygon points="75,94 69,94 78,78" fill="url(#mirrorImg)" />
<polygon points="69,94 75,94 83,118" fill="url(#mirrorImg)" />
<polygon points="124,70 75,94 78,78" fill="url(#mirrorImg)" />
<polygon points="83,118 75,94 124,70" fill="url(#mirrorImg)" />
<polygon points="76,327 93,324 60,342" fill="url(#mirrorImg)" />
<polygon points="25,291 12,322 20,175" fill="url(#mirrorImg)" />
<polygon points="54,293 25,291 20,175" fill="url(#mirrorImg)" />
<polygon points="156,192 121,240 67,154" fill="url(#mirrorImg)" />
<polygon points="121,240 156,192 124,243" fill="url(#mirrorImg)" />
<polygon points="67,154 121,240 20,175" fill="url(#mirrorImg)" />
<polygon points="121,240 54,293 20,175" fill="url(#mirrorImg)" />
<polygon points="83,315 108,303 93,324" fill="url(#mirrorImg)" />
<polygon points="76,327 83,315 93,324" fill="url(#mirrorImg)" />
<polygon points="83,315 76,327 54,293" fill="url(#mirrorImg)" />
<polygon points="50,329 76,327 60,342" fill="url(#mirrorImg)" />
<polygon points="76,327 50,329 54,293" fill="url(#mirrorImg)" />
<polygon points="35,379 50,329 60,342" fill="url(#mirrorImg)" />
<polygon points="50,329 35,379 12,322" fill="url(#mirrorImg)" />
<polygon points="25,291 50,329 12,322" fill="url(#mirrorImg)" />
<polygon points="50,329 25,291 54,293" fill="url(#mirrorImg)" />
<polygon points="121,240 101,297 54,293" fill="url(#mirrorImg)" />
<polygon points="101,297 83,315 54,293" fill="url(#mirrorImg)" />
<polygon points="83,315 101,297 108,303" fill="url(#mirrorImg)" />
<polygon points="108,303 101,297 124,243" fill="url(#mirrorImg)" />
<polygon points="101,297 121,240 124,243" fill="url(#mirrorImg)" />
</svg>

<!-- GSAP + ScrollTrigger -->
<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js"></script>

<script>
  gsap.registerPlugin(ScrollTrigger);

  const fragments = document.querySelectorAll("polygon");

  // Animación con scroll
  fragments.forEach((frag, i) => {
    gsap.to(frag, {
      scrollTrigger: {
        trigger: "body",
        start: "top top",
        end: "bottom bottom",
        scrub: 1
      },
      x: (i % 2 === 0 ? -1 : 1) * 100, // separarlos izquierda/derecha
      y: (i < 2 ? -1 : 1) * 100, // arriba/abajo
      rotation: (i % 2 === 0 ? -15 : 15),
      scale: 1.2,
      transformOrigin: "center center"
    });
  });

  // Zoom de todo el SVG
  gsap.to("#mirror", {
    scrollTrigger: {
      trigger: "body",
      start: "top top",
      end: "bottom bottom",
      scrub: 1
    },
    scale: 1.2,
    transformOrigin: "center center"
  });
</script>
</body>
</html>
