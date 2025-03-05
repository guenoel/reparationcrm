<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Spare;
use App\Models\Service;
use App\Models\Task;
use App\Models\SpareType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Spare>
 */
class SpareFactory extends Factory
{
    /**
     * Le nom du modèle associé à cette factory.
     *
     * @var string
     */
    protected $model = Spare::class;

    /**
     * Définition de l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $purchaseDate = $this->faker->optional()->dateTimeBetween('-1 year', 'now');
        $receptionDate = $purchaseDate ? $this->faker->optional()->dateTimeBetween($purchaseDate, 'now') : null;
        $returnDate = $receptionDate ? $this->faker->optional()->dateTimeBetween($receptionDate, '+6 months') : null;

        return [
            'image' => 'no-image.jpg', // Valeur par défaut
            'service_id' => Service::factory(), // Associe un service existant
            'task_id' => Task::factory()->optional()->create()->id, // Associe une tâche optionnelle
            'spare_type_id' => SpareType::factory()->optional()->create()->id, // Associe un type de pièce optionnel
            'description' => $this->faker->optional()->text(200), // Description optionnelle
            'purchase_date' => $purchaseDate,
            'reception_date' => $receptionDate,
            'return_date' => $returnDate,
        ];
    }
}
