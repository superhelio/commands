<?php
namespace Superhelio\Commands;

use Tests\TestCase;
use Superhelio\Commands\Commands\Gozer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GozerTest extends TestCase
{
    public function testGozerTest()
    {
        $this->assertTrue(true);
        $this->assertTrue(class_exists('\\Superhelio\\Commands\\Commands\\Gozer'));
    }
}
