<?php
namespace Tests\Services;

//TODO: use Silex object and class to test

class SimpleTest extends \PHPUnit_Framework_TestCase
{
	private $noteService;
	//TODO: setup dummy data for various scenario
    public function testGetOne()
    {
        $data = getIP('127.0.0.1');
        $this->assertEquals('Home', $data['city']);
        //TODO: test another possibilities
    }
}
