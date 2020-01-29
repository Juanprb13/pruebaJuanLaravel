@extends('layouts.app')

@section('content')
<div class="container row">
    <div class="row justify-content-center col-md-5">
        <div class="card" style="width: 18rem;">
    
            <img src="{{ asset(Auth::user()->url_img ? 'img/'.Auth::user()->url_img : 'img/user.jpg') }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{Auth::user()->name}}</h5>
                <hr>
                <p class="card-text"> <b>Cedula : </b> {{Auth::user()->cedula}}</p>
                <hr>
                <p class="card-text"> <b>Correo : </b> {{Auth::user()->email}}</p>
                <hr>
                <p class="card-text"> <b>Telefono : </b> {{Auth::user()->telefono}}</p>
                <hr>
                <p class="card-text"> <b>Dirección : </b> {{Auth::user()->direccion}}</p>
                <hr>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel-info">
            <form action="{{route('user.update',Auth::user()->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                @if(count($errors)>0)
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->get('email') as $message) 
                        <p>{{$message}}</p>
                    @endforeach

                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                        <p>{{(Session::get('error'))}}</p>
                </div>
                @endif
                @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                        <p>{{(Session::get('success'))}}</p>
                </div>
                @endif
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{Auth::user()->name}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="">
                </div>
                <div class="form-group">
                    <label for="cedula">Cedula</label>
                    <input type="number" class="form-control disabled" id="cedula"value="{{Auth::user()->cedula}}" >
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="address" value="{{Auth::user()->direccion}}">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="phone" value="{{Auth::user()->telefono}}">
                </div>
                <div class="form-group">
                    <label for="telefono">Imagen</label>
                    <input type="file" class="form-control" id="picture" name="picture" value="{{Auth::user()}}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
