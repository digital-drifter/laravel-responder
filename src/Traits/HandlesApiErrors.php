<?php

namespace Mangopixel\Responder\Traits;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Mangopixel\Responder\Exceptions\ApiException;
use Mangopixel\Responder\Exceptions\ResourceNotFoundException;
use Mangopixel\Responder\Exceptions\UnauthorizedException;
use Mangopixel\Responder\Exceptions\ValidationFailedException;
use Mangopixel\Responder\Responder;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * You may apply this trait to your exceptions handler to give you access to methods
 * you may use to let the package catch and handle any API exceptions.
 *
 * @package Laravel Responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
trait HandlesApiErrors
{
    /**
     * Checks if the exception extends from the package API exception.
     *
     * @param  Exception $e
     * @return bool
     */
    protected function isApiError( Exception $e ):bool
    {
        return $e instanceof ApiException;
    }

    /**
     * Transforms and renders api responses.
     *
     * @param  Exception $e
     * @return JsonResponse
     */
    protected function renderApiErrors( Exception $e ):JsonResponse
    {
        $this->transformExceptions( $e );

        return $this->renderApiResponse( $e );
    }

    /**
     * Checks if the application is currently in testing mode.
     *
     * @return bool
     */
    protected function isRunningTests():bool
    {
        return app()->runningUnitTests();
    }

    /**
     * Renders readable responses for console, useful for testing.
     *
     * @param  Exception $e
     * @return void
     */
    protected function renderTestErrors( Exception $e )
    {
        $this->renderConsoleResponse( $e );
    }

    /**
     * Transform Laravel exceptions into API exceptions.
     *
     * @param  Exception $e
     * @return void
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     */
    protected function transformExceptions( Exception $e )
    {
        if ( $e instanceof AuthorizationException ) {
            throw new UnauthorizedException();
        }

        if ( $e instanceof ModelNotFoundException ) {
            throw new ResourceNotFoundException();
        }
    }

    /**
     * Render an exception into an API response.
     *
     * @param  Exception $e
     * @return JsonResponse
     */
    protected function renderApiResponse( Exception $e ):JsonResponse
    {
        $message = $e instanceof ValidationFailedException ? $e->getValidationMessages() : $e->getMessage();

        return app( Responder::class )->error( $e->getErrorCode(), $e->getStatusCode(), $message );
    }

    /**
     * Render an exception into an HTTP response for the console, used for debugging in test mode.
     *
     * @param  Exception $e
     * @return void
     */
    protected function renderConsoleResponse( Exception $e )
    {
        $this->renderForConsole( new ConsoleOutput( ConsoleOutput::VERBOSITY_VERBOSE ), $e );
    }

    /**
     * Render an exception to the console.
     *
     * 
     */
    abstract public function renderForConsole( $output, Exception $e );
}