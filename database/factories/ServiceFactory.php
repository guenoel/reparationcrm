<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;
use App\Models\Device;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Le nom du modèle associé à cette factory.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Définition de l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => Device::factory(), // Associe un service à un appareil existant
            'description' => $this->faker->sentence(10), // Génère une description aléatoire
            'accepted' => $this->faker->boolean(80), // 80% de chance d'être accepté
            'deposit' => $this->faker->optional()->randomFloat(2, 10, 100), // Dépôt optionnel entre 10 et 100€
            'deposit_paid' => $this->faker->boolean(50), // 50% de chance d'avoir été payé
            'price' => $this->faker->optional()->randomFloat(2, 50, 500), // Prix optionnel entre 50 et 500€
            'price_paid' => $this->faker->boolean(40), // 40% de chance que le prix soit payé
            'done' => $this->faker->boolean(60), // 60% de chance que le service soit terminé
            'returned' => $this->faker->boolean(70), // 70% de chance que l'appareil soit retourné
        ];
    }
}
