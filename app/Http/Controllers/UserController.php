<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Exception;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
    * Responds to a GET request into
    * /user endpoint with all user and its
    * wallets
    *
    * @return JsonResponse
    */
    public function index() : JsonResponse
    {
        $user = $this->user->with('wallet')->get();
        return response()->json($user);
    }

    /**
    * Responds to a GET request into
    * /user/{id} endpoint with the respective
    * user and its wallet
    * @return JsonResponse
    * @param Int $id
    */
    public function show(int $id) : JsonResponse
    {
        try{
            $user = $this->user->with('wallet')->findOrFail($id);
            return response()->json($user);

        }catch (Exception $e) {

            return response()->json(
                ['error' => 'The requested resource does not exist.'],
                JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
