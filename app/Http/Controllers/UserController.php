<?php

namespace App\Http\Controllers;

use App\Mail\AutentificareEmail;
use App\Mail\ResetareParolaEmail;
use App\Models\Client;
use App\Models\User;
use App\Services\ClientService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
     * @return JsonResponse
     */
    public function index()
    {
        $data = User::all();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function show()
    {
        $user = Auth::user();
        $client = $user->client;
        return response()->json([
            'user' => $user,
            'client' => $client
        ], Response::HTTP_OK);
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

        $data->user()->associate($user);
        $data->save();
        $user->client()->associate($data);
        $user->save();

        $emailVerificationToken = Str::random(60);

        DB::table('email_verification')->insert([
            'user_id' => $user->id,
            'token' => $emailVerificationToken
        ]);

        $emailVerificationToken = 'http://127.0.0.1:8000/verify/' . $emailVerificationToken;

        Mail::to($user->email)->send(new AutentificareEmail($user, $emailVerificationToken));

        $token = JWTAuth::fromUser($user);

        return response()->json([ 'token' => $token ], Response::HTTP_OK);
    }

    public function verifyMail(string $token)
    {
        $emailVerification = DB::table('email_verification')->where('token', '=', $token)->first();
        if ($emailVerification) {
            $user = User::findOrFail($emailVerification->user_id);
            $user->email_verified_at = now();
            $user->save();
            DB::table('email_verification')->where('token', '=', $token)->update(['status' => 'verified']);
            return response()->json('Email-ul a fost verificat cu succes!', Response::HTTP_OK);
        }
        return response()->json('Token-ul nu exista!', Response::HTTP_NOT_FOUND);
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
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json('User sters cu succes!', Response::HTTP_OK);
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
        $client = $user->client;

        $this->clientService->setProperties($client, $request->all());

        $client->save();
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
            JWTAuth::factory()->setTTL(60 * 24 * 7);
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json([ 'error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json('Te-ai delogat cu succes!', Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function sendPasswordRequest(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->first();
        if ($user) {
            $resetPasswordToken = Str::random(60);
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $resetPasswordToken
            ]);
            $resetPasswordToken = 'http://127.0.0.1:8000/reset/' . $resetPasswordToken;
            Mail::to($user->email)->send(new ResetareParolaEmail($user, $resetPasswordToken));
        }
    }

    /**
     * @param string $token
     * @return Application|Factory|View
     */
    public function resetPasswordRedirect(string $token)
    {
        $passwordReset = DB::table('password_resets')->where('token', '=', $token)->first();

        return view('pagina-resetare', compact('passwordReset'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $user = User::where('email', '=', $request->input('email'))->first();

        if (!empty($this->userService->checkPassword($request->input('parola')))) {
            return response()->json($this->userService->checkPassword($request->input('parola')), Response::HTTP_NOT_ACCEPTABLE);
        }

        $user->password = Hash::make($request->input('parola'));
        $user->save();

        DB::table('password_resets')->where('email', '=', $user->email)->update(['status' => 'verified']);

        return response()->json("Parola schimbata!", Response::HTTP_OK);
    }

    /**
     * @param string $ref
     * @return Application|Factory|View
     */
    public function getProfileRef(string $ref)
    {
        $ref = json_encode($ref);
        return view('pagina-profil', compact('ref'));
    }
}

