<?php

namespace Yormy\ConfirmablesLaravel\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Yormy\ConfirmablesLaravel\Models\Confirmable;
use Yormy\ConfirmablesLaravel\Models\ConfirmableCode;
use Yormy\ConfirmablesLaravel\Services\CodeGenerator;

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
