<?php declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Domain\Shared\Services;

use Illuminate\Http\Request;

class IpAddress
{
    public static function get(Request $request = null): array|string|null
    {
        if (! $request) {
            return request()->ip();
        }

        if ($cloudflarePassthroughIp = $request->header('CF_CONNECTING_IP')) {
            return $cloudflarePassthroughIp;
        }

        return $request->ip();
    }
}
