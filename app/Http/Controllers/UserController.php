<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function getAllUsers(){
        $users= User::all();
        if($users->count() > 0){


            return response()->json([
                'status' => 200,
                'users' => $users
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Pas d\'utilisateur trouvé'
            ], 404);
        }
       
    }
    public function addUser(Request $request){
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:191',
        'firsname' => 'required|string|max:191',
        'lastname' => 'required|string|max:191',
        'address' => 'required|string|max:191',
        'phone' => 'required|digits:10',
        'email' => 'required|email|max:191|unique:users',
        'password' => 'required|string|max:191'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
        ], 422);
    } else {
        $user = User::create([
            'username' => $request->username,
            'firsname' => $request->firsname,
            'lastname' => $request->lastname,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => "Utilisateur créé avec succès"
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Un problème est survenu"
            ], 500);
        }
    }
}
    public function getSingleUser($id){
    $user = User::find($id);

    if ($user) {
        return response()->json([
            'status' => 200,
            'user' => $user
        ], 200);
    } else {
        return response()->json([
            'status' => 404,
            'message' => "Utilisateur avec l'ID $id non trouvé"
        ], 404);
    }
}
    public function updateUser(Request $request, int $id){

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:191',
            'firsname' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'phone' => 'required|digits:10',
            'email' => 'required|email|max:191',
            'password' => 'required|string|max:191'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $user = User::find($id);

            if ($user) {
                $user->update([
                    'username' => $request->username,
                    'firsname' => $request->firsname,
                    'lastname' => $request->lastname,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password)
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Utilisateur mise à jour avec succes"
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Utilisateur avec l'ID $id non trouvé"
                ], 404);
            }
        }
    }
    public function deleteUser($id){
    $user = User::find($id);

    if ($user) {
        $user->delete();

        return response()->json([
            'status' => 200,
            'message' => "Utilisateur avec l'ID $id a été supprimé avec succès"
        ], 200);
    } else {
        return response()->json([
            'status' => 404,
            'message' => "Utilisateur avec l'ID $id non trouvé"
        ], 404);
    }
}

}


