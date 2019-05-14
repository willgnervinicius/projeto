<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

     public function username() {
       return 'CgcCpf';
     }



    /** * Validate the user login request. * * @param \Illuminate\Http\Request   $request * @return void
       */ protected function validateLogin(Request $request) {
        $this->validate($request, [ $this->username() => 'required', 'password' => 'required', ]);

       }


/** * Get the needed authorization credentials from the request. * * @param \Illuminate\Http\Request $request * @return array */
      /*  protected function credentials(Request $request) {

        }
            /*$request->only($this->username(), 'password');
            $usuario = ($request->only('UsuSis'));
            $senha = ($request->get('password'));*/

        /*    if (Auth::attempt(['UsuSis' => $usuario, 'password' => $senha])){

                  return redirect('/home');

            //dd($senha);
          } else {
            dd('erro');
          }

*/

        //  }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/selecione';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('guest')->except('logout');

    }
}
