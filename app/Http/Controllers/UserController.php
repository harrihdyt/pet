<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function all_user()
    {
        $users = User::all();

        return response()->json([
            'status' => '200',
            'data' => $users,
        ]);
    }

    public function show($id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'data' => $user,
        ]);
    }

    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Request is valid, create new user
        $user = User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'status' => '200',
            'success' => true,
            'message' => 'User Register successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
 
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Request is validated
        //Create token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }
 	
 		//Token created, return with success response and jwt token
        return response()->json([
            'status' => '200',
            'success' => true,
            'token' => $token,
        ]);
    }

    public function update(Request $request, $id)
    {
        // var_dump ($id);
        $user = JWTAuth::parseToken()->authenticate();

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'sometimes|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        // Update data user
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
    
        $user->save();
    
        // Mengembalikan respons sukses
        return response()->json([
            'status' => '200',
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }


 
    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'status' => '200',
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }

    public function destroy($id)
    {
        // Cari user yang ingin dihapus
        $user = User::find($id);
    
        // Jika user tidak ditemukan, kembalikan pesan error
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        // Hapus user
        $username = $user->name;
        $user->delete();
    
        // Kembalikan respon sukses
        return response()->json([
                    'status' => '200',
                    'success' => true,
                    'message' => "User with name $username deleted successfully"
                ], Response::HTTP_OK);
    }


}