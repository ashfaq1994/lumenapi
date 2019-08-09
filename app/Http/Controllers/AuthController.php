<?php
namespace App\Http\Controllers;

use App\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends BaseController
{
    use ApiResponser;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
      
    }

    /**
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function index()
    {
        return response(['data' => User::all()],Response::HTTP_OK)
                                       ->header('Content-Type', 'text/json');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password'=> Hash::make($request->input('password'))
        ]);
         return response()->json(['data' => json_decode($user)], Response::HTTP_CREATED)->header('Content-Type', 'text/json');                                  
    }


    /**
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     * 
     * 
     * 
     * 
     */
    public function show($user)
    {
        $user = User::find($user);
        if(!$user){
            return response()->json(['message' => "The user with {$user} doesn't exist"], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => $user], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => "The user with {$id} doesn't exist"], Response::HTTP_NOT_FOUND);
        }

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password'=> Hash::make($request->input('password'))
        ]);
        return response()->json(['data' => json_decode($user)], Response::HTTP_OK)->header('Content-Type', 'text/json');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => "The user with {$id} doesn't exist"], Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return response()->json(['data' => json_decode($user), 'message' => '{$user->name has been deleted}'], Response::HTTP_OK)->header('Content-Type', 'text/json');
      
    }
}