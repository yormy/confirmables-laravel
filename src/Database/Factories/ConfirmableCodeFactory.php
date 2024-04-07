<?php

declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Yormy\ConfirmablesLaravel\Models\ConfirmableCode;
use Yormy\ConfirmablesLaravel\Services\CodeGenerator;

class ConfirmableCodeFactory extends Factory
{
    protected $model = ConfirmableCode::class;

    public function definition(): array
    {
        $code = new ConfirmableCode();

        return [
            'code' => CodeGenerator::generate(),
            'expires_at' => Carbon::now()->addMinutes(70),
        ];
    }
}
