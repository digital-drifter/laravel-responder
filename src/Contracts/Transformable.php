<?php

namespace Flugg\Responder\Contracts;

/**
 * A contract indicating that the class is transformable.
 *
 * @package flugger/laravel-responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
interface Transformable
{
    /**
     * Get a transformer for the class.
     *
     * @return \Flugg\Responder\Transformers\Transformer|callable|string|null
     */
    public function transformer();
}