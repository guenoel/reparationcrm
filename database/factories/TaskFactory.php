<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\Service;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Le nom du modèle associé à cette factory.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Définition de l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->optional()->dateTimeBetween('-1 month', 'now'); // Date de début optionnelle
        $end = $start ? $this->faker->optional()->dateTimeBetween($start, '+1 month') : null; // Date de fin après le début
        
        return [
            'image' => 'no-image.jpg', // Image par défaut
            'service_id' => Service::factory(), // Associe un service existant
            'user_id' => User::factory()->optional()->create()->id, // Associe un utilisateur (nullable)
            'start' => $start,
            'end' => $end,
            'description' => $this->faker->sentence(15), // Génère une description aléatoire
        ];
    }
}
