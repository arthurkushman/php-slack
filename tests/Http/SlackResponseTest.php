<?php

namespace SlackyTests\Http;

use PHPUnit\Framework\TestCase;
use Slacky\Http\SlackResponse;

/**
 * Class SlackResponseTest
 * @package SlackyTests\Http
 *
 * @property SlackResponse slackResponse
 */
class SlackResponseTest extends TestCase
{
    private $slackResponse;

    public function setUp()
    {
        parent::setUp();
        $this->slackResponse = new SlackResponse('{"ok":true}', [], 200);
    }

    /**
     * @test
     */
    public function it_gets_response_array()
    {
        $this->assertArraySubset([], $this->slackResponse->toArray());
    }
}