<?php

namespace Database\Factories;

use App\Models\Maestro;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maestro>
 */
class MaestroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Maestro::class;
    public function definition(): array
    {
         return [
            'nombre' => $this->faker->firstName,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'estado_sistema' => $this->faker->randomElement(['Activo', 'Inactivo']),
            'telefono' => $this->faker->phoneNumber,
            'correo_institucional' => $this->faker->unique()->safeEmail,
            'correo_personal' => $this->faker->unique()->safeEmail,
            'calle' => $this->faker->streetAddress,
            'codigo_postal' => $this->faker->postcode,
            'ciudad' => $this->faker->city,
            'estado' => $this->faker->state,
            'avatar' => 'default.png',
            'inicio_contrato' => $this->faker->date,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
