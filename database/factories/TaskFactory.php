<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $taskPairs = [
            [
                'title' => 'Comprar víveres',
                'description' => 'Leche, pan, huevos, frutas y verduras en el supermercado.'
            ],
            [
                'title' => 'Hacer ejercicio',
                'description' => '30 minutos de cardio y 15 minutos de estiramientos.'
            ],
            [
                'title' => 'Revisar correos',
                'description' => 'Responder mensajes urgentes y organizar la bandeja de entrada.'
            ],
            [
                'title' => 'Estudiar para el examen',
                'description' => 'Repasar capítulos 3 y 4, resolver ejercicios prácticos.'
            ],
            [
                'title' => 'Llamar al cliente',
                'description' => 'Confirmar detalles del proyecto y acordar próxima reunión.'
            ]
        ];

        $selectedTask = fake()->randomElement($taskPairs);

        return [
            'user_id' => $user->id,
            'title' => $selectedTask['title'],
            'description' => $selectedTask['description']
        ];
    }
}
