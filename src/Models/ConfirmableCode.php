<?php declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Yormy\ConfirmablesLaravel\Services\CodeGenerator;
use Yormy\CoreToolsLaravel\Traits\Factories\PackageFactoryTrait;

class ConfirmableCode extends Model
{
    use PackageFactoryTrait;

    protected $table = 'confirmable_codes';


    public function scopeNotExpired($query)
    {
        return $query->where('expires_at', '>', Carbon::now()->toDateTimeString());
    }

    public function scopeAllowUser($query, $user = null)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('user_id', '=', $user?->id)
                ->where('user_type', $user ? get_class($user) : '');
        })
        ->orWhereNull('user_id');
    }

    public function scopeAllowIp($query, string $ip = null)
    {
        return $query->where(function ($q) use ($ip) {
            $q->where('accept_from_ip', '=', $ip)
                ->orWhereNull('accept_from_ip');
        });
    }

    public function confirmable(): BelongsTo
    {
        return $this->belongsTo(Confirmable::class);
    }


    // todo : to config
    public function generate($type = CodeGenerator::TYPE_NUMERIC_ALPHA_UPPERCASE, $length = 6): ConfirmableCode
    {
        $code = CodeGenerator::generate($type, $length);

        $confirmationCode = new ConfirmableCode();
        $confirmationCode->code = $code;
        $confirmationCode->token = Str::random(64);

        return $confirmationCode;
    }

    public function setExpiresInMinutes(int $minutes = 10)
    {
        $this->expiresAt = CarbonImmutable::now()->addMinutes($minutes);
    }

    public function setExpiresAt(CarbonImmutable $expiresAt = null)
    {
        if (!$expiresAt) {
            $lifetime = config('confirmables.confirm_code.lifetime_in_minutes');
            $expiresAt = CarbonImmutable::now()->addMinutes($lifetime); // todo- to config
        }

        $this->expires_at = $expiresAt;
    }

    public function setOnlyForUser($user)
    {
        $this->user_id = $user->id;
        $this->user_type = get_class($user);
    }

    public function setOnlyForIp(string $ip)
    {
        $this->accept_from_ip = $ip;
    }

    public function setForEmail()
    {
        $this->method = Confirmable::METHOD_EMAIL;
    }

    public function setForPhone()
    {
        $this->method = Confirmable::METHOD_PHONE;
    }
}
