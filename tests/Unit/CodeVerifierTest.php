<?php

namespace Yormy\ConfirmablesLaravel\tests\Unit;

use Carbon\CarbonImmutable;
use Yormy\ConfirmablesLaravel\Services\CodeVerifier;
use Yormy\ConfirmablesLaravel\Tests\TestCase;
use Yormy\ConfirmablesLaravel\Tests\Traits\CodeTrait;
use Yormy\ConfirmablesLaravel\Tests\Traits\UserTrait;

class CodeVerifierTest extends TestCase
{
    use UserTrait;
    use CodeTrait;

    /**
     * @test
     * @group code-verifier
     */
    public function CodeNotExpired_Verify_Success(): void
    {
        $confirmableCode = $this->createCode();

        $verifiedCode = CodeVerifier::verify($confirmableCode->code);

        $this->assertNotNull($verifiedCode);
    }

    /**
     * @test
     * @group code-verifier
     */
    public function CodeExpired_Verify_Failed(): void
    {
        $confirmableCode = $this->createCode();

        $confirmableCode->setExpiresAt(CarbonImmutable::now()->subMinutes(2));
        $confirmableCode->save();

        $verifiedCode = CodeVerifier::verify($confirmableCode->code);

        $this->assertNull($verifiedCode);
    }


    /**
     * @test
     * @group code-verifier
     */
    public function CodeAllowIp_VerifyWithIp_Success(): void
    {
        $confirmableCode = $this->createCode();

        $ip = 'xx';
        $confirmableCode->setOnlyForIp($ip);
        $confirmableCode->save();

        $verifiedCode = CodeVerifier::verify($confirmableCode->code, $ip);

        $this->assertNotNull($verifiedCode);
    }

    /**
     * @test
     * @group code-verifier
     */
    public function CodeAllowIp_VerifyWithoutIp_Failed(): void
    {
        $confirmableCode = $this->createCode();

        $ip = 'xx';
        $confirmableCode->setOnlyForIp($ip);
        $confirmableCode->save();

        $verifiedCode = CodeVerifier::verify($confirmableCode->code);

        $this->assertNull($verifiedCode);
    }


    /**
     * @test
     * @group code-verifier
     */
    public function CodeAllowIp_VerifyWithWrongIp_Failed(): void
    {
        $confirmableCode = $this->createCode();

        $ip = 'xx';
        $confirmableCode->setOnlyForIp($ip);
        $confirmableCode->save();

        $verifiedCode = CodeVerifier::verify($confirmableCode->code, ip: 'wrong-ip');

        $this->assertNull($verifiedCode);
    }

    /**
     * @test
     * @group code-verifier
     */
    public function CodeForUserOnly_VerifyWithUser_Success(): void
    {
        $confirmableCode = $this->createCode();

        $user = $this->createUser();

        $confirmableCode->setOnlyForUser($user);
        $confirmableCode->save();

        $verifiedCode = CodeVerifier::verify($confirmableCode->code, user: $user);

        $this->assertNotNull($verifiedCode);
    }

    /**
     * @test
     * @group code-verifier
     */
    public function CodeForUserOnly_VerifyWithoutUser_Failed(): void
    {
        $confirmableCode = $this->createCode();

        $user = $this->createUser();

        $confirmableCode->setOnlyForUser($user);
        $confirmableCode->save();

        $verifiedCode = CodeVerifier::verify($confirmableCode->code);

        $this->assertNull($verifiedCode);
    }

    /**
     * @test
     * @group code-verifier
     */
    public function CodeForUserOnly_VerifyWithWrongUser_Failed(): void
    {
        $confirmableCode = $this->createCode();

        $user = $this->createUser();

        $confirmableCode->setOnlyForUser($user);
        $confirmableCode->save();

        $user = $this->createUser();
        $verifiedCode = CodeVerifier::verify($confirmableCode->code, user: $user);

        $this->assertNull($verifiedCode);
    }
}
