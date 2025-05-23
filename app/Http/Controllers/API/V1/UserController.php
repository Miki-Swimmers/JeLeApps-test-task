<?php

namespace app\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ProfileResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Получить данные профиля
     */
    public function profile(Request $request): \Illuminate\Http\JsonResponse
    {
        /**
         * @status 200
         * @body array{success: true, message: 'Успех!', payload: ProfileResource}
         */
        return $this->response()->success(
            payload: ProfileResource::make($request->user())
        );
    }
}
