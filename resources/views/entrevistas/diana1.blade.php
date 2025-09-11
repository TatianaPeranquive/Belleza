@extends('layouts.app')

@section('title', $nombre . ' - Entrevista')

@section('content')
<nav class="fixed top-20 left-4 z-40 bg-black px-4 py-2 rounded">
    <a href="{{ route('entrevistas.index') }}" class="text-white font-bold text-lg hover:underline">&larr; Volver</a>
</nav>


<section class="pt-28 px-6 fade-in text-white bg-black">

    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-5xl font-bold mb-6">{{ $nombre }}</h1>
      <img src="{{ asset('Diana_foto.png') }}"
     alt="Entrevista"
     class="rounded shadow-lg max-w-full mb-8 w-[500px] h-auto mx-auto" />

<p class="text-xl max-w-2xl mb-12"></p>
<strong>Angelica:</strong> Recuerda que aquí el audio es lo único que va a quedar, ¿listo? El video no,
entonces para que no te preocupes. Listo, entonces, ya que comenzamos con la
gracia, la idea con la que estoy comenzando estos ejercicios es primero hacer un
ejercicio de conectar la memoria con el cuerpo. Entonces, va a ser algo muy sencillo y
la idea es que me cuentes un poquito si de pequeña tú hacías o experimentabas de
alguna manera con tu cabello, con la moda, con el maquillaje, ¿o alguna de esas
cosas?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Pues digamos que mi época fue de culturas suburbanas. Entonces, yo estuve
en la época del neo, el hardcore, el punk, estuve muy permeada de eso. Entonces la
pinta, la tabla de skate, entonces es la época en la que más recuerdo esa interacción.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Y tienes alguna, perdón, alguna historia, algún experimento que hayas
hecho tú que te gustaría contar? Por ejemplo, no sé, ¿te rapaste el cabello tú misma o
alguna experimentación con maquillaje, con tintura?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> A ver, una que me haya hecho yo misma, pues esto ya de hecho es curioso,
porque cuando yo estaba en el colegio, en la primaria, yo era mucho de echarme gel en
el cabello, como tener escarchita, de esos geles que también te echabas en la cara y
como que tenías escarchita y esto. Yo hacía mucho eso y era muy vanidosa, teníamos
con una amiga como una cajita de esmaltes. Bueno, yo estudiaba en un colegio
femenino, de monjas. Y mira que cuando te cuento esto del neo es como un cambio así
total porque era supremamente femenina en el colegio y ya cuando estoy finalizando el
colegio empiezo a ser, pues yo digo, como un niño total porque no me gustaban las
faldas, era más de bermudas, de zapatos anchos, el cabello me lo corté supercorto.
Entonces sí, yo diría que de lo que me haya hecho en el cuerpo cuando era chiquita, lo
que más recuerdo es como echarme gel. Tal vez maquillarme es algo que no, pero sí.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Entonces, trabajemos con esa de echarte gel. La idea del ejercicio es que vas
a cerrar tus ojos y vas a transportarte como a ese momento en que tú te echabas ese
gel. Y la idea es que sientas como tus manos cogían el producto, como se
embadurnaba el pelo, como se sentía el pelo cuando estaba seco, todo ese proceso,
trata de recordarlo por unos pocos segundos. Entonces, ya puedes abrir los ojos. La
idea con este ejercicio es que durante la entrevista recuerdes así, ¿no?, cómo esas
acciones que tu cuerpo hacía casi involuntariamente por la costumbre se conectan
con las historias que me estás contando. Porque nada de esto fue ajeno, ¿no? Todo
esto lo vivió tu cuerpo y también lo vivió tu mente. Entonces, queremos conectar
ambas cosas, ¿listo?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Listo.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Entonces vamos a comenzar con un poquito de contexto para que me
cuentes un poco de ti, tu historia, sobre todo momentos que marcaron tu vida, cómo
creciste tú, dónde creciste, sobre todo, cuál fue la relación con tu familia, tu educación
y tu ingreso a la vida laboral.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Bueno, yo nací en la ciudad de Bogotá, Sin embargo,pues mi, mi infancia, mi
primera infancia fue más con mi abuela , paterna. Ella es oriunda de Villarrica, Tolima.
Ella junto con mi abuelo, que ya había fallecido para ese momento, tenían una casa en
Guayaquil, Tolima, que eso queda cerca de Natagaima. Y pues ahí y es como lo que yo
más recuerdo como esa primera parte, esto es como un caserío indígena muy
pequeño, muy pequeño y pues mi abuela cumple el 16 de julio, yo cumplo el 18 de
julio, entonces esa fecha casi siempre la pasábamos allí. Eso es como mi primera
parte.
Luego regreso a Bogotá, termino mi colegio y empiezo a buscar qué hacer y pues,
empiezo a estudiar ingeniería multimedia. Eso es lo primero que yo estudio. Cuando
salgo del colegio, yo estaba haciendo como un curso en el Sena y era buena para eso.
Entonces empiezo a estudiar en la Militar, pero ahí duro solo un año y entro como en
"No, yo no quiero ser ingeniera". Ahí tenía tal vez como 16 años y entonces por
cuestiones del destino llego a la Antropología y es a lo que me dedico. Esto parte como
de una búsqueda, por mis papás me meten en orientación profesional y todo el cuento.
Y yo ya identifico qué es la Antropología como a lo que quiero llegar y eso es en lo que
me desempeño actualmente. Yo trabajo con pueblos indígenas en la Amazonía
colombiana. Ya hace más de tal vez 12 años, probablemente, sí, en el 2011, y como 12
años. y sí, eso es como lo que hago, no sé si... Sí, sí, sí, es el contexto.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Ahorita tú estás viviendo en la Amazonía.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí, yo vivo en Florencia, Caquetá.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Entonces, vamos a hablar un poquito de tu rutina diaria de higiene, ¿listo?
Hay dos maneras de comenzar este ejercicio. Me puedes comentar lo que estás
haciendo ahorita tú, por ejemplo, desde que tú te levantas, ¿qué hábitos tú tienes en
términos de higiene? por ejemplo, limpieza, lavado de cabello, protector solar, todo
ello. o podemos empezar desde el pasado. No sé cuál sea más fácil para ti.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> ¿Desde el pasado?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Sí, me refiero a qué cosas hacías de niña, qué rutinas tenías tú, cómo te
empezaste a vestir, ese tipo de cosas, cómo fue la transformación. Es que hay
personas que les resulta más fácil hablar desde ahorita irse para atrás, ir a mirar cómo
ha cambiado o hay otras personas que les vale más fácil empezar desde "no, de
chiquita mi mamá me hacía hacer esto, esto, esto y yo agarré por este lado". ¿Cómo
prefieres tú contarme?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> De la rutina diaria de cómo se transforma. Sí, yo prefiero comenzar por el
pasado, la verdad. Listo, entonces lo que yo recuerdo era que mi papá me levantaba
súper temprano y siempre fue la persona como que me despertó y con él era como la
rutina de aseo, en realidad porque mi mamá estaba en la cocina haciendo como
preparándonos el desayuno. Todo era muy como muy organizadito, ¿no? Como todo
muy limpio, el uniforme, todo así muy muy bien peinada, tal como la moñita y la cosa.
Solo me bañé una vez al día. No era como que llegara yo nuevamente del colegio y me
fuera a tomar otro baño. No, eso no lo hacía.
Lo que pasa con estas como cuestiones de yo desde muy chiquita tuve una alergia que
era dermatitis. Entonces, yo era muy poco, o sea, mis jabones tenían que ser jabones
sin químicos o productos porque eso podía ser alergénico para mi piel, como que mi
piel era muy muy delicada, me quemaba con todo. Entonces, mi mamá claramente
también me embadurnaba de muchísimo bloqueador. Entonces, el bloqueador
siempre ha sido algo como que he tenido ahí intensamente y pues por esta cuestión de
la piel muy pocas cremas, en realidad, solo el bloqueador.
Ya luego, cuando llego a esta parte que te cuento del esmalte y del gel, como que en
ese momento yo estoy rodeada, pues claro, es un colegio femenino, entonces como
que todo este concepto de la feminidad aludía también a ser, como pienso yo, como
vanidosa. A mí me decían y mis amigas me dicen mucho que cuando yo era así chiquita
era muy vanidosa como por el peinado. Entonces como que en las mañanas cuando yo
me alistaba para ir al colegio yo soy y esto es algo que suelo hacer desde muy
pequeña, siempre he usado como colas altas o este tipo de recogidos, pero a mí algo
que me que me aún, de hecho, que me salgan estos pelitos hacia los lados, es algo que
no me gusta y por eso yo empecé a usar el gel. Esa era como la rutina en el día, en la
mañana para ir antes del colegio. La cuestión de las uñas, por ejemplo, también es algo
que desde muy pequeñita he tenido, entonces como que era un plan que hacía yo con
mi mamá o incluso que le pedí a mi mamá que me pintara las uñas y estas cosas.
Ya luego cuando llego como a la secundaria, al bachillerato y empiezo a conocer como
todo este mundo del rock y esto ya mi dinámica cambia en la medida en que me
descuido, ya no era el gel, ya no era el cabello así, sino que de una me lo corté, casi no
me lo lavaba y ya digamos ni esmalte y como que asumí un look muy como muy de
chico, o sea, yo me vestía como un chico con capota, usaba mucho tiempo, me
gustaban mucho las capotas en ese tiempo, entonces hacía como eso.
Pero si algo que creo me falta importante también, es que desde pequeñita el aroma
es algo que debo tener y casualmente a mí me llama mucho la atención los aromas de
los hombres, de la de las lociones de hombres. Entonces, yo desde muy pequeña me
aplico lociones de hombres. Eso es algo que hago hasta ahora. Entonces, como que
eso también hacía parte de mi rutina en el colegio y en el bachillerato igual.
Ya cuando llegó a la universidad, yo estudie en la Nacional. Cuando llego a
Antropología, vuelvo a tener, tal vez por la Militar, no lo sé, ahora me he puesto a
pensar en eso en estos días, como en qué momento hice nuevamente esa transición
de tener ese look medio punkerito a otra vez volver al femenino que tenía en el colegio.
Entonces era muy como también como de faldas, empiezo a usar faldas, empiezo a
cuidar más, a dejar crecer mi cabello.
Tal vez sí, como a... en realidad, maquillarme es algo que no he intentado, no como
sombras y esas cosas, nada de eso. Como que mi maquillaje en mis mañanas es el
bloqueador. Y luego yo empecé a molestar con la pestañina que es transparente. Y ya.
Eso es algo que empecé a hacer un poco más en la universidad. No soy de rutinas y eso
sí nunca lo he tenido de tener alguna rutina para mi rostro o cosas así, no. La alergia
desapareció, pero de igual manera no soy de echarme cremas así, no sé, eso no lo
suelo hacer. De hecho, en alguna ocasión sí lo intenté: en la universidad, empecé a
intentar tener como rutinas de skincare, que llaman, con agua de rosas y no sé qué
cosas. Cuando yo me apliqué eso en la cara la primera vez, reaccionó una alergia así
terrible. Entonces fue como nada y desde ahí desistí de llevar cualquier rutina de
skincare o esas cosas, no la logré.
Hay algo que pasa conmigo en ese momento y es que yo soy una persona muy velluda.
y entonces, en la universidad, yo utilizaba faldas y esto. Entonces, empiezo a tener la
rutina también de afeitarme las piernas, que son super velludas. Entonces era algo
como que me incomodaba muchísimo, no me sentía cómoda con mis vellitos.
Entonces, ahí empiezo a integrar eso dentro de mi rutina como de cuidado.
Creo que trayéndonos ya más hacia el campo laboral, mi rutina ha estado enfocada
muchísimo en mi cabello. Es algo como de lo que cuido muchísimo ahorita en este
momento, no sé, tal vez será por la región, por la humedad. Ya utilizo cremas para el
cabello, tratamientos, me hago polarizaciones, me empecé a hacer queratina, pero eso
solo desde el momento en el que empecé a vivir en la Amazonía, y eso fue hace cuatro
o cinco años; estamos en el 2025. Entonces hace cinco años empiezo como con esta
práctica ya un poco más cotidiana de cuidar muchísimo de mi cabello. Eso sí es algo
que he integrado ya mucho y este tema con las piernas sigue siendo algo que hace
parte como de mi cuidado en esa cotidianidad, pero ya lo que hago no es rasurarme,
sino que tengo esta rutina de cada semana hacerme con la máquina láser. y aplicarme
cremas que son exfoliantes, la piedra pómez y la crema de coco. Como eso sobre todo
con mis piernas, es algo que tengo también muy integrado en este momento, en este
momento aquí en desde que empiezo a vivir en la Amazonía. Pensaría que eso es como
lo que suelo hacer.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Un par de preguntas sobre ello, ¿por qué empiezas a tratar tu cabello cuando
llegas a la Amazonía?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Porque la humedad es algo que me empieza a incomodar un poco, por lo que te
digo que a mí no me gusta tener estos pelitos como a los lados y con la humedad del
cabello. De hecho, una de las razones por las que yo me rapo este lado es porque
cuando yo tenía ya todo el cabello era un leoncito, o sea, yo me sentía así como que era
un leoncito. Entonces, yo decía: "No, pues si me rapo un lado, soy leoncito de un solo
lado". Por esa razón, en realidad, es que yo me rapo ese lado para no serlo. Entonces,
la queratina y estas polarizaciones y estas cosas vienen precisamente para que esos
pelitos se bajen, porque me molestaba, me sentía... como que me miraba al espejo y
no [me gustaba]. Entonces, por eso es que empiezo yo con esa rutina de cuidar el pelo
y porque cuando empiezas con todas esas cosas, tienes que hacer miles de
tratamientos, de cosas.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Y cuéntame un poquito, por ejemplo, en la ropa, ¿cómo ha cambiado tu
relación con la moda o con el vestir a lo largo de tu vida?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Yo no soy tanto como de seguir marcas, sino más de lo que me está
influenciando en mi entorno. Como yo estaba en este colegio femenino de monjas y
pues todavía muy cuidada por mi mamá, vestida por mi mamá. Todo así muy, sí, muy
cuadrito, muy bonita. En la preadolescencia, entro en este mundo del punk rock, del
neo y de los toques, ver a las personas así con sus looks me parecía hermoso. Me
encantaban las calaveras rosadas, mi ropa era toda negra, claramente, y el peinado
con el cosito acá, el mechón aquí... yo era esa. Entonces, veía eso y me parecía muy
bonito.
Luego, cuando llego a la universidad, retorna un poco a esa onda girly, como femenina.
Pero hay un quiebre y eso me lo dicen muchas personas. Durante mi formación viajé un
año a la India, y ese año en el que yo viví allí, cuando regresé, como que traje mucho de
la manera en la que tenía que vestirme, porque en la India tienes que vestirte de cierta
manera: tapar tus codos, tapar algunas partes acá del pecho... cambia la forma de
vestir muchísimo. Y a mí me gustó mucho, entonces yo como que me traigo ese estilo
de la India y asumo un look, me dicen, muy hippie. Desde ese momento hacia acá
siento que ya mi ropa es un poco más... a mí me gusta sentirme relajada, no me gusta
sentirme apretada.
En la universidad y eso sí lo tuve mucho tiempo, monté mucho bicicleta, entonces es
estar muy cómoda, porque yo sudo muchísimo, entonces es estar fresca, que si sudo,
la ropa no me vaya a oler mal. Entonces, lo que empecé a buscar era que la ropa se
ajustara a la actividad que estaba haciendo. En ese caso, que duré mucho tiempo
montando bicicleta, pues era para la bicicleta. O sea, yo me vestía para la bicicleta,
para estar cómoda en la bicicleta. Y ahorita ya que estoy acá en el Amazonas es más
por el calor, o sea, yo no me voy a poner jean ni loca, o sea, es como... Entonces, busco
ropa que se adapte a este clima cálido, húmedo y en eso se basa mi influencia.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Y tú tuviste algún tratamiento ondontológico, por ejemplo?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> A mí me... lo único que me hicieron fue sacarme las cordales. Pero que haya
tenido brackets o algo... no.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Listo, súper. Muy de la mano de lo que me estabas hablando del vestir y de tu
vida en relación con la vestimenta, me gustaría preguntarte como qué, qué influencia
tuviste a la hora de aprender a tal vez arreglarte, a cuidar tu cuerpo, a cuidar tu rostro o
alguna rutina de ejercicios. Entonces, por ejemplo, puedes pensar en algunas personas
como amigas, las madres o algún medio o banda. Me gustaría usar tus influencias de
rock que quieras destacar.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Bueno, con las cosas del cabello y del rostro, mi abuela. Mi abuela era una
persona que, por ejemplo, cuidaba muchísimo su cabello. Entonces, ella siempre
hacía menjurjes con aguacate, aceite de coco, o sea, todo con plantas que para el
brillo y la fortaleza y todo esto. Entonces, ella es como una de mis influencias como
para el cabello y mi mamá yo la veía desde muy pequeña que ya cuando llegaba del
trabajo tenía como toda una rutina para quitarse el maquillaje. Ella sí era de pestañina
y de delineador y todo eso, y yo me quedaba mirándola. Pero era algo que a mí no me
llamaba la atención. O sea, yo se lo veía a ella, pero a mí no me llamaba la atención
hacerme con el lápiz o eso; yo no fui así. Pero sí, más con mi gel y no tanto de
maquillarme los ojos. Entonces ellas dos son como las primeras.
La cuestión con el olor que te digo, yo creo que es una influencia de mi padre, que mi
padre también era algo que hacíamos, íbamos a comprar perfumes juntos, pues
porque a mí me gustaban los de hombre. Entonces, eso era algo que hacíamos. Él
influyó mucho en el aroma, en oler rico; eso es algo que a mí estéticamente me parece
importante, y él es uno de esos referentes.
Yo siento que la India también por un lugar que me influenció mucho estéticamente
hablando con el con el vestido, no podría hablar como de una persona en específico
porque vi tantas cosas que no sé, siento que es más como el país y como la cultura de
ese lugar que me influenciaron mucho en la manera de vestir. ¿y qué otra influencia he
tenido yo así que yo recuerde importante?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿De tu época de punk o de rock? ¿Alguien en el vestido?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí, claro, en el vestido, sí, claro. Hay algo que me pasa en esa época y es como
que yo miraba a los chicos y me gustaba como ellos se vestían. Por eso yo buscaba las
bermudas, porque digamos las chicas, mis amigas, ellas se ponían faldas o se ponían
blusas amplias o escotadas, y yo no. Yo iba con buzo, con capota y con bermudas,
porque me gustaba, me parecía chévere, muy cómodo. No sé, a mí siempre me ha
gustado la comodidad y yo veía que los chicos estaban tan cómodos que yo decía:
"Pues yo también quiero sentirme así".
De hecho, en el colegio, detestaba ponerme jardinera y que la falda estuviera arriba de
las rodillas, y todo eso que hacían mis amigas me parecía que no lo quería. Siempre iba
en sudadera. Siempre iba en sudadera con mi buzo y mi capota y esto. Entonces, sí,
como tal vez los chicos de esa época eran como mi influencia en ese momento.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Muy conectado lo que me acabas de responder, me gustaría saber de qué
manera utilizaste tu apariencia para representar lo que tú pensabas. ¿Podrías
compartirme tal vez alguna experiencia?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí, yo creo que la adolescencia total como esta manera de decir como no, la
chica no es de rosadito y del cabello no sé cómo, como que iba muy en contra de eso y
creo que mi manera de vestir manifestaba precisamente eso. Mis amigas en el colegio
me decían que yo parecía un niño, porque nunca me ponía la jardinera y detestaba la
falda, y yo decía: "Hace frío", o sea, para mí hace frío. Yo no quería utilizar eso, y estar
formada a las 6:30 de la mañana en el colegio me incomodaba muchísimo. Entonces,
sí, yo creo que la adolescencia fue el momento en que más lo manifesté.
Yo siento que también las primeras perforaciones que me hice en esa época (lo
primero que me hice fue un septum, luego las expansiones) eran para romper ese
esquema, porque eran muy pocas las chicas que utilizaban expansiones en ese
momento. Eso se les veía más a los chicos, o por lo menos en mi entorno era así.
Entonces, sí, me gustaba en ese momento romper ese molde de que las chicas no
debían ser tan rosaditas. No sé, no sé, como que no me tramaba en ese momento. Y
esa fue la manera en la que lo expresé. Pero no, con maquillaje, eso sí no, maquillaje
no.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Algún otro momento en tu vida que te sintieras así o dirías que ese fue el
momento de expresión?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Yo creo que ese fue el momento estelar. Bueno, en este momento no sé si tal
vez el tema de los tatuajes puede ser algo, pues esto me lo insiste muchísimo mi mamá
porque ella es muy de decir: "No, te vas a tatuar y tu trabajo y el campo laboral y esto".
Entonces, es una manera también para decir que la manera en la que yo funcione o
altere mi cuerpo no tiene que afectar dinámicas laborales, personales, familiares,
porque sigo siendo Diana María, solo que rayada o perforada o sí.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Me podrías contar un poquito de esas transformaciones corporales que has
tenido a lo largo de tu vida?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí, yo a los 14 más o menos fue cuando me hice el septum. Luego del septum, al
muy poco tiempo, me hice las expansiones y como al año me hice mi primer tatuaje.
Desde que comencé con ese primer tatuaje, yo comencé pensando en los tatuajes
como una manera de exteriorizar cosas que simbólicamente son importantes en mi
vida. Entonces, el primer tatuaje que yo me hice fue la firma de mi papá y en ese
momento yo lo que pensaba era como "yo soy carne de mi mamá". Mi papá es una
persona morena, pelinegra. Como que algunas personas se la montaron mucho
cuando yo era bebé porque decían que no se parecía a mí, que yo era la hija del lechero
y toda la cosa. Entonces, como que decía: "Si me hago la firma es porque digo él es mi
papá". O sea, como esta mujer, como que también tiene el autógrafo ahí del otro que la
hizo. Entonces, por eso, me hice mi primer tatuaje y los tatuajes que me he hecho
hasta el momento han sido por momentos simbólicos que quiero como guardar en mi
piel. Y eso es lo que he hecho con los tatuajes hasta ahora.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Tratemos de volver cuando tenías 18 años. Ahí estabas ya estudiando
Antropología, si no estoy mal, ¿cierto?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí, con los 18 yo estaba estudiante antropología
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Cuéntame en ese momento cómo entendías y definías el concepto de
belleza y si tú te considerabas bella.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí, a los 18 yo estaba más o menos como en cuarto semestre de la universidad y
estaba en ese momento girly nuevamente, como ya había dejado las bermudas y los
zapatos anchos y ahora me ponía botas y como que estaba un poco más pendiente de
la ropa, que combinara. Esto es algo que me cuesta a mí muchísimo y eso me pasó a
los 18 años, y es que yo suelo ser un arcoíris, o sea, yo no sé combinar rojo con morado
y verde, o sea, yo me visto de muchos colores, pero en ese momento, como era
consciente de que me gustaba vestirme como un arcoíris, era como "no vistas como un
arcoíris, combina que la camiseta sea neutra con el pantalón". Y en ese momento,
entonces, empecé a pensar mucho de esa manera.
También dejé crecer mi cabello, porque de cierta manera cuando estaba en esta época
roquerita, la razón por la que yo me cortaba el cabello cortito era por practicidad
también. Pero entonces ya en ese momento digo: "Como no, ya vamos a dejarlo crecer,
como a parecer más femenino". En ese momento yo pensaba como ser más femenina
es tener el cabello largo, vestirme que combinen los colores y cero maquillaje, esto sí
fue algo que no hice. Sí, podría decir que eso fue lo que pasó a los 18.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Y me podrías explicar cómo entendías y definías el concepto de belleza,
verdad?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Ahí pasan dos cosas, una de la que te digo, de lo que te acabo de contar, o sea,
para mí eso era como una de las influencias del concepto de belleza, ser más femenina
en ese sentido. Pero también como que busco mucho esto de la belleza espiritual.
Entonces, como que veo, digamos, la belleza en los términos de "le brillan los ojos,
irradia cierta energía", eso en ese momento lo estaba explorando muchísimo y pues es
algo que me ha llamado como ya hace mucho tiempo. Entonces, como que esos dos
contrastes yo decía: "Bueno, se vestiría entre comillas mal, pero irradia un algo muy
bonito". O sea, eso me parecía muy bello. Entonces, como que esos contrastes me
parecían curiosos y yo decía: "Los peores arreglados son los más bellos", pensaba yo
en ese momento o era como algo con lo que yo dialogaba ahí en ese tiempo.
Claramente, como también siento que la Nacho es algo muy intelectual, entonces
como que esa cuestión de hablar como de la carrera, desde la teoría, era algo que me
parecía superbello o pues atractivo en ese sentido y como que me hacía reconocer la
belleza en esa persona.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Y te consideras bonita?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí, sí. Yo siento que sí, sí me considero.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Súper. Cuéntame un poquito cómo los discursos, por ejemplo, de medios
como la televisión, el cine, los reinados y a ti te aplican redes sociales, han
cambiado tu percepción de lo que consideras bello, en qué reflexiones piensas al
respecto.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Es un video, sí, porque pues uno es lo que consume, ¿no? Entonces, siento que
la televisión fue algo que me acompañó mucho en mi niñez y siento que influyó, por
ejemplo, el hecho de lo de mis piernas. Que pues allí salían chicas así sin un pelo. Yo
decía: "¿Por qué ellas no tienen un pelo y yo estoy tan llena de pelo?". Entonces, como
que yo veía eso en la televisión y como que me hacía sentir insegura, claramente. O
como de que "¿por qué yo no era así?". Las portadas de los cuadernos con estas
modelos, te cuento que a pesar de estar en un colegio femenino, fue algo que me
rondó mucho.
Yo casi siempre, no sé por qué, esto es algo que yo sigo preguntando por mi psicólogo y
demás. Estuve rodeada de hombres y hasta el momento en el campo laboral en que
me desempeño estoy rodeada de puros indígenas hombres. Entonces, esas presiones
de que los chicos, "Ay, este es mi cuaderno y que no sé qué", y son todas estas
modelos así, yo era como, "Wow".
Luego yo en el colegio a mí me operan de apendicitis y peritonitis, y tener esas
cicatrices,pues es algo que también en el medio, incluso mis amigas cuando nos
íbamos de viaje con las monjitas a las salidas y esto era algo que me hacía como
sentirme insegura porque no lo veía, o sea, en las películas no lo veía, en las novelas no
veía que la gente tuviera cicatrices como las mías. Entonces eso me hacía sentir
insegura igual, como que no era algo como hoy que yo me pudiera poner un... y de
hecho hasta el momento no lo hago, que me ponga vestidos de baño de dos piezas,
porque esa presión de como de que uno no mira esa cicatriz en otros lados, como que
genera eso, ¿no? Entonces, siento que esa cuestión con el cuerpo me generaba eso,
las películas y los programas de televisión, los cuadernos y más.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Los reinados nacionales tuvieron algún impacto? ¿Los reinados de belleza
para ti o no?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Pues fíjate que no fue algo como que viera, hay algo que pasa con mi mamá y es
que a ella le encanta, entonces ella me grita: "Ay, Dianita, mira que salió no sé quién". Y
yo era como... como que no. No, no, no me llamaba mucho la atención, la verdad.
Entonces ya luego me decía: "Ay, ven y me acompañas un rato y miramos". Entonces
como que yo iba y miraba con ella. Pero no, como que no sentía que me: "Ay, como yo
quiero ser así". No. No mucho.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> De esos, por ejemplo, esos medios,perdón, la televisión que me comentabas
ahorita que tú decías: "Yo no veo a nadie que se parezca mucho a él". O bueno, que
tenga estas características. ¿Como qué tipo de programas veías o qué tipo de cosas
consumías?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> En el colegio yo veía mucho Señal Colombia y ellos tenían como una franja que
era primero un programa que era de ciencia, luego venía otro que era Saúmafu, que era
como de biología y luego eso daba al del Conciertazo, que era como música clásica y
yo eso era algo que veía mucho, o sea, casi todos los días, casi todos los días.
Ya luego en la adolescencia cuando empiezo en mi época rockera, me la pasaba bien,
todo era al 13 y Play TV, creo que era, no me acuerdo, sí, creo que era Play TV. Sí, sí. O
eran dos canales como que ponían como pura música así como rock y eso me parecía
muy chévere. Eso lo veía.
Luego empiezo a ver como cosas de realities porque ya sale como MTV y en MTV pasan
como resto de realitys, de varias cosas, Jackass, yo empiezo a ver como programas de
MTV mucho, realitys así como de amor y esas cosas. Entonces, como que yo veía esos
realitys también en esa época.
Ya cuando yo llegué a la universidad dejé de ver televisión. Entonces yo era solo
películas y pues allá en las chazas de... Era muy chévere, de hecho, eso me encantaba
porque en las chazas tú intercambiabas películas y eran puras películas de séptimo
arte y como alternativas y esas cosas. Entonces, empiezo a consumir ahora es
películas de esas. Y ya aquí en la Amazonía volví a la televisión, pero volví a la televisión
de Netflix y como bueno, todas estas plataformas y algo que veo mucho es realitys de
experimentos sociales. Entonces, como cosas del Juego del Calamar o cosas de amor
también o cosas de juegos mentales y esas cosas.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Interesante, reality shows. Okay. Cuéntame un poquito cuando te menciono
nociones como belleza natural y cuerpo normal, ¿qué imágenes vienen a tu mente?
¿Cómo lo definirías?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Ese de la belleza natural, tal, me pareció como superbonito,porque es tal vez
lo que te decía que me preguntaba mucho a mis 18 cuando veía como esos contrastes.
porque es como, sí, como yo, yo sentiría que la belleza natural es como el alma
desnuda, o sea, como que uno puede ver como la... o sea, como que tú miras a una
persona y más allá como sea la expresión de su cara o sus ojos o tal, es como la
manera en la que se expresa, la manera en la que tiene de mover su cuerpo y de
expresar y de ser cálida. Como que eso me parece una belleza natural, pero es más
como de la forma de ser que la forma de verse. El cuerpo normal... el cuerpo normal,
yo decía: "Pues normal".
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Qué imagenes se te viene cuando piensas en eso de cuerpo normal?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Pues digamos que lo primero que pienso es que tenga los cinco dedos, o sea,
que tenga como todas sus partes completas, que tenga sus dos ojos, que tenga como
que sea usualmente lo que solemos ver en la estructura de nuestro cuerpo, que no le
falte una mano, que no o que no tenga una displasia o en eso pienso cuando digo
cuerpo normal es como, pues que está completo y no sé, pues físicamente hablando.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Cuéntame un poquito si consideras, perdón, si consideras que la belleza es
algo que se puede controlar, transformar y redefinir.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Es algo que se puede controlar, sí, total. Siento que y esto es algo que me gusta
mucho como de las lenguas. Eso es algo que me llama antropológicamente mucho la
atención porque pues tú en español puedes decir belleza, pero en una lengua indígena
puede ser otra palabra, que eso pasa mucho con las lenguas indígenas, que diga como
"ser de luz" o qué sé yo, ¿si me entiendes? O sea, que la interpretación que tú hagas en
español sea mucho más, mucho más... no, sino diferente a la que solemos tener de
belleza y en ese sentido siento que en nuestra sociedad el concepto de belleza está
demasiado como impuesto.
Entonces, ahorita tú miras el Met Gala que creo que fue ahorita lo último que pasó y ahí
hay un concepto de belleza así muy marcado, o sea, que se controla, o sea, lo que
salga ahí es lo que va a poner la tendencia no sé cuántos meses de la belleza y
pensaría en ese sentido que sí se puede controlar.
La siguiente era transformar. Sí, total. Y siento que en eso se basa completamente la
diversidad de pensamientos que tengamos y aquí cuando te digo lo de las lenguas es lo
que más me llama la atención porque, o sea, una palabra tiene una historia inmensa
detrás de sí y una simbología. Aquí hay una interpretación de lo que te rodea. Eso es la
lengua en realidad, como la expresión de lo que tú interpretas, de lo que vives.
Entonces, en ese sentido, esa diversidad de maneras de interpretarla permite que se
transforme, o pues de que nosotros seamos conscientes de que se puede transformar.
Ahorita tú miras, eso me encanta de las redes sociales y yo sigo muchísimo las redes
de los indígenas. Han impuesto su concepto de belleza desde su identidad y se ha
transformado, pues porque históricamente "indios patirrajados, morenos, no sé qué",
o sea, también como una emigración. Entonces, se transforma ese concepto de ellos,
que me parece interesante. ¿Y el siguiente cuál era? Redefinir. Que se pueda redefinir.
Pues en la misma medida en la que se transforma se redefine.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Cómo has vivido tú y reflexionado sobre los estándares de belleza? O sea,
¿qué tanto has cedido, qué tanto te has opuesto, podríamos decirlo así? ¿Qué tanto he
cedido como a los estándares, pero también como has reflexionado sobre ellos?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Eso es algo que hablo mucho con mis amigas, o sea, sí es algo que hablo
mucho con mis amigas, pues en realidad mi círculo de amigas es las chicas del
colegio, con ellas son con las que más cercanas soy y hablamos mucho sobre esto
porque nos hemos dado cuenta y hablamos mucho de cómo nuestros cuerpos se han
transformado y porque pues como nos conocemos de tanto tiempo atrás entonces
hablamos del bótox, hablamos de ya las jornadas de gimnasio, de estar haciendo
deporte como que sí, en ese sentido yo siento que con ellas con las que más diálogo
en torno a este tema porque también es como la manera como para botar un poco las
inseguridades, entonces también como que algunas nos empezamos a sentir
incómodas porque ya somos más anchas o el tema con mi mejor amiga es la cuestión
de sus arrugas en estas partes y la cosa de meterse bótox que yo digo como, "Carajo,
pero tenemos 30 años". O sea, tampoco estamos tan... pero es algo que como que se
nos... A mí, la verdad, la vejez es algo que me parece atractivo. A mí me gustan las
personas ancianas, no sé por qué.
Entonces, como que no es algo a lo que le temo, como de que mi mamá, mira, por
ejemplo, esto: mi mamá me trajo una crema Pons porque me decía que cuando yo
sonreía ya me salían muchas patas de gallina, entonces que era hora de que yo atacara
esto. Y yo decía como, "Pero ¿por qué?" Como que no, no es algo que me incomode.
Pero si el trabajo también es algo que... si ya tengo estas ojeras, es como "¿Qué puedo
hacer con esto?". Entonces, como que es con ellas con las que hablamos mucho sobre
y de cómo hacemos para no ceder nuestra seguridad frente a esas transformaciones
que tenemos porque siempre estamos inseguras de algo de que no tenemos las
pestañas muy largas, de que no somos con las cejas muy pobladas o de que estamos
muy cachetonas, porque notamos y pues más yo que las veo ya muy ocasionalmente
cuando voy a Bogotá, ellas ven mi cambio y yo veo el de ellas porque no nos vemos tan
seguido.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Interesante. Vamos y de la mano de de esta siguiente pregunta: ¿has
experimentado presiones ya sea internas o externas para modificar o mantener tu
cuerpo?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Interna, sí, sobre todo con mi figura, porque yo soy una persona baja, chiquita,
yo mido 1,50. Siempre he sido como de contextura delgada. Mi mamá también lo ha
sido. Cuando yo volví de la India, yo subí 12 kg, cosa que nunca me había pasado. Pero
yo creo que comí tanto y estaba tan feliz que eso como que yo allá casi no me miraba al
espejo porque no había donde yo vivía, no había espejos. Pero entonces cuando yo
regresé a Colombia y mi mamá estaba superfeliz porque me decía que estaba
supercachetona y yo, claro, me miro al espejo y me siento superincómoda. Entonces
como que ahí empieza una presión hacia mí de como "no", o sea, "¿qué pasó? ¿Por qué
ahora estás así?". Y empiezo yo con esa presión, eso fue algo que me pasó en ese
momento y que creo que hasta ahora, por estar acostumbrada a tener esa contextura
delgada, me siento ajena si tengo una contextura diferente. Porque no, o sea, durante
mi vida no he solido cambiar mucho de que no tengo como de que suba mucho de
peso en un momento y luego baje, sino que casi siempre ha sido de contextura
delgada. Es como que es a lo que estoy acostumbrada y cuando eso se transforma me
genero presión. Y también eso claramente viene de lo externo que me empiezan a
decir: "Uy, ahora tiene más cola, uy, ahora tiene...". Entonces, no, es como que eso me
hace sentir como que me genera presión y digo: "Tengo que cambiar". Yo ahí como
"tengo que cambiar eso". Entonces eso me pasa con esas expresiones de afuera, pero
también internas, o sea, es compartido, en realidad es compartido. Eso con mi
contextura del cuerpo.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿De qué manera crees que el paso del tiempo ha influenciado en esas
expectativas? ¿Crees que han empeorado o mejorado?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Siento que es muy importante. Yo creo que por este plano espiritual también,
como que es la búsqueda. Mi búsqueda siempre ha estado como asociada a la
tranquilidad y esa tranquilidad como traducida a estar bien conmigo misma,
independientemente de las cosas externas que me empiecen a decir como atacar de
cómo me veo, de que si ha cambiado o no y de que eso llegue a afectarme a mí, porque
lo mencionó. Más no hay que yo emane esa tranquilidad de estar bien, que si tengo
canas, que si tengo la pata de gallina, que si tengo la no sé qué, pues es que esa soy y
pues así estoy y estoy bien. O sea, eso no me hace sentir, digamos, incómoda o que
tenga que ponerme otro tipo de ropa o que tenga, ¿si me entiendes? Entonces como
que lo veo no sé, como desde ese lado y eso me lo ha dado el tiempo. Pues o sea, a los
15 años en mi época roquerita eso no se atravesaba, pues tal vez sí en la comodidad
que en ese momento yo decía que sea cómodo y ahorita es más como que me sienta
tranquila conmigo misma.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Ahorita al principio me contabas un poco de que tú hacías ciclismo de
ejercicio, ¿cierto? Cuéntame un poquito cómo ha sido esa relación con el ejercicio,
con el ciclismo, ¿qué te ha traído ese aspecto de tu vida?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Eso sí fue algo supremamente infundado por mi padre. Mi padre es una persona
que le gusta hacer mucho ejercicio. Entonces, desde muy pequeña, él, por ejemplo, yo
subía cada 8 días con él a Monserrate y a superar nuestro récord y toda la cosa.
Entonces era algo que él me inculcó mucho. Siempre fui a hacer como muchos
deportes. Jugué tenis, voleibol, hice patinaje. O sea, en cualquier deporte mis papás
me metían. En el que más duré fue en el tenis cuando estaba en el colegio. Ahí duré
mucho tiempo entrenando tenis y ya cuando ingreso a la universidad pues empiezo a
conocer todo este mundo de las bicis, de llegar a la universidad en bici. Y eso me
parecía genial porque pues yo no había vivido tan lejos de la Nacho, en bici me
demoraba 30 minutos. Entonces, era algo que disfrutaba mucho y que, o sea, es algo
que disfruto mucho, que me gusta hacer. Durante toda la universidad fue montando
bicicleta y la maestría igual. Ya cuando cuando llegué aquí a la región amazónica, pues
como viví en lugares tan pequeñitos, pues ya no eran como viajes en bici de media
hora, sino de 5 minutos. Entonces, como que ya, por ejemplo, manejar bici en
Florencia es un acto suicida. Acá la gente está loca y manejan remal. Entonces, ya lo
dejé de hacer, pero busco... A mí me gusta mucho el Ultimate, fue algo que también
hice mucho, jugar frisbee o sí, hacer algún tipo de... El gimnasio es algo en lo que no
como que no, no sé, como que lo he intentado, pero no me trama, pero también lo he
hecho. Entonces, como que sí, esa actividad física ha estado desde muy pequeñita.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Y qué sientes que te trae esa actividad física para ti? ¿En términos de tu
cuerpo, tu salud mental?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Para la salud es súper importante. Yo siento que hacer alguna actividad física
regula mucho el cuerpo, el funcionamiento del cuerpo, como que uno siente una
vitalidad y ahorita es algo que me hace falta, porque yo tuve un momento de la
universidad y el ciclismo para mí fueron como estar muy saludable, siento que la bici
me daba mucho eso. Ahorita siento que lo he perdido mucho y por eso mi cuerpo está
como medio desequilibrado, yo lo siento como que medio no está funcionando ahí,
pero con trancas y con cosas. Entonces el ejercicio siento que me daba, me permitía
que mi hígado funcionara bien con mi bilis, con mi vaso, o sea, como con el
funcionamiento del cuerpo.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Una curiosidad, ¿por qué fuiste a la India? Porque como lo has mencionado
durante toda la entrevista, entonces me dio mucha curiosidad cuál fue tu propósito del
viaje.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Yo en ese momento estaba haciendo, estaba escribiendo la tesis de pregrado y
en la tesis de pregrado yo estaba hablando de la educación, yo estaba haciéndola
sobre la educación propia indígena y quería hacer un estudio comparativo. En ese
momento ahí en la Nacho salió la convocatoria como de que estaban dando un cupo,
una beca para irse un año a la India. Y yo, "Pues por qué no". No, entonces como que
presenté mi propuesta, toda la cosa y me gané eso, entonces me fui. Y por eso fue que
llegué allá.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Y en qué zona estuviste? ¿En el sur o en el norte?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> En el sur, en Bangalore.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Interesante. Bueno, y otra pregunta que tenía, ¿acabas de mencionar que
hiciste maestría también en antropología?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí. No, la hice en Políticas Públicas.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Okay, okay, súper. Y mi última pregunta para ti sería, ¿cómo describirías cuál
es el estado auténtico del cuerpo? ¿De tu cuerpo en este caso?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> ¿El sentido auténtico?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> El estado, el estado auténtico de tu cuerpo.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> El estado auténtico de mi cuerpo el locomotor, como lo digo, como el que... O
sea, en este momento yo te hablo, pero internamente todo está conectado para que
me permitas hacer esto, ¿me entiendes? O sea, yo siento que eso es como el estado
auténtico, como de que las neuronas, todo nuestro sistema nervioso sanguíneo esté
sincronizado para poder hablarte. Siento que eso es como el estado auténtico.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Y bueno, yo dije que era la última, pero también me ha surgido saber ahorita
hoy cuáles son tus estándares de belleza y cómo defines la belleza tanto propia como
ajena.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Lo que te dije de esto de la energía que emana la persona, como de que me
transmite esa calma y que está bien consigo misma y que sonríe, pero que no es una
sonrisa que esconde, sino que es una sonrisa que siente, como el sentir bonito. Eso
siento que es como algo bello, eso me parece y es por eso te digo como que sí veo
tanto en los ancianos porque como que hay una sabiduría, es la manera en la que se
expresan, en la que hablan, que me parece bella y por eso digo yo que tengo como
esta, yo no sé si es como una filia con la gente mayor, porque veo eso, veo esa belleza,
o sea, es la belleza que me atrae.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Y para ti misma, cuál es el estándar para ti?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> El estándar para mí de belleza es el sentirme bien conmigo misma. Eso es
como ese es como el camino en el que estoy de sentir. Yo lo baso en lo que te digo, el
funcionamiento del cuerpo, o sea, soy bella en la medida en la que estoy en armonía
con el funcionamiento de mi cuerpo.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> ¿Podrías explicar un poquito más eso de estar en armonía? ¿Como en
sentido práctico a qué te refieres?
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Sí, como de que no tenga dolencias en mi espalda, de que no tenga dolencias
en mi cabeza o en mi estómago o que todo eso esté balanceado, o sea que me esté
cuidando como ese cuidado que es algo como que en lo que ando como de tener ese
cuidado de algo, lo que hablaba hace poco era eso, como de maternarme a mí misma
en ese sentido de que también se asocia a lo femenino y que se asocia a la belleza.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Me parece interesante, muy interesante.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Diana:</strong> Entonces, como de de en ese maternarme y en ese cuidarme, ese será mi
estándar para sentirme bella.
</p><p class="text-xl max-w-2xl mb-12"></p><strong>Angelica:</strong> Okay, súper. Bueno, muchas gracias. Eso sería todo por ahora.
        </p>

<br/> <br/> <br/>

        <audio controls class="mb-16 w-full max-w-md mx-auto">
            <source src="/audio/audio1.mp3" type="audio/mpeg">
            Tu navegador no soporta audio embebido.
        </audio>
         <!-- <a href="{{ route('entrevistas.index') }}" class="underline text-blue-600">← Volver a entrevistas</a> -->
    <br/> <br/> <br/>
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
