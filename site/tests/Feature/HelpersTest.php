<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Helpers\Helpers;

class HelpersTest extends TestCase
{
    /**
     * Reuqest status helper should return the right human readable string
     *
     * @return void
     */
    public function testRequestStatus()
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
