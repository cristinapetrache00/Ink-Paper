<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\User;
use App\Services\ClientService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController
{
    private ClientService $clientService;
    private UserService $userService;
    public function __construct(ClientService $clientService, UserService $userService)
    {
        $this->clientService = $clientService;
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *    path="/user",
     *    summary="Adauga clientul",
     *    tags={"User"},
     *    description="Adauga clientul",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="nume",
     *                  type="string",
     *                  description="",
     *                  example="Petrache",
     *              ),
     *              @OA\Property(
     *                  property="prenume",
     *                  type="string",
     *                  description="",
     *                  example="Cristina",
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  description="",
     *                  example="cristina.petrache@hotmail.com",
     *              ),
     *              @OA\Property(
     *                  property="parola",
     *                  type="string",
     *                  description="",
     *                  example="asd123",
     *              ),
     *              @OA\Property(
     *                  property="nr_telefon",
     *                  type="string",
     *                  description="",
     *                  example="0755158838",
     *              ),
     *              @OA\Property(
     *                  property="adresa",
     *                  type="string",
     *                  description="",
     *                  example="Str. Padurii, Nr. 85",
     *              ),
     *              @OA\Property(
     *                  property="oras",
     *                  type="string",
     *                  description="",
     *                  example="Sabareni",
     *              ),
     *               @OA\Property(
     *                  property="judet",
     *                  type="string",
     *                  description="",
     *                  example="Giurgiu",
     *              )
     *          )
     *     ),
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $user = new User;
        $user->email = $request->input('email');
        $password = $request->input('parola');

        if (!empty($this->userService->checkPassword($password))) {
            return response()->json($this->userService->checkPassword($password), Response::HTTP_NOT_ACCEPTABLE);
        }

        $user->password = Hash::make($password);

        $user->save();

        $data = new Client;
        $this->clientService->setProperties($data, $request->all());
        $data->save();

        $user->client()->associate($data);
        $data->user()->associate($user);

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/user/parola",
     *    summary="Update parola user-ului autentificat",
     *    tags={"User"},
     *    description="Update parola user-ului autentificat",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="parola",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              )
     *          )
     *     ),
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function changePassword(Request $request): JsonResponse
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }

        if (!empty($this->userService->checkPassword($request->input('parola')))) {
            return response()->json($this->userService->checkPassword($request->input('parola')), Response::HTTP_NOT_ACCEPTABLE);
        }

        $user->password = Hash::make($request->input('parola'));

        $user->save();
        return response()->json("Parola schimbata!", Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/user",
     *    summary="Update email-ul user-ului autentificat",
     *    tags={"User"},
     *    description="Update email-ul user-ului autentificat",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              )
     *          )
     *     ),
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function update(Request $request): JsonResponse
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }

        $user->email = $request->input('email');

        $user->save();
        return response()->json("Email schimbat!", Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return response()->json(['error' => 'User-ul nu exista!'], Response::HTTP_NOT_FOUND);
        }

        if (Hash::check($validatedData['password'], $user->password)) {
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'token' => $token,
            ]);
        }

        return response()->json([ 'error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json('Te-ai delogat cu succes!', Response::HTTP_OK);
    }
}

