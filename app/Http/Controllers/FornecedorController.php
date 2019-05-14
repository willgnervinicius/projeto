<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FornecedorController extends Controller
{
  public function index()
  {
      return view('fornecedor.consultafornecedor');
  }


  public function processar()
  {
    return view('fornecedor.novofornecedor');
  }
}
