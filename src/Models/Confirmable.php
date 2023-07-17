<?php

namespace Yormy\ConfirmablesLaravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Confirmable extends Model
{
    protected $fillable = [
        'payload',
        'arguments',
        'requires_email'
    ];

    public function setEmailVerified()
    {
        $this->email_verified_at = Carbon::now();
        $this->save();
    }

    public function isVerified()
    {
        return (bool)$this->email_verified_at;
    }

    public function execute(): string
    {
        if ($this->isVerified()) {
            $unserialized = unserialize($this->payload);
            $arguments = unserialize($this->arguments);

            $unserialized->dispatch(...$arguments->toArray());
            return 'ok';
        }

        return 'needs verify';
    }
}
