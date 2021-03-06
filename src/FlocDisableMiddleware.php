<?php
declare(strict_types = 1);

namespace Nhymxu\FlocDisable;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class FlocDisableMiddleware implements MiddlewareInterface
{
    /**
     * Process a server request and return a response.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (!$response->hasHeader('Permissions-Policy')) {
            return $response->withHeader('Permissions-Policy', 'interest-cohort=()');
        }

        $policy = $response->getHeaderLine('Permissions-Policy');
        if (trim($policy) !== '') {
            $policy .= ',';
        }

        $policy .= 'interest-cohort=()';

        return $response->withHeader('Permissions-Policy', $policy);
    }
}
