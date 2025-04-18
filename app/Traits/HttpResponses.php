<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait HttpResponses
{
    /**
     * @param $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function success($data, string $message = 'success', int $code = ResponseAlias::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * @param $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function error(
        string $message = 'error',
        int $code = ResponseAlias::HTTP_BAD_REQUEST
    ): JsonResponse {
        return response()->json([
            'message' => $message,
        ], $code);
    }

    // /**
    //  * @param $data
    //  * @param string|null $message
    //  * @param int $code
    //  * @return JsonResponse
    //  */
    // protected function authorizeOwnership(Model $model)
    // {
    //     if ($model->user_id !== Auth::id()) {
    //         return $this->error('Unauthorized action.', Response::HTTP_FORBIDDEN);
    //     }
    // }
}
