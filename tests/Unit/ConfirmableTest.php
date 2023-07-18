<?php

namespace Yormy\ConfirmablesLaravel\tests\Unit;

use Carbon\CarbonImmutable;
use Yormy\ConfirmablesLaravel\Models\Confirmable;
use Yormy\ConfirmablesLaravel\Services\CodeVerifier;
use Yormy\ConfirmablesLaravel\Tests\TestCase;
use Yormy\ConfirmablesLaravel\Tests\Traits\CodeTrait;
use Yormy\ConfirmablesLaravel\Tests\Traits\ConfirmableTrait;
use Yormy\ConfirmablesLaravel\Tests\Traits\UserTrait;

class ConfirmableTest extends TestCase
{
    use UserTrait;
    use ConfirmableTrait;

    /**
     * @test
     * @group action
     */
    public function ConfirmableNoRequire_NothingSet_Success(): void
    {
        $confirmableCreated = $this->createConfirmable();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);

        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_EXECUTED, $result);
    }

    /**
     * @test
     * @group action
     */
    public function ConfirmableEmailRequired_NothingVerified_EmailNeeded(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->emailRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);

        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_EMAIL_NEEDED, $result);
    }

    /**
     * @test
     * @group action
     */
    public function ConfirmablePhoneRequired_NothingVerified_PhoneNeeded(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->phoneRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);

        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_PHONE_NEEDED, $result);
    }

    /**
     * @test
     * @group action
     */
    public function ConfirmableEmailRequired_EmailVerified_Success(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->emailRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);
        $confirmableExecute->setEmailVerified();
        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_EXECUTED, $result);
    }

    /**
     * @test
     * @group action
     */
    public function ConfirmablePhoneRequired_PhoneVerified_Success(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->phoneRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);
        $confirmableExecute->setPhoneVerified();
        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_EXECUTED, $result);
    }

    /**
     * @test
     * @group action
     */
    public function ConfirmableEmailRequired_PhoneVerified_EmailNeeded(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->emailRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);
        $confirmableExecute->setPhoneVerified();
        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_EMAIL_NEEDED, $result);
    }

    /**
     * @test
     * @group action
     */
    public function ConfirmableEmailPhoneRequired_EmailVerified_PhoneNeeded(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->emailRequired();
        $confirmableCreated->phoneRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);
        $confirmableExecute->setEmailVerified();
        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_PHONE_NEEDED, $result);
    }

    /**
     * @test
     * @group action
     */
    public function ConfirmableEmailPhoneRequired_PhoneVerified_EmailNeeded(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->emailRequired();
        $confirmableCreated->phoneRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);
        $confirmableExecute->setPhoneVerified();
        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_EMAIL_NEEDED, $result);
    }

    /**
     * @test
     * @group action
     */
    public function ConfirmableEmailPhoneRequired_NothingVerified_EmailNeeded(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->emailRequired();
        $confirmableCreated->phoneRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);
        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_EMAIL_NEEDED, $result);
    }



    /**
     * @test
     * @group action
     */
    public function ConfirmableEmailPhoneRequired_EmailPhoneVerified_Success(): void
    {
        $confirmableCreated = $this->createConfirmable();
        $confirmableCreated->emailRequired();
        $confirmableCreated->phoneRequired();
        $confirmableCreated->save();

        $confirmableExecute = $this->findConfirmable($confirmableCreated->xid);
        $confirmableExecute->setPhoneVerified();
        $confirmableExecute->setEmailVerified();
        $result = $confirmableExecute->execute();

        $this->assertEquals(Confirmable::STATUS_EXECUTED, $result);
    }



    protected function findConfirmable(string $xid): Confirmable
    {
        $confirmable = new Confirmable();
        return $confirmable->findByXid($xid);
    }

}
