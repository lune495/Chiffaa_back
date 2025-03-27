<?php

namespace App\Http\Controllers;

use App\Models\{User,Outil};
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationMail;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    private $queryName = "users";
    // Register
    public function register(Request $request ) 
    {
        try {
        $fields = $request->validate([
            'email' => 'required|string',
            'name'  => 'required|string',
            'password' => 'required|string|confirmed',
            'telephone' => 'nullable|string',
            'role_id' => 'required|integer',
            'source' => 'nullable|string',
        ]);
        
        $actif = isset($fields['source']) ? false : true;

        $user =  User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            // 'telephone' => $fields['telephone'],
            'password' => bcrypt($fields['password']),
            'role_id' => $fields['role_id'],
            'actif' => $actif,
        ]);
        $id = $user->id;
        $token = $user->createToken('myapptoken')->plainTextToken;
        if (isset($fields['source']) && $user->role->nom == 'PATIENT_SITE') 
        {
        Mail::to($user->email)->send(new ConfirmationMail($user));
        }

        $response = [
            // 'user' =>  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]),
            'user' => $user,
            'token' => $token
        ];

         //return Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
        return response($response, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function confirmEmail($token)
    {
        // Chercher le token dans la base de données pour récupérer l'utilisateur correspondant
        $accessToken = PersonalAccessToken::findToken($token);
        // Vérifier si le token est valide
        if (!$accessToken || !$accessToken->tokenable) {
            return response()->json(['message' => 'Token invalide'], 401);
        }
        // Récupérer l'utilisateur associé au token
        $user = $accessToken->tokenable;
        if ($user->role->nom == 'PATIENT_SITE') 
        {
            $user->actif = true;
            $user->save();

            return view('account_activated');
        }

        return redirect('/login')->with('error', 'Le lien de confirmation est invalide.');
    }

     public function login(Request $request ) 
     {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        // Check email
        $user = User::with('role')->where('email',$fields['email'])->first();
        //Check email
        if (!$user || !Hash::check($fields['password'],$user->password)) 
        {
            return response([
                'message' => 'Mot de passe Incorrect'
            ],401);
        }
        if ($user->role->nom == 'PATIENT_SITE' && !$user->actif) 
        {
            return response([
                'message' => 'Veuillez activer votre compte pour vous connecter'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Deconnecte'
        ];
    }
}
