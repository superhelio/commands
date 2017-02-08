<?php
namespace Superhelio\Commands;

use Tests\TestCase;
use Superhelio\Commands\Commands\Reload;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReloadTest extends TestCase
{
    public function testReloadTest()
    {
        $this->assertTrue(true);
        $this->assertTrue(class_exists('\\Superhelio\\Commands\\Commands\\Reload'));
    }
}
