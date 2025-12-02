<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Message as MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

class AuthController extends BaseController
{
/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Realiza login",
 *     description="Autentica o usuário e retorna um token JWT junto com os dados do usuário.",
 *     operationId="login",
 *     tags={"Usuários"},
 * 
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"login","password"},
 *             @OA\Property(property="login", type="string", example="gustavo.queiroz"),
 *             @OA\Property(property="password", type="string", format="password", example="12345678")
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=200,
 *         description="Login realizado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."),
 *                 @OA\Property(property="name", type="string", example="Gustavo Queiroz")
 *             ),
 *             @OA\Property(property="message", type="string", example="Usuário logado com sucesso!")
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=404,
 *         description="Usuário ou senha incorretos"
 *     )
 * )
 */

    public function login(Request $request): JsonResponse
    {
       // if (Auth::attempt(['login' => $request->login, 'password' => $request->password])) {
        if(Auth::attempt($request->only('login', 'password'))) {
            $user = Auth::user();
            if($user->enable == 0 ){
                return response()->json(["sucess" => false,'message' => 'Usuário desabilitado!'],202);
            }

            $token=  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

            session()->put('cnp', $user->cnp);
            return response()->json(["sucess" => true, 'data'=>['token'=>$token],'message' => 'Usuário logado com sucesso!'],202);
        } else {
            return response()->json(["sucess" => true,'message' => 'Usuário ou senha incorretos'],202);
        }
    }

    public function forgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $email = $request->input('email');

        /*
        if (User::where('email', $email)->doesntExists()) {
            return response(
                [
                    'message' => 'User doen\'t exists!',

                ],
                404
            );*/

        $token = Str::random(10);
        try {
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token
            ]);

        } catch (\Exception $exception) {
  
                DB::table('password_reset_tokens')->where('email', $email)->update([
                    'token' => $token
                ]);
            
        }

        try {
            Mail::send('Mails.forgot', ['token' => $token], function (MailMessage $message) use ($email) {
                $message->to($email);
                $message->subject('Alterar senha');
            });

            return response([
                'success' => true,
                'message' => 'Verifique seu email!'
            ]);
        } catch (\Exception $exception) {
            return response([
                'success' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $token = $request->input('token');

        if (!$passwordResets = DB::table('password_reset_tokens')->where('token', $token)->first()) {
            return response([
                'success' => false,
                'message' => 'Token inválido!'
            ], 400);
        }

        if (!$user = DB::table('users')->where('email', $passwordResets->email)->first()) {
            return response([
                'success' => false,
                'message' => 'Usuário não existe!'
            ], 404);
        }

        $password = Hash::make($request->input('password'));

        if (DB::table('users')->where('email', $user->email)->update(['password' => $password])) {
            return response([
                'success' => true
            ],202);
        }
    }
}
