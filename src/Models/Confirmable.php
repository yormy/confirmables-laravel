<?php

namespace Yormy\ConfirmablesLaravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Yormy\ConfirmablesLaravel\Jobs\BaseActionData;
use Yormy\ConfirmablesLaravel\Jobs\BaseActionJob;
use Yormy\Xid\Models\Traits\Xid;

class Confirmable extends Model
{
    use Xid;

    const STATUS_EMAIL_NEEDED = 'EMAIL_NEEDED';
    const STATUS_PHONE_NEEDED = 'PHONE_NEEDED';
    const STATUS_VERIFIED = 'VERIFIED';
    const STATUS_EXECUTED = 'EXECUTED';

    public function build(
        BaseActionJob $job,
        BaseActionData $data,
        bool $emailRequired = false,
        bool $phoneRequired = false,
    ) {
        $this->payload = serialize($job);
        $this->arguments = serialize($data);
        $this->email_required = $emailRequired;
        $this->phone_required = $phoneRequired;

        $this->save();
    }

    public function findByXid(string $xid): self {
        return $this->where('xid', $xid)->firstOrFail();
    }

    public function emailRequired(): self
    {
        $this->email_required = true;

        return $this;
    }

    public function phoneRequired(): self
    {
        $this->phone_required = true;
        return $this;
    }

    public function setEmailVerified(): void
    {
        $this->email_verified_at = Carbon::now();
        $this->save();
    }

    public function setPhoneVerified(): void
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

            $this->dispatched_at = Carbon::now();
            $this->save();

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
