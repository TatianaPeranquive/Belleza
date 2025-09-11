<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PreguntaSeeder extends Seeder {
    public function run() {
        DB::table('preguntas')->insert([
            ['enunciado'=>'Cuénteme un poco sobre los momentos que marcaron su vida, cómo creció, cómo fue la relación con su familia, cómo fue su educación y su ingreso a la vida laboral.'
            ,'orden'=>1],
            ['enunciado'=>'Podría hablarme de su rutina diaria de higiene, desde cuando comenzó, cómo se ha modificado con el tiempo. Por ejemplo, usar maquillaje, pensar en qué vestir, peinarse, tinturarse o realizar algún tratamiento capilar, cuidados de la piel, tratamientos odontológicos.'
            ,'orden'=>2],
            ['enunciado'=>'¿Qué influencias tuvo a la hora de aprender a arreglarse, cuidar su cuerpo (como rutina de ejercicios), moda y cuidado del rostro? ¿Alguna persona como amiga o madre o medio para destacar?'
            ,'orden'=>3],
            ['enunciado'=>'¿Qué influencias tuvo a la hora de aprender a arreglarse, cuidar su cuerpo (como rutina de ejercicios), moda y cuidado del rostro? ¿Alguna persona como amiga o madre o medio para destacar?'
            ,'orden'=>4],
            ['enunciado'=>'¿De qué manera utilizaste  tu apariencia para representar lo que pensaba? Podría compartir alguna experiencia.'
            ,'orden'=>5],
            ['enunciado'=>'Trate de volver a cuando tenía 18 años. En ese momento, ¿cómo entendía y definía el concepto de belleza? ¿Usted se consideraba bella?'
            ,'orden'=>6],
            ['enunciado'=>'¿Qué ha ganado y qué ha perdido con la belleza?'
            ,'orden'=>7],
            ['enunciado'=>'Cuando le menciono nociones como belleza natural y cuerpo normal ¿qué imágenes vienen a su mente? ¿Cómo las definiría?'
            ,'orden'=>8],
            ['enunciado'=>'¿Considera que la belleza es algo que se puede controlar, transformar y redefinir? ¿Cómo ha vivido y reflexionado sobre los estándares de belleza?'
            ,'orden'=>9],
            ['enunciado'=>'¿Ha experimentado presiones, ya sean internas o externas, para modificar o mantener su cuerpo ¿De qué forma cree que el paso del tiempo ha influido en estas expectativas?'
            ,'orden'=>10],
            ['enunciado'=>'¿Cómo describiría cuál es el estado auténtico de su cuerpo?'
            ,'orden'=>11]
        ]);
    }
}
