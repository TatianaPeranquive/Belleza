<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '')</title>
    @vite('resources/css/app.css')
</head>
<body class="{{ $theme === 'dark' ? 'bg-[#111827] text-[#F9FAFB]' : 'bg--[#34113F] text-[#111827]' }}">
    <header class="fixed top-0 left-0 w-full bg-[#34113F] z-50">
    <div class="flex justify-between items-center p-4 text--[#34113F]">
        <div class="font-bold text-lg"></div>
        <button id="menuButton" class="text--[#34113F] font-bold px-4 py-2 border rounded">MENU</button>
    </div>
    <nav id="menuPanel" class="hidden bg-[#34113F] text--[#34113F] text-center absolute top-full left-0 w-full">
        <ul class="flex flex-col gap-4 py-6">
            <li><a href="{{ route('home') }}" class="text-xl hover:underline">Inicio</a></li>
            <li><a href="{{ route('entrevistas.index') }}" class="text-xl hover:underline">Entrevistas</a></li>
            <li><a href="#" class="text-xl hover:underline">Llenar tu Espejo</a></li>
            </li><a href="{{ route('detras.many', ['ids' => '11,12']) }} " class="text-xl hover:underline">Detrás del espejo</a></li>
        </ul>
    </nav>
</header>

 <main class="min-h-screen">
    @yield('content')
</main>

<div class="fixed bottom-4 right-4 bg-[#34113F] p-4 rounded text--[#34113F] shadow-lg">
  <a href="{{ route('theme.switch','light') }}"
     class=" px-3 py-1 rounded border text--[#34113F] font-bold text-lg hover:underline"
     title="Claro">Claro</a>
  <a href="{{ route('theme.switch','dark') }}"
     class="px-3 py-1 rounded border text-gray font-bold text-lg hover:underline"
     title="Oscuro">Oscuro</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    const menuButton = document.getElementById('menuButton');
    const menuPanel = document.getElementById('menuPanel');
    let menuOpen = false;

    menuButton.addEventListener('click', () => {
        if (!menuOpen) {
            menuPanel.classList.remove('hidden');
            gsap.fromTo(menuPanel, { y: -100, opacity: 0 }, { y: 0, opacity: 1, duration: 0.5 });
        } else {
            gsap.to(menuPanel, { y: -100, opacity: 0, duration: 0.5, onComplete: () => {
                menuPanel.classList.add('hidden');
            }});
        }
        menuOpen = !menuOpen;
    });

    const audio = new Audio('{{ asset("storage/audio/audio1.mp3") }}');
    document.getElementById('playBtn').addEventListener('click', () => audio.play());
    document.getElementById('pauseBtn').addEventListener('click', () => audio.pause());
</script>

</body>
</html>
