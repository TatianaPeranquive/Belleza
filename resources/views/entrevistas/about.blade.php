@extends('layouts.app')

@section('title', $nombre . ' - Tejedoras')

@section('content')
<nav class="fixed top-20 left-4 z-40 bg-[#34113F] px-4 py-2 rounded">
    <a href="{{ route('entrevistas.index') }}" class="text--[#34113F] font-bold text-lg hover:underline">&larr; Volver</a>
</nav>


<section class="pt-28 px-6 fade-in text--[#34113F] bg-[#34113F]">

    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-5xl font-bold mb-6">{{ $nombre }}</h1>
      <img src="{{ asset('Portada8.png') }}"
        alt="Entrevista"
        class="rounded shadow-lg max-w-full mb-8 w-[500px] h-auto mx-auto" />
        <p class="text-xl max-w-2xl mb-12"></p>
        <strong>Espejito, espejito</strong> es un proyecto de humanidades públicas digitales y feminista que utiliza la historia oral y la difracción para preguntar por el papel que ha jugado la belleza en las historias de vida de mujeres colombianas.
        Las categorías que ves en la sección Entramado fueron alimentadas por fuentes académicas y por los temas en común de los relatos de las narradoras. Para crear las categorías me detuve en sus anécdotas sobre la transformación corporal, ya sea la subida o bajada de peso, los cambios asociados a la vejez o las alteraciones temporales y permanentes en su apariencia física, como el uso de maquillaje, tratamientos para el cabello o su forma de vestir. Así pude concluir que la manera en que cuentan estos eventos presenta similitudes cíclicas. Es decir, a lo largo de sus vidas experimentan tres hitos en su relación con el cuerpo y el embellecimiento: el aprendizaje, la resignificación y la respuesta al cuerpo que envejece. Estos tres hitos se entrelazan; no existen cortes tajantes que determinen cuándo termina una etapa y comienza la otra. Más bien, los veo como procesos que transitan y se influyen mutuamente. En los hitos, encontrarás las categorías a las que las narradoras prestaron más atención en cada ciclo, aunque estas afectan toda la vida, siguen el orden de introducción en sus relatos.
        El propósito de este proyecto es abrir una conversación conjunta sobre la belleza para entender el concepto más allá de la superficialidad. Porque, después de verlo y entenderlo, no hay nada en este tema que sea superficial. Mi objetivo es darte a entender que la belleza tiene matices, que no tiene categorías binarias y que, por ello y por su historia, es paradójica. Esto ocurre porque a medida que pasamos por los hitos, aquello que nos dicen sobre la belleza es muy diferente entre sí. Por ejemplo: "tienes que cuidarte, pero tienes que lucir natural"; "no juzgues a nadie por su apariencia, pero ellos te van a juzgar por ella", etc. Con estos dictámenes en la cabeza, muchas de las mujeres toman un camino y una posición que parece firme y tiene que ser coherente para contrarrestar la presión y encontrar paz mental. El objetivo del proyecto no es decirte cómo pensar sobre la belleza, sino que tengas la información para que tomes decisiones, entendiendo cómo este proceso influye en la relación con tu cuerpo y la sociedad. De esta manera podrás interpretar cómo sientes y performas tu feminidad y cómo percibes la legitimidad social.
        Este proyecto fue realizado como proyecto de grado para la Maestría en Humanidades Digitales de la Universidad de los Andes. Se realizó gracias a la participación voluntaria de las mujeres que presentaron sus historias para este proyecto experimental.
        Mi nombre es Angélica, soy historiadora y decidí crear este proyecto como una forma de entender un guisante en mi cama que me incomodaba. Como feminista, nunca supe qué posición tomar con respecto al embellecimiento. Me gusta pintarme las uñas, me gusta saber del mundo de la moda, me gusta el maquillaje, me importa cómo se vea mi cuerpo y aun así sentía que tenía que luchar en contra de todo eso. Ahora, después de este proyecto, pienso que el acto más feminista es entender el contexto en el que estoy, qué privilegios poseo y cuáles son los puntos que estoy dispuesta a negociar y cuáles no. No se trata de llevar una coherencia absoluta; de hecho, creo que al entender los matices y las contradicciones, puedo redefinir cómo performo el embellecimiento y cómo lidio con las capas de historia que tiene la belleza.

</div>
</section>

@push('scripts')
<script>
    gsap.to(".fade-in", {
        opacity: 1,
        y: 0,
        duration: 1,
        ease: "power2.out"
    });
</script>
@endpush
@endsection
