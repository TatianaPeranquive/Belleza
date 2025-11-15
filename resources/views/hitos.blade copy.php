@extends('layouts.app') @section('title', 'Hitos - Proyecto Espejo')
@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div
    x-data="hitosUI()"
    x-init="init()"
    class="mx-auto max-w-6xl px-4 pt-20 pb-12"
>
    {{-- Título --}}
    <h1 class="mb-4 text-3xl font-extrabold tracking-tight uppercase">
        <span x-text="activeId ? (activeName || 'HITOS') : 'HITOS'"></span>
    </h1>

    {{-- HITOS (Nivel 0) --}}
    <section class="relative w-full">
        <div
            class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3"
            x-show="!activeId"
        >
            <template x-for="it in items" :key="it.id">
                <button
                    type="button"
                    @click="selectHito(it)"
                    class="text-left rounded-3xl border bg-[#34113F] shadow-sm hover:shadow p-5 transition"
                >
                    <h3 class="text-xl font-semibold" x-text="it.title"></h3>
                    <p class="mt-1 text-sm text-gray-600" x-text="it.text"></p>
                </button>
            </template>
        </div>

        <div
            x-show="activeId"
            x-transition
            class="relative h-[480px] sm:h-[520px] lg:h-[560px]"
            :class="{ 'pointer-events-none': showSubs }"
        >
            <template x-for="(it, idx) in items" :key="it.id">
                <button
                    type="button"
                    @click="selectHito(it)"
                    @mouseenter="hovered = it.id"
                    @mouseleave="hovered = null"
                    class="absolute inset-0 mx-auto focus:outline-none transition will-change-transform transform-gpu"
                    :style="cardStyle(it.id, idx)"
                    :class="cardClasses(it.id)"
                >
                    <div
                        class="h-full w-full rounded-3xl border bg-[#f8f8fa] shadow-xl transition p-6 overflow-hidden"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3
                                    class="text-xl font-semibold"
                                    x-text="it.title"
                                ></h3>
                                <p
                                    class="mt-2 text-sm text-gray-600"
                                    x-text="it.text"
                                ></p>
                            </div>
                            <span
                                class="rounded-full px-2 py-0.5 text-xs font-medium transition"
                                :class="activeId === it.id ? 'bg-[#34113F]-600 text-[#f8f8fa]' : 'bg-gray-200 text-gray-700'"
                            >
                                <span
                                    x-text="activeId === it.id ? 'Seleccionado' : 'Cambiar'"
                                ></span>
                            </span>
                        </div>
                        <div
                            class="mt-6 h-[70%] rounded-2xl border border-dashed bg-gray-50"
                        ></div>
                    </div>
                </button>
            </template>
        </div>

        <div class="mt-4 flex gap-2" x-show="activeId">
            <button
                type="button"
                class="rounded-2xl border px-4 py-2"
                @click="resetAll()"
            >
                Cambiar hito
            </button>
            <span class="text-sm text-gray-500" x-text="activeName"></span>
        </div>
    </section>

    {{-- CONTINUAR --}}
    <div
        x-show="activeId && !showSubs"
        x-transition.opacity
        class="mt-6 relative z-50"
    >
        <button
            type="button"
            @click="mostrarSubNivel(1)"
            class="group inline-flex items-center gap-2 rounded-2xl px-6 py-3 text-base font-semibold border shadow focus:outline-none focus:ring-4 !bg-[#34113F]-600 !text-[#f8f8fa] border-[#34113F]-600 focus:ring-[#34113F]-300 hover:bg-[#34113F]-700 active:scale-[0.98] disabled:bg-gray-200 disabled:text-gray-500 disabled:border-gray-300"
            aria-label="Continuar"
        >
            <svg
                class="h-5 w-5 transition-transform group-hover:translate-x-0.5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m9 5 7 7-7 7"
                />
            </svg>
            <span class="!text-[#f8f8fa]">Continuar</span>
        </button>
    </div>

    {{-- SUBNIVELES --}}
    <template x-for="lvl in [1,2,3]" :key="lvl">
        <section
            x-show="sub[lvl].visible"
            x-transition.opacity
            class="mt-10 relative z-50"
            :id="`subs-lvl-${lvl}`"
        >
            <h2
                class="mb-3 text-xl font-semibold"
                x-text="tituloNivel(lvl)"
            ></h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <template x-for="opt in sub[lvl].options" :key="opt.id">
                    <button
                        type="button"
                        @mouseenter="sub[lvl].hovered = opt.id"
                        @mouseleave="sub[lvl].hovered = null"
                        @focus="sub[lvl].hovered = opt.id"
                        @blur="sub[lvl].hovered = null"
                        @click="seleccionarNivel(lvl, opt)"
                        class="relative text-left focus:outline-none transition will-change-transform transform-gpu"
                        :class="{
              'rounded-3xl border bg-[#f8f8fa] shadow-sm p-5': true,
              'ring-2 ring-[#34113F]-600': (sub[lvl].selected?.id === opt.id),
              'opacity-80 hover:opacity-100': (sub[lvl].hovered === opt.id) || (sub[lvl].selected?.id === opt.id)
            }"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3
                                    class="text-base font-semibold"
                                    x-text="opt.title"
                                ></h3>
                                <p
                                    class="mt-2 text-sm text-gray-600"
                                    x-text="opt.text"
                                ></p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="rounded-full px-2 py-0.5 text-xs font-medium transition"
                                    :class="(sub[lvl].selected?.id === opt.id) ? 'bg-[#34113F]-600 text-[#f8f8fa]' : 'bg-gray-200 text-gray-700'"
                                >
                                    <span
                                        x-text="(sub[lvl].selected?.id === opt.id) ? 'Elegido' : 'Explorar'"
                                    ></span>
                                </span>
                            </div>
                        </div>
                    </button>
                </template>
            </div>

            <div class="mt-4 flex flex-wrap gap-3">
                <button
                    type="button"
                    class="rounded-2xl px-4 py-2 border"
                    @click="volverNivel(lvl)"
                >
                    Regresar
                </button>
                <button
                    type="button"
                    class="rounded-2xl px-4 py-2 text-[#f8f8fa] bg-[#34113F]-600 disabled:opacity-50"
                    :disabled="!sub[lvl].selected"
                    @click="continuarNivel(lvl)"
                >
                    Continuar
                </button>
                <button
                    type="button"
                    class="rounded-2xl px-4 py-2 bg-[#34113F] text-[#f8f8fa] disabled:opacity-50"
                    :disabled="!listo"
                    @click="finalizar()"
                >
                    Finalizar
                </button>
            </div>
        </section>
    </template>

    {{-- RESULTADOS --}}
    <br /><br />
    <section class="mt-8 relative z-50" x-show="listo">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-semibold">Resultados</h3>
            <div class="text-sm text-gray-500">
                <span x-show="loading">Cargando…</span>
                <span
                    x-show="!loading"
                    x-text="`Mostrando ${paged.length} de ${results.length}`"
                ></span>
            </div>
        </div>

        <div class="rounded border bg-[#f8f8fa]">
            <template x-if="!loading && results.length === 0">
                <div class="p-4 text-sm text-gray-600">
                    No hay resultados para los filtros seleccionados.
                </div>
            </template>

            <template x-if="!loading && results.length > 0">
                <div>
                    <ul class="divide-y">
                        <template
                            x-for="row in paged"
                            :key="row.id || (row.key ?? JSON.stringify(row))"
                        >
                            <li class="p-4">
                                <pre
                                    class="text-xs whitespace-pre-wrap"
                                    x-text="JSON.stringify(row, null, 2)"
                                ></pre>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>
        </div>

        {{-- Paginación front --}}
        <div class="mt-3 flex items-center gap-2">
            <button
                class="px-3 py-1 border rounded disabled:opacity-50"
                :disabled="page===1"
                @click="page--; updatePaged()"
            >
                Anterior
            </button>
            <span class="text-sm"
                >Página <span x-text="page"></span> /
                <span x-text="pages"></span
            ></span>
            <button
                class="px-3 py-1 border rounded disabled:opacity-50"
                :disabled="page===pages"
                @click="page++; updatePaged()"
            >
                Siguiente
            </button>
            <select
                class="ml-auto border rounded p-1 text-sm"
                x-model.number="pageSize"
                @change="page=1; updatePaged()"
            >
                <option :value="10">10</option>
                <option :value="25">25</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
            </select>
        </div>
    </section>
