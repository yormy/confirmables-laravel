<?php

namespace Yormy\ConfirmablesLaravel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Yormy\ConfirmablesLaravel\Models\Confirmable;

class ConfirmableFactory extends Factory
{
    protected $model = Confirmable::class;

    public function definition(): array
    {
        return [
            'payload' => 'ss',
        ];
    }
}
