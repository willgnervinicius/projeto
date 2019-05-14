<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MecanicoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'nome' => 'required|min:3|max:50',
        'obs' => 'max:80',
          ];
          }

          public function messages()
          {
          return [
          'nome.required'=> ' (ATENÇÂO) -  O campo Nome é de preenchimento obrigatório !',
          'nome.min'=> ' (ATENÇÂO) -  O campo Nome deve ter entre 3 e 50 caracteres !',
          'nome.max'=> ' (ATENÇÂO) -  O campo Nome deve ter entre 3 e 50 caracteres !',
          'obs.max'=> ' (ATENÇÂO) -  O campo Observação deve ter no máximo 80 caracteres !',
          ];
        }

}
