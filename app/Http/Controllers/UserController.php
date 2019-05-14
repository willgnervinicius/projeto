<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use App\User;
use DB;

class UserController extends Controller
{

  public function index()
  {

$users = DB::table('users')->orderBy('id')->get();
    return view('auth.consultausuario', compact('users'));
  }

  public function consulta (users $users)
  {
      $users = $this->users->paginate(10);
      //pega dos dados, retorno os dados e mostra
      return view('auth.consultausuario', compact('users'));
  }

    public function update_avatar(Request $request){
    	// Handle the user upload of avatar
    	if($request->hasFile('avatar')){
    		$avatar = $request->file('avatar');
    		$filename = time() . '.' . $avatar->getClientOriginalExtension();
    		Image::make($avatar)->resize(300, 300)->save( public_path('img/uploads/avatars/' . $filename ) );
    		$user = Auth::user();
    		$user->avatar = $filename;
    		$user->save();
    	}
    	return view('home');
    }

  }
