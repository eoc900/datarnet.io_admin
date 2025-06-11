<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\tituloAcademMaestro;
use App\Models\Maestro;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TituloAcademMaestro>
 */
class TituloAcademMaestroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     protected $model = tituloAcademMaestro::class;
    public function definition(): array
    {
         return [
            'id_maestro' => $this->faker->randomElement(Maestro::select("id")->pluck('id')->toArray()),
            'grado_academico' => $this->faker->randomElement(['bachillerato', 'licenciatura','ingenieria','maestría','doctorado','diplomado']),
            'nombre_titulo' => $this->faker->sentence(3),
            'nombre_universidad' => $this->faker->randomElement(['La Salle', 'Ibero','ITESM','Anahuac','CeCe','CeIr','Ceac',"Del Valle"]),
            'calificacion' => $this->faker->numberBetween(0, 100),
            'pais' => "Mexico",
            'inicio' => $this->faker->dateTimeThisDecade('+5 years'),
            'conclusion' => $this->faker->dateTimeThisCentury('+5 years'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
