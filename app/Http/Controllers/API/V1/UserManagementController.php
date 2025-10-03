<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\UserCollection;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserManagementController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function admins(Request $request)    
    {
        try {
            $user = $request->user();
            if ($user->is_admin == User::NOT_ADMIN) {
                return response()->json(["message" => "Unauthorized access."], Response::HTTP_FORBIDDEN);
            }
            $users = User::where('is_admin', true)->paginate(10);
            return sendResponse(true, 'Admins retrieved successfully.', new UserCollection($users), Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error('Get Admins Error: ' . $e->getMessage());
            return sendResponse(false, 'Something went wrong.', null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function users(Request $request)
    {
        try {
            $user = $request->user();
            if ($user->is_admin == User::NOT_ADMIN) {
                return response()->json(["message" => "Unauthorized access."], Response::HTTP_FORBIDDEN);
            }
            $users = User::where('is_admin', false)->paginate(10);
            return sendResponse(true, 'Users retrieved successfully.', new UserCollection($users), Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error('Get Users Error: ' . $e->getMessage());
            return sendResponse(false, 'Something went wrong.', null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
