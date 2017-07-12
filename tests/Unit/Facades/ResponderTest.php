<?php

namespace Flugg\Responder\Tests\Unit\Facades;

use Flugg\Responder\Contracts\Responder as ResponderContract;
use Flugg\Responder\Facades\Responder;
use Flugg\Responder\Tests\TestCase;
use Mockery;

/**
 * Unit tests for the [Flugg\Responder\Facades\Responder] facade.
 *
 * @package flugger/laravel-responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
class ResponderTest extends TestCase
{
    /**
     * The mock of the responder service.
     *
     * @var \Mockery\MockInterface
     */
    protected $responder;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->responder = Mockery::mock(ResponderContract::class);
        $this->app->instance(ResponderContract::class, $this->responder);
    }

    /**
     * Test that the parameters sent to the [error] method is forwarded to the responder service.
     */
    public function testErrorMethodShouldCallOnTheResponder()
    {
        $this->responder->shouldReceive('error')->andReturn($responseBuilder = $this->mockErrorResponseBuilder());

        $result = Responder::error($error = 'error_occured');

        $this->assertSame($responseBuilder, $result);
        $this->responder->shouldHaveReceived('error')->with($error)->once();
    }

    /**
     * Test that the parameters sent to the [success] method is forwarded to the responder service.
     */
    public function testSuccessMethodShouldCallOnTheResponder()
    {
        $this->responder->shouldReceive('success')->andReturn($responseBuilder = $this->mockSuccessResponseBuilder());

        $result = Responder::success($data = ['foo' => 1]);

        $this->assertSame($responseBuilder, $result);
        $this->responder->shouldHaveReceived('success')->with($data)->once();
    }
}