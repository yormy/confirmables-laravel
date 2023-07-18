<?php

namespace Yormy\ConfirmablesLaravel\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Mexion\BedrockCore\Exceptions\InvalidValueException;
use Mexion\BedrockCore\Libraries\GlobalHelper;
use Mexion\BedrockCore\Models\ConfirmCode;
use Yormy\ConfirmablesLaravel\Jobs\BaseActionData;
use Yormy\ConfirmablesLaravel\Jobs\BaseActionJob;
use Yormy\ConfirmablesLaravel\Services\CodeGenerator;
use Yormy\ConfirmablesLaravel\Traits\HasPackageFactory;
use Yormy\Dateformatter\Services\DateHelper;
use Yormy\Xid\Models\Traits\Xid;

class ConfirmableCode extends Model
{
    use HasPackageFactory;

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
        $expiresAt = CarbonImmutable::now()->addMinutes($minutes);
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
}
