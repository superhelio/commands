<?php
namespace Superhelio\Commands;

use Superhelio\Commands\Commands\Gozer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GozerTest extends \PHPUnit_Framework_TestCase
{
    public function testGozerTest()
    {
        $this->assertTrue(true);
        $this->assertTrue(class_exists('\\Superhelio\\Commands\\Commands\\Gozer'));
    }
}
