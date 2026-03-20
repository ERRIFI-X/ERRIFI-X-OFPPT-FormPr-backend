<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        $extensions = ['pdf', 'docx', 'pptx', 'xlsx'];
        $ext = $this->faker->randomElement($extensions);

        return [
            'formation_id' => Formation::inRandomOrder()->first()?->id ?? Formation::factory(),
            'title'        => $this->faker->sentence(4),
            'file'         => 'documents/' . $this->faker->uuid() . '.' . $ext,
            'uploaded_by'  => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