</div>

<script>
    function hitosUI() {
        return {
            // Estado UI
            hovered: null,
            activeId: null,
            activeName: "",
            showSubs: false,

            // Data
            items: [],
            desc: {},
            sub: {
                1: {
                    visible: false,
                    options: [],
                    hovered: null,
                    selected: null,
                },
                2: {
                    visible: false,
                    options: [],
                    hovered: null,
                    selected: null,
                },
                3: {
                    visible: false,
                    options: [],
                    hovered: null,
                    selected: null,
                },
            },

            // Ruta de filtros
            path: { hito: null, sub1: null, sub2: null, sub3: null },

            // Endpoint helpers
            ep: {
                hitos: '{{ url("/api/resumen/hitos") }}',
                sub1: (h) =>
                    `{{ url("/api/resumen/sub1") }}?hito=${encodeURIComponent(
                        h
                    )}`,
                sub2: (h, s1) =>
                    `{{ url("/api/resumen/sub2") }}?hito=${encodeURIComponent(
                        h
                    )}&sub1=${encodeURIComponent(s1)}`,
                sub3: (h, s1, s2) =>
                    `{{ url("/api/resumen/sub3") }}?hito=${encodeURIComponent(
                        h
                    )}&sub1=${encodeURIComponent(s1)}&sub2=${encodeURIComponent(
                        s2
                    )}`,
                buscar: (p) =>
                    `{{ url("/api/resumen/buscar") }}?${p.toString()}`,
            },

            // Paginación
            loading: false,
            results: [],
            page: 1,
            pages: 1,
            pageSize: 10,
            paged: [],

            // ====== INIT ======
            async init() {
                // Cargar lista de hitos
                const r = await fetch(this.ep.hitos);
                const arr = r.ok ? await r.json() : [];
                this.items = arr.map((name, i) => ({
                    id: i + 1,
                    key: name,
                    title: name,
                    text: this.desc[name] || "Explora este hito",
                }));

                // Leer parámetros de la URL
                const qs = new URLSearchParams(location.search);
                const qHito = qs.get("hito");
                const qSub1 = qs.get("hitosub1");

                if (qHito) {
                    const it = this.items.find(
                        (x) => x.key === qHito || x.title === qHito
                    );
                    if (it) {
                        this.activeId = it.id;
                        this.activeName = it.title;
                        this.path.hito = it.key;
                        this.showSubs = false;
                        this.resetFrom(1);
                        await this.mostrarSubNivel(1);
                        if (qSub1) {
                            const opt = this.sub[1].options.find(
                                (o) => o.key === qSub1 || o.title === qSub1
                            );
                            if (opt) this.seleccionarNivel(1, opt);
                        }
                    }
                }
            },

            // ====== UI helpers ======
            tituloNivel(lvl) {
                return lvl === 1
                    ? "Primer subnivel"
                    : lvl === 2
                    ? "Segundo subnivel"
                    : "Tercer subnivel";
            },

            resetAll() {
                this.activeId = null;
                this.activeName = "";
                this.showSubs = false;
                this.resetFrom(1);
            },

            resetFrom(k) {
                for (const lvl of [1, 2, 3]) {
                    if (lvl >= k) {
                        this.sub[lvl].visible = false;
                        this.sub[lvl].options = [];
                        this.sub[lvl].selected = null;
                        this.sub[lvl].hovered = null;
                    }
                }
                if (k === 1) {
                    this.path.sub1 = null;
                    this.path.sub2 = null;
                    this.path.sub3 = null;
                }
                if (k === 2) {
                    this.path.sub2 = null;
                    this.path.sub3 = null;
                }
                if (k === 3) {
                    this.path.sub3 = null;
                }
            },

            // ====== Navegación ======
            async selectHito(it) {
                this.activeId = it.id;
                this.activeName = it.title;
                this.path.hito = it.key;
                this.showSubs = false;
                this.resetFrom(1);
                // No buscamos aún; falta completar las categorías
            },

            async mostrarSubNivel(lvl) {
                if (!this.path.hito) return;
                this.showSubs = true;
                if (lvl === 1) {
                    this.sub[1].visible = true;
                    const r = await fetch(this.ep.sub1(this.path.hito));
                    const arr = r.ok ? await r.json() : [];
                    this.sub[1].options = arr.map((n, i) => ({
                        id: `1-${i + 1}`,
                        key: n,
                        title: n,
                        text: this.desc[n] || "",
                    }));
                }
                if (lvl === 2 && this.path.sub1) {
                    this.sub[2].visible = true;
                    const r = await fetch(
                        this.ep.sub2(this.path.hito, this.path.sub1)
                    );
                    const arr = r.ok ? await r.json() : [];
                    this.sub[2].options = arr.map((n, i) => ({
                        id: `2-${i + 1}`,
                        key: n,
                        title: n,
                        text: this.desc[n] || "",
                    }));
                }
                if (lvl === 3 && this.path.sub1 && this.path.sub2) {
                    this.sub[3].visible = true;
                    const r = await fetch(
                        this.ep.sub3(
                            this.path.hito,
                            this.path.sub1,
                            this.path.sub2
                        )
                    );
                    const arr = r.ok ? await r.json() : [];
                    this.sub[3].options = arr.map((n, i) => ({
                        id: `3-${i + 1}`,
                        key: n,
                        title: n,
                        text: this.desc[n] || "",
                    }));
                }
            },

            seleccionarNivel(lvl, opt) {
                this.sub[lvl].selected = opt;
                if (lvl === 1) {
                    this.path.sub1 = opt.key;
                    this.resetFrom(2);
                }
                if (lvl === 2) {
                    this.path.sub2 = opt.key;
                    this.resetFrom(3);
                }
                if (lvl === 3) {
                    this.path.sub3 = opt.key;
                }
            },

            async continuarNivel(lvl) {
                if (lvl === 1 && this.sub[1].selected) {
                    await this.mostrarSubNivel(2);
                }
                if (lvl === 2 && this.sub[2].selected) {
                    await this.mostrarSubNivel(3);
                }
            },

            async volverNivel(lvl) {
                if (lvl === 2) {
                    this.resetFrom(2);
                    this.sub[1].visible = true;
                }
                if (lvl === 3) {
                    this.resetFrom(3);
                    this.sub[2].visible = true;
                }
            },

            get listo() {
                return !!(
                    this.path.hito &&
                    this.path.sub1 &&
                    this.path.sub2 &&
                    this.path.sub3
                );
            },

            async finalizar() {
                if (!this.listo) return;
                await this.buscar(true);
            },

            // ====== Búsqueda y paginación ======
            async buscar(scroll = false) {
                this.loading = true;
                const params = new URLSearchParams();
                params.set("hito", this.path.hito);
                params.set("sub1", this.path.sub1);
                params.set("sub2", this.path.sub2);
                params.set("sub3", this.path.sub3);
                console.log(params, "params donde vendria belleza: ");

                const r = await fetch(this.ep.buscar(params));
                console.log(r);
                this.results = r.ok ? await r.json() : [];
                this.page = 1;
                this.updatePaged();
                this.loading = false;

                if (scroll) {
                    this.$nextTick(() =>
                        window.scrollTo({
                            top: document.body.scrollHeight,
                            behavior: "smooth",
                        })
                    );
                }
            },

            updatePaged() {
                this.pages = Math.max(
                    1,
                    Math.ceil(this.results.length / this.pageSize)
                );
                const start = (this.page - 1) * this.pageSize;
                this.paged = this.results.slice(start, start + this.pageSize);
            },

            // ====== Card helpers ======
            cardClasses(id) {
                const isActive = this.activeId === id,
                    isHover = this.hovered === id;
                return [
                    isActive ? "z-30" : "z-10",
                    "transition-transform transition-opacity duration-300",
                    isActive ? "opacity-100" : "opacity-70 hover:opacity-90",
                    isActive || isHover ? "scale-100" : "scale-90",
                    "max-w-[920px]",
                ].join(" ");
            },
            cardStyle(id, idx) {
                if (!this.activeId) return "";
                const activeIdx = this.items.findIndex(
                    (i) => i.id === this.activeId
                );
                let translateX = "0%",
                    rotate = 0,
                    scale = 1;
                if (id !== this.activeId) {
                    const dir = idx < activeIdx ? -1 : 1;
                    translateX = `${dir * 44}%`;
                    rotate = dir * -4;
                    scale = 0.88;
                }
                return `transform: translateX(${translateX}) rotate(${rotate}deg) scale(${scale}); left:0; right:0; margin-left:auto; margin-right:auto; height:100%;`;
            },
        };
    }
</script>

@endsection
