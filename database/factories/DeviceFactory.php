<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Device;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class DeviceFactory extends Factory
{
        /**
     * Le nom du modèle associé à cette factory.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Génère un utilisateur aléatoire
            'image' => 'no-image.jpg', // Valeur par défaut
            'brand' => $this->faker->company, // Génère une marque fictive
            'model_name' => $this->faker->word, // Nom du modèle
            'model_number' => $this->faker->optional()->regexify('[A-Z0-9]{5,10}'), // Modèle optionnel
            'color' => $this->faker->optional()->safeColorName(), // Couleur optionnelle
            'serial_number' => $this->faker->optional()->uuid(), // Numéro de série aléatoire
            'imei' => $this->faker->optional()->numerify('###############'), // 15 chiffres pour un IMEI fictif
            'description' => $this->faker->optional()->text(200), // Description optionnelle
            'returned' => $this->faker->boolean(20), // 20% de chance d’être retourné
        ];
    }
}
