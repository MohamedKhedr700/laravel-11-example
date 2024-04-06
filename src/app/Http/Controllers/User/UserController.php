<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {

    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->userService->list(),
        ]);
    }

    public function store(): JsonResponse
    {
        return response()->json([
            'data' => $this->userService->create(request()->validated()),
        ]);
    }
}
