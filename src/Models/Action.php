<?php

namespace Yormy\ConfirmablesLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = [
        'payload',
        'arguments'
    ];
}
