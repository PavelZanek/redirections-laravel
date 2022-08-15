<?php

namespace PavelZanek\RedirectionsLaravel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PavelZanek\RedirectionsLaravel\Enums\StatusCode;
use PavelZanek\RedirectionsLaravel\Models\Redirect;

class RedirectFactory extends Factory
{
    protected $model = Redirect::class;

    public function definition()
    {
        return [
            'source_url' => $this->faker->url,
            'target_url' => $this->faker->url,
            'status_code' => StatusCode::MovedPermanently->value,
        ];
    }
}