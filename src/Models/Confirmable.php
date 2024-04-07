<?php

declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yormy\ConfirmablesLaravel\Jobs\BaseActionData;
use Yormy\Xid\Models\Traits\Xid;

class Confirmable extends Model
{
    use SoftDeletes;
    use Xid;

    public const METHOD_EMAIL = 'EMAIL';

    public const METHOD_PHONE = 'PHONE';
    // const METHOD_AUTHENTICATOR = 'AUTHENTICATOR';

    public const STATUS_EMAIL_NEEDED = 'EMAIL_NEEDED';

    public const STATUS_PHONE_NEEDED = 'PHONE_NEEDED';

    public const STATUS_VERIFIED = 'VERIFIED';

    public const STATUS_EXECUTED = 'EXECUTED';

    protected $table = 'confirmable_actions';

    public static function boot(): void
    {
        parent::boot();

        static::deleted(function ($confirmable): void {
            foreach ($confirmable->codes as $code) {
                $code->delete();
            }
        });
    }

    public function build(
        string $jobClass,
        BaseActionData $data,
        bool $emailRequired = false,
        bool $phoneRequired = false,
    ): void {
        $this->payload = $jobClass;
        $this->arguments = json_encode($data);
        $this->email_required = $emailRequired;
        $this->phone_required = $phoneRequired;

        $this->save();
    }

    /**
     * The response that is given when the job execution is finished
     */
    public function successResponse(array $successResponse): void
    {
        $this->success_response = json_encode($successResponse);
    }

    public function getSuccessResponse(): array
    {
        if (! $this->success_response) {
            return [];
        }

        return json_decode($this->success_response, true);
    }

    public function enterCodeResponse(): array
    {
        return [
            'xid' => $this->xid,
            'method' => $this->getCurrentConfirmMethod(),
            'title' => $this->getCurrentConfirmMethodTitle(),
            'description' => $this->getCurrentConfirmMethodDescription(),
        ];
    }

    public function codes(): HasMany
    {
        return $this->hasMany(ConfirmableCode::class);
    }

    public function findByXid(string $xid): self
    {
        return $this->where('xid', $xid)->firstOrFail();
    }

    public function emailRequired(?string $tileKey = null, ?string $descriptionKey = null): self
    {
        $this->email_required = true;
        $this->email_code_title = $tile ?? 'confirmables::action.method.email.title';
        $this->email_code_description = $description ?? 'confirmables::action.method.email.description';

        return $this;
    }

    public function phoneRequired(?string $tileKey = null, ?string $descriptionKey = null): self
    {
        $this->phone_required = true;

        $this->phone_code_title = $tile ?? 'confirmables::action.method.phone.title';
        $this->phone_code_description = $description ?? 'confirmables::action.method.phone.description';

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
        return (bool) $this->email_verified_at;
    }

    public function isPhoneVerified(): bool
    {
        return (bool) $this->phone_verified_at;
    }

    public function getNextStep()
    {
        if ($this->email_required && ! $this->isEmailVerified()) {
            return static::STATUS_EMAIL_NEEDED;
        }
        if ($this->phone_required && ! $this->isPhoneVerified()) {
            return static::STATUS_PHONE_NEEDED;
        }

        return static::STATUS_VERIFIED;
    }

    public function execute(): string
    {
        $nextStep = $this->getNextStep();
        if ($nextStep === static::STATUS_VERIFIED) {
            $this->dispatch();

            $this->dispatched_at = Carbon::now();
            $this->save();

            $this->deleteConfirmable();

            return static::STATUS_EXECUTED;
        }

        return $nextStep;
    }

    private function getCurrentConfirmMethod(): ?string
    {
        if ($this->email_required && ! $this->isEmailVerified()) {
            return self::METHOD_EMAIL;
        }

        if ($this->phone_required && ! $this->isPhoneVerified()) {
            return self::METHOD_PHONE;
        }

        return null;
    }

    private function getCurrentConfirmMethodTitle(): ?string
    {
        if ($this->getCurrentConfirmMethod() === self::METHOD_EMAIL) {
            return __($this->email_code_title);
        }

        if ($this->getCurrentConfirmMethod() === self::METHOD_PHONE) {
            return __($this->phone_code_title);
        }

        return null;
    }

    private function getCurrentConfirmMethodDescription(): ?string
    {
        if ($this->getCurrentConfirmMethod() === self::METHOD_EMAIL) {
            return __($this->email_code_description);
        }

        if ($this->getCurrentConfirmMethod() === self::METHOD_PHONE) {
            return __($this->phone_code_description);
        }

        return null;
    }

    private function deleteConfirmable(): void
    {
        $this->delete();
    }

    private function dispatch(): void
    {
        $arguments = json_decode($this->arguments, true);
        $this->payload::dispatch(...$arguments);
    }
}
