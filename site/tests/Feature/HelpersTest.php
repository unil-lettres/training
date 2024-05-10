<?php

namespace Tests\Feature;

use App\Helpers\Helpers;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * Request status helper should return the right human readable string.
     */
    public function testRequestStatus(): void
    {
        $status = 'new';
        $this->assertEquals('Nouveau', Helpers::requestStatus($status));

        $status = 'pending';
        $this->assertEquals('En attente', Helpers::requestStatus($status));

        $status = 'resolved';
        $this->assertEquals('Résolue', Helpers::requestStatus($status));

        $status = 'xxxxx';
        $this->assertEquals('-', Helpers::requestStatus($status));
    }
}
