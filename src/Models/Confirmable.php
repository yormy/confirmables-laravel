<?php

namespace Yormy\ConfirmablesLaravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Confirmable extends Model
{
    const STATUS_EMAIL_NEEDED = 'EMAIL_NEEDED';
    const STATUS_PHONE_NEEDED = 'PHONE_NEEDED';
    const STATUS_VERIFIED = 'VERIFIED';
    const STATUS_EXECUTED = 'EXECUTED';

    protected $fillable = [
        'payload',
        'arguments',
        'email_required',
        'phone_required'
    ];

    public function setEmailVerified()
    {
        $this->email_verified_at = Carbon::now();
        $this->save();
    }

    public function setPhoneVerified()
    {
        $this->phone_verified_at = Carbon::now();
        $this->save();
    }

    public function isAllVerified(): bool
    {
        return $this->getNextStep() === static::STATUS_VERIFIED;
    }

    public function isEmailVerified(): bool
    {
        return (bool)$this->email_verified_at;
    }

    public function isPhoneVerified(): bool
    {
        return (bool)$this->phone_verified_at;
    }

    public function getNextStep()
    {
        if($this->email_required && !$this->isEmailVerified()) {
            return static::STATUS_EMAIL_NEEDED;
        } elseif($this->phone_required && !$this->isPhoneVerified()) {
            return static::STATUS_PHONE_NEEDED;
        }

        return static::STATUS_VERIFIED;
    }

    public function execute(): string
    {
        $nextStep = $this->getNextStep();
        if ( $nextStep === static::STATUS_VERIFIED) {
            $this->dispatch();
            return static::STATUS_EXECUTED;
        }

        return $nextStep;
    }

    private function dispatch(): void
    {
        $unserialized = unserialize($this->payload);
        $arguments = unserialize($this->arguments);
        $unserialized->dispatch(...$arguments->toArray());
    }
}
