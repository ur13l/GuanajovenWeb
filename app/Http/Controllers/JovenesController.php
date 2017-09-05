<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\DatosUsuario;

class JovenesController extends Controller
{

    public function index(Request $request){
       $usuarios = User::leftJoin('datos_usuario', 'usuario.id', '=', 'datos_usuario.id_usuario')
       ->where('fecha_nacimiento', '>',Carbon::now('America/Mexico_City')->subYears(30) )->paginate(2);

      //$usuarios = datosUsuario::orderBy('nombre', 'desc')->paginate(3);
      return view('jovenes.index', ['usuarios' => $usuarios]);
    }

    public function nuevo() {
        return view('jovenes.nuevo');
    }

    public function crear(Request $request){
      $this -> validate($request, [
        'nombre' => 'required',
        'apellido_paterno' => 'required',
        'apellido_materno' => 'required',
        'id_genero' => 'required',
        'fecha_nacimiento' => 'required',
        'id_estado_nacimiento' => 'required',
        'codigo_postal' => 'required',
        'telefono' => 'required',
        'curp' => 'required',
        'id_estado' => 'required',
        'id_nivel_estudios' => 'required',
        'id_pueblo_indigena' => 'required',
        'id_capacidad_diferente' => 'required',
        'premios' => 'required',
        'proyectos_sociales' => 'required',
        'apoyo_proyectos_sociales' => 'required',
        'trabaja' => 'required',
        'id_programa_beneficiario' => 'required'
      ]);

      $nombre = $request->input('nombre');
      $apellidoPaterno = $request->input('apellido_paterno');
      $apellidoMaterno = $request->input('apellido_materno');
      $idGenero = $request->input('id_genero');
      $fechaNacimiento = $request->input('fecha_nacimiento');
      $idEstadoNacimiento = $request->input('id_estado_nacimiento');
      $codigoPostal = $request->input('codigo_postal');
      $telefono = $request->input('telefono');
      $curp = $request->input('curp');
      $idEstado = $request->input('id_estado');
      $idNivelEstudios = $request->input('id_nivel_estudios');
      $idPuebloIndigena = $request->input('id_pueblo_indigena');
      $idCapacidadDiferente = $request->input('id_capacidad_diferente');
      $premios = $request->input('premios');
      $proyectosSociales = $request->input('proyectos_sociales');
      $apoyoProyectosSociales = $request->input('apoyo_proyectos_sociales');
      $trabaja = $request->input('trabaja');
      $id_programa_beneficiario = $request->input('id_programa_beneficiario');
      $email = $request->input('email');
      $password = $this->passGenerator();

      $user = User::create(array(
        'email' =>$email,
        'password' =>$password
    ));


      DatosUsuario::create(array(
       'id_usuario' => $user->id,
       'nombre' => $nombre,
       'apellido_paterno' => $apellidoPaterno,
       'apellido_materno' => $apellidoMaterno,
       'id_genero' => $idGenero,
       'fecha_nacimiento' => $fechaNacimiento,
       'id_estado_nacimiento' => $idEstadoNacimiento,
       'codigo_postal' => $codigoPostal,
       'telefono' => $telefono,
       'curp' => $curp,
       'id_estado' => $idEstado,
       'id_nivel_estudios' => $idNivelEstudios,
       'id_pueblo_indigena' => $idPuebloIndigena,
       'id_capacidad_diferente' => $idCapacidadDiferente,
       'premios' => $premios,
       'proyectos_sociales' => $proyectosSociales,
       'apoyo_proyectos_sociales' => $apoyoProyectosSociales,
       'trabaja' => $trabaja,
       'id_programa_beneficiario' => $id_programa_beneficiario
     ));
     return redirect()->back();
    }

    public function passGenerator(){
      //Se define una cadena de caractares.
      $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
      //Obtenemos la longitud de la cadena de caracteres
      $longitudCadena=strlen($cadena);
      
      //Se define la variable que va a contener la contraseña
      $pass = "";
      //Se define la longitud de la contraseña
      $longitudPass=10;
      
      //Creamos la contraseña
      for($i=1 ; $i<=$longitudPass ; $i++){
          //Definimos número aleatorio entre 0 y la longitud de la cadena de caracteres-1
          $pos=rand(0,$longitudCadena-1);
      
          //Vamos formando la contraseña en cada iteración del bucle, añadiendo a la cadena $pass la letra correspondiente a la posición $pos en la cadena de caracteres definida.
          $pass .= substr($cadena,$pos,1);
      }
      return $pass;

    }
//Método para editar joven seleccionado
      public function editar(){
        return view('jovenes.editar');
      }
   /* public function editar(Request $request){
      $id_usuario = $request->input('id_usuario');  
      $usuario = User::find($id_usuario);
      $usuario->update($request->all());
      header('Location: /Prueba1/public/jovenes');
      die();
    }*/

    public function borrar(Request $request){
      $id_usuario = $request->input('id_usuario');
      $usuario = User::find($id_usuario);
      $usuario->delete();
      return redirect()->back();    
    }
}
