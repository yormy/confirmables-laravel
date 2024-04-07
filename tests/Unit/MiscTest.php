<?php

namespace Yormy\ConfirmablesLaravel\tests\Unit;

use Yormy\ConfirmablesLaravel\Tests\TestCase;
use Yormy\ConfirmablesLaravel\Tests\Traits\CodeTrait;
use Yormy\ConfirmablesLaravel\Tests\Traits\ConfirmableTrait;
use Yormy\ConfirmablesLaravel\Tests\Traits\UserTrait;

class MiscTest extends TestCase
{
    use CodeTrait;
    use ConfirmableTrait;
    use UserTrait;

    /**
     * @test
     * @group actioxx
     */
    public function Confirmable_Delete_NoCodesLeft(): void
    {
        $code = $this->createCode();

        $confirmable = $code->confirmable;
        $this->assertEquals(1, $confirmable->codes->count());

        $confirmable->delete();
        $confirmable->refresh();
        $this->assertEquals(0, $confirmable->codes->count());
    }
}
