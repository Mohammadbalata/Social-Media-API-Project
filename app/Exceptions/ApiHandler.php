<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiHandler extends ExceptionHandler
{
   
    public function render($request, Throwable $e): JsonResponse
    {
       

        if ($e->getPrevious() instanceof ModelNotFoundException) {
            $model = class_basename($e->getPrevious()->getModel());
            return response()->json([
                'message' => "$model not found",
            ], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof ValidationException) {
            return $this->validationErrorResponse($e);
        }

        return $this->errorResponse(
            $this->isDebugMode() ? $e->getMessage() : 'Server Error',
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

   
    protected function errorResponse(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }

   
    protected function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    
    protected function isDebugMode(): bool
    {
        return config('app.debug');
    }
}
