<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
</head>
<body class="{{ $theme === 'dark' ? 'bg-[#111827] text-[#F9FAFB]' : 'bg-white text-[#111827]' }}">
    <header class="fixed top-0 left-0 w-full bg-black z-50">
    <div class="flex justify-between items-center p-4 text-white">
        <div class="font-bold text-lg"></div>
        <div class="flex justify-between items-center p-4 text-white"></div>
                <nav id="menu"
                    class="fixed top-0 left-0 w-full z-50 opacity-0 pointer-events-none transition-all duration-300">
                    <ul class="flex justify-center gap-4 w-full max-w-6xl mx-auto">

                        <li class="flex-1">
                            <a href="#home"
                                class="block w-full text-center  px-4 py-2  rounded border font-bold text-lg hover:underline">
                                Espejito, espejito
                            </a>
                        </li>
                        <li class="flex-1">
                            <a href="#work"
                                class="block w-full text-center  px-4 py-2  rounded border font-bold text-lg hover:underline">
                                Entramado
                            </a>
                        </li>
                        <li class="flex-1">
                                <a href="{{ route('entrevistas.index') }}"

                                class="block w-full text-center px-4 py-2  rounded border font-bold text-lg hover:underline">
                                Salón de espejos
                            </a>
                        </li>
                        <li class="flex-1">
                            <a href="{{ route('diccionario.buscar', 'palabra') }}"

                                class="block w-full text-center  px-4 py-2  rounded border font-bold text-lg hover:underline">
                                Dentro del espejo
                            </a>
                        </li>
                        <li class="flex-1">
                            <a href="{{ route('detras.many', ['ids' => '11,12']) }} "
                                class="block w-full text-center  px-4 py-2  rounded border font-bold text-lg hover:underline">
                                Detrás del espejo
                            </a>
                        </li>
                    </ul>
                </nav>
</div>
    </div>

</header>

 <main class="min-h-screen">
    @yield('content')
</main>

<!-- <div class="fixed bottom-4 right-4 bg-black p-4 rounded text-white shadow-lg">
  <a href="{{ route('theme.switch','light') }}"
     class=" px-3 py-1 rounded border text-white font-bold text-lg hover:underline"
     title="Claro">Claro</a>
  <a href="{{ route('theme.switch','dark') }}"
     class="px-3 py-1 rounded border text-gray font-bold text-lg hover:underline"
     title="Oscuro">Oscuro</a>
</div> -->

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
