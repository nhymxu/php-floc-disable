<?php
declare(strict_types = 1);

namespace Nhymxu\FlocDisable\Tests;

use Nhymxu\FlocDisable\FlocDisableMiddleware;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @covers \Nhymxu\FlocDisable\FlocDisableMiddleware
 */
final class FlocDisableMiddlewareTest extends TestCase
{
    public function testNotExistsHeader(): void
    {
        $middleware = new FlocDisableMiddleware();

        $serverRequest = new ServerRequest('GET', '/');

        $requestHandler = $this->createMock(RequestHandlerInterface::class);
        $requestHandler->method('handle')
            ->with($serverRequest)
            ->willReturn(new Response());

        $response = $middleware->process($serverRequest, $requestHandler);

        self::assertEquals(
            'interest-cohort=()',
            $response->getHeaderLine('Permissions-Policy')
        );
    }

    public function testExistsHeader(): void
    {
        $middleware = new FlocDisableMiddleware();

        $serverRequest = new ServerRequest('GET', '/');

        $requestHandler = $this->createMock(RequestHandlerInterface::class);
        $requestHandler->method('handle')
            ->with($serverRequest)
            ->willReturn(new Response(200, ['Permissions-Policy' => 'geolocation=*,camera=()']));

        $response = $middleware->process($serverRequest, $requestHandler);

        self::assertEquals(
            'geolocation=*,camera=(),interest-cohort=()',
            $response->getHeaderLine('Permissions-Policy')
        );
    }
}
