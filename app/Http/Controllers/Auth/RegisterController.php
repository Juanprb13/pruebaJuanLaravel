<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'identity_document' => ['required', 'numeric','unique:users,cedula'],
            'address' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'numeric'],
            'picture' =>'required|mimes:jpg,jpeg,png|max:10000',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $cedula = $data['identity_document'];
         //obtenemos el campo file definido en el formulario
       $file = $data['picture'];
 
       //obtenemos el nombre del archivo
       $nombre = rand(1,9).$file->getClientOriginalName();
 
       //indicamos que queremos guardar un nuevo archivo en el disco local
       \Storage::disk('local')->put($nombre,  \File::get($file));
        $user = new User ;
        $user->name =$data['name'];
        $user->cedula   =$cedula;
        $user->direccion    =$data['address'];
        $user->email    =$data['email'];
        $user->telefono =$data['phone'];
        $user->url_img  =$nombre;
        $user->password     =Hash::make($data['password']);
        $user->save();

        return $user;
       
    }
}
