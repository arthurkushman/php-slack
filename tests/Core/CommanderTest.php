<?php

namespace SlackyTests\Core;


use PHPUnit\Framework\TestCase;
use Slacky\Core\Commander;
use Slacky\Http\CurlInteractor;
use Slacky\Http\SlackResponseFactory;

/**
 * Class CommanderTest
 * @package SlackyTests\Core
 *
 * @property Commander commander
 */
class CommanderTest extends TestCase
{
    private $commander;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $interactor = new CurlInteractor();
        $interactor->setResponseFactory(new SlackResponseFactory());

        $this->commander = new Commander('xoxp-some-token-for-slack', $interactor);
    }

    /**
     * Test get method
     * @test
     */
    public function it_runs_execute_get()
    {
        $response = $this->commander->execute('chat.postMessage', [
            'channel' => '#general',
            'text'    => 'Hello, world!'
        ]);

        $resp = $response->getBody();
        $this->assertFalse($resp['ok']);
        $this->assertEquals('invalid_auth', $resp['error']);
        $this->assertEquals('slack.com', $response->getHeaders()['Host']);
    }

    /**
     * @test
     */
    public function it_runs_execute_post()
    {
        $response = $this->commander->execute('files.upload', [
            'channel' => '#general',
            'text'    => 'Hello, world!'
        ]);

        $resp = $response->getBody();
        $this->assertFalse($resp['ok']);
        $this->assertEquals('not_authed', $resp['error']);
        $this->assertEquals('slack.com', $response->getHeaders()['Host']);
    }
}