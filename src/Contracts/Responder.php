<?php

namespace Flugg\Responder\Contracts;

use Flugg\Responder\Http\Responses\ErrorResponseBuilder;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;

/**
 * A contract for responding with error- and success responses.
 *
 * @package flugger/laravel-responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
interface Responder
{
    /**
     * Build an error response.
     *
     * @param  string|null $errorCode
     * @param  string|null $message
     * @return \Flugg\Responder\Http\Responses\ErrorResponseBuilder
     */
    public function error(string $errorCode = null, string $message = null): ErrorResponseBuilder;

    /**
     * Build a successful response.
     *
     * @param  mixed                                                          $data
     * @param  callable|string|\Flugg\Responder\Transformers\Transformer|null $transformer
     * @param  string|null                                                    $resourceKey
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder
     */
    public function success($data = null, $transformer = null, string $resourceKey = null): SuccessResponseBuilder;
}