<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'numeric'],
            // 'picture' =>'mimes:jpg,jpeg,png|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        try {
            if ($request->picture) {
                $file = $request->picture;
                $nombre = rand(1,9).$file->getClientOriginalName();
                \Storage::disk('img')->put($nombre,  \File::get($file));
            }


                $user = User::find($id) ;
                if ($user->emai != null &&   $user->emai ==  $request->email) {
                    return back()->with('error','Este correo ya esta en uso');
                }
                $user->name =$request->name;
                $user->cedula   =\Auth::user()->cedula;
                $user->direccion    =$request->address;
                $user->email    =$request->email ? $request->email: \Auth::user()->email ;
                $user->telefono =$request->phone;
                $user->url_img  =isset($nombre)? $nombre: \Auth::user()->url_img;
                $user->save();
                return back()->with('success','Datos guardados');

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
