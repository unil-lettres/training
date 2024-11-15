<?php

namespace Tests\Feature;

use App\Enums\RequestStatusAdmin;
use App\Helpers\Helpers;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * Request status helper should return the right human readable string.
     */
    public function testRequestStatus(): void
    {
        $this->assertEquals(
            RequestStatusAdmin::NEW->value,
            Helpers::requestStatus(strtolower(RequestStatusAdmin::NEW->name))
        );

        $this->assertEquals(
            RequestStatusAdmin::PENDING->value,
            Helpers::requestStatus(strtolower(RequestStatusAdmin::PENDING->name))
        );

        $this->assertEquals(
            RequestStatusAdmin::RESOLVED->value,
            Helpers::requestStatus(strtolower(RequestStatusAdmin::RESOLVED->name))
        );

        $this->assertEquals(
            '-',
            Helpers::requestStatus('xxxxx')
        );
    }
}
