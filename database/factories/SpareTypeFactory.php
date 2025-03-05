<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SpareType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpareType>
 */
class SpareTypeFactory extends Factory
{
    /**
     * Le nom du modèle associé à cette factory.
     *
     * @var string
     */
    protected $model = SpareType::class;

    /**
     * Définition de l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => 'no-image.jpg', // Valeur par défaut
            'dealer' => $this->faker->company, // Nom du fournisseur
            'type' => $this->faker->word, // Type de pièce détachée
            'brand' => $this->faker->company, // Marque de la pièce
            'description' => $this->faker->optional()->text(200), // Description optionnelle
            'buy_price' => $this->faker->optional()->randomFloat(2, 5, 500), // Prix d'achat aléatoire
            'sell_price' => $this->faker->optional()->randomFloat(2, 10, 1000), // Prix de vente aléatoire
        ];
    }
}
