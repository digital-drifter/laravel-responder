<?php

namespace Flugg\Responder\Exceptions\Http;

/**
 * An exception thrown whan a user is unauthenticated. This exception replaces
 * [\Illuminate\Auth\AuthenticationException].
 *
 * @package flugger/laravel-responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
class UnauthenticatedException extends ApiException
{
    /**
     * An HTTP status code.
     *
     * @var int
     */
    protected $status = 401;

    /**
     * The error code.
     *
     * @var string|null
     */
    protected $errorCode = 'unauthenticated';
}