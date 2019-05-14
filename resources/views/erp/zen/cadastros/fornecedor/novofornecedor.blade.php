@extends('adminlte::page')

@section('title', 'Cronus (ERP)')

@section('content_header')
@stop

@section('css')

<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">


<style type="text/css">
.modal {
text-align: center;
padding: 0!important;

}

.modal:before {
content: '';
display: inline-block;
height: 100%;
vertical-align: middle;
margin-right: -4px;

}

.modal-dialog {
display: inline-block;
text-align: left;
vertical-align: middle;
}



</style>

@stop

@section('js')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>


<script type="text/javascript">

var CpfCnpjMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
		},
    cpfCnpjpOptions = {
    	onKeyPress: function(val, e, field, options) {
      	field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
      }
    };

$(function() {
	$(':input[name=CgcCpf]').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
})


$(document).ready(function(){
  var Fornecedor = JSON.parse(sessionStorage.getItem('CodigoFornecedor'));

  $('#CodFor').val(Fornecedor);

  ConsultaCodigo();

  

  sessionStorage.removeItem('CodigoFornecedor');

});



   $("#CepFor").focusout(function(){
          var CepConsulta = $("#CepFor").val();
          var Cep = CepConsulta.replace(/\D/g, '');


          ConsultaCep(Cep);

   });


   $("#CgcCpf").focusout(function(){
        
       
        ConsultaCgcCpf();
   });

   function ConvertFormToJSON(form){
					 
					 var array = jQuery(form).serializeArray();
					 var json = {};

					 jQuery.each(array, function() {
							 json[this.name] = this.value || '';
					 });

					 
					 return json;
	}

   
  function ConsultaCgcCpf(){

    var json = ConvertFormToJSON("#CadastroFornecedor");
    var Form = this;
    var Fornecedor = $('#CgcCpf').val();

    $('#myModal').modal('show');
                  

                   	$.ajax({


                   			type: "GET",
                   			dataType : "json",
                   		  data : json,
                   		  context : Form,
                   			url: "/consulta/cadastro/geral/fornecedor/cnpj/"+{CgcCpf : Fornecedor},

                   			success: function(RetornaFornecedor) {
                            var status = (RetornaFornecedor.Status);

                            if(status == "Ok"){

                                  var CgcCpf = $("#CgcCpf").val();
                                  var QtdNumerosCgcCpf = CgcCpf.length;

                                  if(QtdNumerosCgcCpf == 18){
                                    $('#NumRge').prop('readonly', true);
                                    $('#InsEst').prop('readonly', false);
                                    $('#InsSuf').prop('readonly', false);
                                  

                                    

                                  } else if (QtdNumerosCgcCpf == 14) {

                                        $('#NumRge').prop('readonly', false);
                                        $('#InsEst').prop('readonly', true);
                                        $('#InsSuf').prop('readonly', true);
                                        

                                  }

                                  $('#CodFor').val(RetornaFornecedor.CodFor);
                                  $('#RazSoc').val(RetornaFornecedor.RazSoc);
                                  $('#TipFor').val(RetornaFornecedor.TipFor);
                                  $('#TipoFornecedor').val(RetornaFornecedor.TipFor);
                                  $('#RamAtv').val(RetornaFornecedor.RamAtv);
                                  $('#TriIcm').val(RetornaFornecedor.TriIcm);
                                  $('#CodCli').val(RetornaFornecedor.CodCli);
                                  $('#NumRge').val(RetornaFornecedor.NumRge);
                                  $('#InsEst').val(RetornaFornecedor.InsEst);
                                  $('#InsSuf').val(RetornaFornecedor.InsSuf);
                                  $('#TelFor').val(RetornaFornecedor.TelFor);
                                  $('#NumFax').val(RetornaFornecedor.NumFax);
                                  $('#IntNet').val(RetornaFornecedor.IntNet);
                                  $('#SitFor').val(RetornaFornecedor.SitFor);
                                  
                                  $('#CepFor').val(RetornaFornecedor.CepFor);
                                  $('#EndFor').val(RetornaFornecedor.EndFor);
                                  $('#NumFor').val(RetornaFornecedor.NumFor);
                                  $('#CplFor').val(RetornaFornecedor.CplFor);
                                  $('#BaiFor').val(RetornaFornecedor.BaiFor);
                                  $('#CidFor').val(RetornaFornecedor.CidFor);
                                  $('#UfsFor').val(RetornaFornecedor.UfsFor);
                                  $('#PaiFor').val(RetornaFornecedor.PaiFor);
                                  $('#MunFor').val(RetornaFornecedor.MunFor);


                                  $('#CidFor').prop('readonly', true);
                                  $('#UfsFor').prop('readonly', true);
                                  $('#MunFor').prop('readonly', true);
                                  $('#BaiFor').prop('readonly', true);
                                  $('#EndFor').prop('readonly', true);
                                  $("#PaiFor").prop('readonly', true);
                            } else {
                                  var CgcCpf = $("#CgcCpf").val();
                                  var QtdNumerosCgcCpf = CgcCpf.length;

                                  if(QtdNumerosCgcCpf == 18){
                                    $('#NumRge').prop('readonly', true);
                                    $('#InsEst').prop('readonly', false);
                                    $('#InsSuf').prop('readonly', false);
                                  

                                    document.getElementById('NumRge').value = '';
                                    document.getElementById('TipFor').value = 'J';
                                    document.getElementById('TipoFornecedor').value = 'J';

                                  } else if (QtdNumerosCgcCpf == 14) {

                                        $('#NumRge').prop('readonly', false);
                                        $('#InsEst').prop('readonly', true);
                                        $('#InsSuf').prop('readonly', true);
                                        document.getElementById('InsEst').value = '';
                                        document.getElementById('InsSuf').value = '';
                                        document.getElementById('TipFor').value = 'F';
                                        document.getElementById('TipoFornecedor').value = 'F';
                                        document.getElementById('TriIcm').value = 'N';

                                  }
                            }

                   			}


                   	});

          $('#myModal').modal('hide');



  }

function ConsultaCodigo(){

      var json = ConvertFormToJSON("#CadastroFornecedor");
      var Form = this;
      var Fornecedor = $('#CodFor').val();

     
                    

                      $.ajax({


                          type: "GET",
                          dataType : "json",
                          data : json,
                          context : Form,
                          url: "/consulta/cadastro/geral/fornecedor/codigo/"+{CodFor : Fornecedor},

                          success: function(RetornaFornecedor) {
                              var status = (RetornaFornecedor.Status);
                              var CgcCpf = (RetornaFornecedor.CgcCpf);

                              if(status == "Ok"){

                                    
                                    var QtdNumerosCgcCpf = CgcCpf.length;

                                    if(QtdNumerosCgcCpf == 18){
                                      $('#NumRge').prop('readonly', true);
                                      $('#InsEst').prop('readonly', false);
                                      $('#InsSuf').prop('readonly', false);
                                    

                                      

                                    } else if (QtdNumerosCgcCpf == 14) {

                                          $('#NumRge').prop('readonly', false);
                                          $('#InsEst').prop('readonly', true);
                                          $('#InsSuf').prop('readonly', true);
                                          

                                    }

                                    
                                    $('#RazSoc').val(RetornaFornecedor.RazSoc);
                                    $('#CgcCpf').val(RetornaFornecedor.CgcCpf);
                                    $('#TipFor').val(RetornaFornecedor.TipFor);
                                    $('#TipoFornecedor').val(RetornaFornecedor.TipFor);
                                    $('#RamAtv').val(RetornaFornecedor.RamAtv);
                                    $('#TriIcm').val(RetornaFornecedor.TriIcm);
                                    $('#CodCli').val(RetornaFornecedor.CodCli);
                                    $('#NumRge').val(RetornaFornecedor.NumRge);
                                    $('#InsEst').val(RetornaFornecedor.InsEst);
                                    $('#InsSuf').val(RetornaFornecedor.InsSuf);
                                    $('#TelFor').val(RetornaFornecedor.TelFor);
                                    $('#NumFax').val(RetornaFornecedor.NumFax);
                                    $('#IntNet').val(RetornaFornecedor.IntNet);
                                    $('#SitFor').val(RetornaFornecedor.SitFor);
                                    
                                    $('#CepFor').val(RetornaFornecedor.CepFor);
                                    $('#EndFor').val(RetornaFornecedor.EndFor);
                                    $('#NumFor').val(RetornaFornecedor.NumFor);
                                    $('#CplFor').val(RetornaFornecedor.CplFor);
                                    $('#BaiFor').val(RetornaFornecedor.BaiFor);
                                    $('#CidFor').val(RetornaFornecedor.CidFor);
                                    $('#UfsFor').val(RetornaFornecedor.UfsFor);
                                    $('#PaiFor').val(RetornaFornecedor.PaiFor);
                                    $('#MunFor').val(RetornaFornecedor.MunFor);


                                    $('#CidFor').prop('readonly', true);
                                    $('#UfsFor').prop('readonly', true);
                                    $('#MunFor').prop('readonly', true);
                                    $('#BaiFor').prop('readonly', true);
                                    $('#EndFor').prop('readonly', true);
                                    $("#PaiFor").prop('readonly', true);
                              } else {
                                    var CgcCpf = $("#CgcCpf").val();
                                    var QtdNumerosCgcCpf = CgcCpf.length;

                                    if(QtdNumerosCgcCpf == 18){
                                      $('#NumRge').prop('readonly', true);
                                      $('#InsEst').prop('readonly', false);
                                      $('#InsSuf').prop('readonly', false);
                                    

                                      document.getElementById('NumRge').value = '';
                                      document.getElementById('TipFor').value = 'J';
                                      document.getElementById('TipoFornecedor').value = 'J';

                                    } else if (QtdNumerosCgcCpf == 14) {

                                          $('#NumRge').prop('readonly', false);
                                          $('#InsEst').prop('readonly', true);
                                          $('#InsSuf').prop('readonly', true);
                                          document.getElementById('InsEst').value = '';
                                          document.getElementById('InsSuf').value = '';
                                          document.getElementById('TipFor').value = 'F';
                                          document.getElementById('TipoFornecedor').value = 'F';
                                          document.getElementById('TriIcm').value = 'N';

                                    }
                              }

                          }


                      });

           



}




function ConsultaCep(NumCep){
  var CEP = NumCep;

  $.ajax({
   //O campo URL diz o caminho de onde virá os dados
   //É importante concatenar o valor digitado no CEP
   url: 'https://viacep.com.br/ws/'+CEP+'/json/unicode/',
   //Aqui você deve preencher o tipo de dados que será lido,
   //no caso, estamos lendo JSON.
   dataType: 'json',
   //SUCESS é referente a função que será executada caso
   //ele consiga ler a fonte de dados com sucesso.
   //O parâmetro dentro da função se refere ao nome da variável
   //que você vai dar para ler esse objeto.
   success: function(resposta){
     //Agora basta definir os valores que você deseja preencher
     //automaticamente nos campos acima.

     $('#CidFor').prop('readonly', true);
     $('#UfsFor').prop('readonly', true);
     $('#MunFor').prop('readonly', true);
     $('#BaiFor').prop('readonly', true);
     $('#EndFor').prop('readonly', true);
     $("#CplFor").val(resposta.complemento);
     $("#BaiFor").val(resposta.bairro);
     $("#CidFor").val(resposta.localidade);
     $("#EndFor").val(resposta.logradouro);
     $("#UfsFor").val(resposta.uf);
     $("#MunFor").val(resposta.ibge);
     $("#PaiFor").val('1058');
     $("#PaiFor").prop('readonly', true);


     //Vamos incluir para que o Número seja focado automaticamente
     //melhorando a experiência do usuário
     $("#NumFor").focus();


}
});

}

function mascara(t, mask){
      var i = t.value.length;
      var saida = mask.substring(1,0);
      var texto = mask.substring(i)
      if (texto.substring(0,1) != saida){
      t.value += texto.substring(0,1);
      }
}

function mascaraData( campo, e )
{
	var kC = (document.all) ? event.keyCode : e.keyCode;
	var data = campo.value;

	if( kC!=8 && kC!=46 )
	{
		if( data.length==2 )
		{
			campo.value = data += '/';
		}
		else if( data.length==5 )
		{
			campo.value = data += '/';
		}
		else
			campo.value = data;
	}
}

document.getElementById("endereco").style.display = "none";
document.getElementById("endereco").style.display = "none";

function LimparFormulario(){
  $('#CadastroFornecedor').each (function(){
      this.reset();
    });


   

}



function mostraendereco(){
  document.getElementById("endereco").style.display = "";
  document.getElementById("dados").style.display = "none";
}


function voltadados(){
      document.getElementById("dados").style.display = "";
      document.getElementById("endereco").style.display = "none";
}




function validardados(){
  var RazSoc = $('#RazSoc').val();
  var CgcCpf = $('#CgcCpf').val();
  var TipFor = $('#TipFor').val();

  if(TipFor=="F"){
        var NumRge = $('#NumRge').val();

        if((RazSoc == '') || (CgcCpf == '') || (NumRge =='') ) {
                swal('Advertência'," Campos com * são Obrigatórios quando Habilitados", "error");
        } else{
          mostraendereco();
        }


  }else {
    var InsEst = $('#InsEst').val();
    if((RazSoc == '') || (CgcCpf == '') || (InsEst =='') ) {
            swal('Advertência'," Campos com * são Obrigatórios quando Habilitados", "error");
    } else{
      mostraendereco();
    }
  }
}




function validarendereco(){
  var CepCli = $('#CepCli').val();
  var NumCli = $('#NumCli').val();
  var EndCli = $('#EndCli').val();


    if((CepCli == '') || (NumCli == '')|| (EndCli == '')   ) {
            swal('Advertência'," Campos com * são Obrigatórios", "error");
    } else{
      salvar();
    }

}


function salvar(){
	//var data = {}
    var json = ConvertFormToJSON("#CadastroFornecedor");
    var Form = this;
  
    $('#myModal').modal('show');
	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			url: "/cadastro/fornecedor",
			success: function(Retorno) {
				var status = (Retorno.Status);

				

			  if (status =="OK") {
           $('#myModal').modal('hide');
					 var Msg = (Retorno.Mensagem);
             swal(Msg," ", "success");
						 LimparFormulario();
				}else {
						CadastronaoRealizado();
				}
			}


	});

};


 </script>



@stop

@section('content')

<!--Inicio-->
<div class="page-header">

<center>
  <h3> Cadastro de Fornecedor</h3>
</center>
</div>
<div>
<body >



<form class="form"  id="CadastroFornecedor" method="post"  >

{!! csrf_field() !!}



     <div class="container">
     			<div id="Fornecedor">
             <div id="dados">
                  <div class="row">
                    <div class="col-md-12">
                      <h4>  <i class="fa fa-user-o" aria-hidden="true"></i> Dados do Fornecedor  </h4>
                    </div>
                  </div>

                  <div class="row">
                        <div class="col-md-2">
                          <label for="CodEmp">Código </label>
                          <div class="input-group">
                              <input class="form-control" type="text" id="CodFor" name="CodFor"    placeholder="Código" />
                              <div class="input-group-btn">
                                <button type="button" class="btn btn-info" onclick="ConsultaCodigo()">
                                  <span class="fa fa-search"></span>
                                </button>
                              </div>
                            </div>
                          </div>
                    </div>


                    <div class="row">
                    <div class="col-md-3">
                                <label for="GruEmp">*CPF/CNPJ</label>
                                <div class="input-group">
                                            <input class="form-control" type="text" id="CgcCpf" name="CgcCpf"  placeholder="CPF/CNPJ" required/>
                                                <div class="input-group-btn">
                                                  <button type="button" class="btn btn-info" onclick="ConsultaCgcCpf()">
                                                      <span class="fa fa-search"></span>
                                                    </button>
                                                  </div>
                                    </div>
                              </div>


                        <div class="col-md-6">
                              <label for="NomFan">*Nome / Razão Social </label>
                              <input class="form-control" type="text" id="RazSoc" name="RazSoc"  placeholder="Nome / Razão Social" style="text-transform: uppercase;" required/>
                        </div>
                  </div>


                  <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                              <label for="TipFor">Tipo Fornecedor</label>
                                              <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TipFor" name="TipFor" disabled>
                                                  <option selected value="F">Pessoa Física</option>
                                                  <option value="J">Pessoa Jurídica</option>
                                              </select>
                                              <input type="hidden" id="TipoFornecedor" name="TipoFornecedor" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="RamAtv">Ramo de Atividade</label>
                                <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="RamAtv" name="RamAtv" >
                                    <option selected value="C">Comercial</option>
                                    <option value="I">Industrial</option>
                                    <option value="S">Prestação de Serviços</option>
                                    <option  value="CO">Consumidor</option>
                                </select>
                            </div>
                          </div>

                          <div class="col-md-2">
                              <div class="form-group">
                                    <label for="TriIcm">Tributa ICMS</label>
                                    <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TriIcm" name="TriIcm" >
                                        <option selected value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select>
                              </div>
                          </div>

                          <div class="col-md-2">
                              <label for="GruEmp">Código Cliente</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" id="CodCli" name="CodCli" placeholder=" Cliente como Fornecedor" disabled />
                                </div>
                              </div>
                  </div>



                 
            
            
           
                 <div class="row">
                         <div class="col-md-3">
                                  <label for="GruEmp">*RG</label>
                                  <input class="form-control" type="text" id="NumRge" name="NumRge"  placeholder="RG" readonly />
                         </div>

                          <div class="col-md-3">
                                  <label for="GruEmp">*Inscrição Estadual</label>
                                  <input class="form-control" type="text" id="InsEst" name="InsEst"  placeholder="Inscrição Estadual" readonly />
                          </div>

                          <div class="col-md-3">
                                    <label for="GruEmp">Inscrição Suframa</label>
                                    <input class="form-control" type="text" id="InsSuf" name="InsSuf"  placeholder="Inscrição Suframa" readonly />
                          </div>
                 </div>


                <div class="row">
                    <div class="col-md-2">
                        <label for="GruEmp"><i class="fa fa-phone" aria-hidden="true"></i> Telefone</label>
                        <input class="form-control" type="text" id="TelFor" name="TelFor" maxlength="12" onkeypress="mascara(this, '##-#########')"  placeholder="Telefone" />
                      </div>

                      <div class="col-md-2">
                          <label for="GruEmp"><i class="fa fa-fax" aria-hidden="true"></i> Fax</label>
                          <input class="form-control" type="text" id="NumFax" name="NumFax" maxlength="12"  onkeypress="mascara(this, '##-####-####')" maxlength="12"
                          placeholder="Fax" />
                        </div>

                        <div class="col-md-4">
                            <label for="GruEmp"><i class="fa fa-envelope-o" aria-hidden="true"></i> * E-mail</label>
                            <input class="form-control" type="email" id="IntNet" name="IntNet" placeholder="E-mail"  requerid/>
                        </div>

                    </div>

                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                          <label for="TipTit">Situação</label>
                          <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitFor" name="SitFor" required>
                              <option selected value="A">Ativo</option>
                              <option value="I">Inativo</option>
                          </select>
                      </div>
                    </div>
                </div>

                <div class="container-fluid">
                            <div class="row">
                                  <div class="col-md-2">
                                        <button type="button" name="btnlimpar" onclick="LimparFormulario()"   class="btn btn-danger btn-sm custom-button-width"><i class="fa fa-refresh" aria-hidden="true"></i>  Limpar</button>
                                  </div>
                                <div class="col-md-6 text-right">
                                    <button  name="btnmostraendereco"  onclick="validardados()" type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-arrow-right" aria-hidden="true"></i>  Próximo</button>
                                 </div>
                            </div>
                </div>

          </div>


                <div id="endereco">
                    <div class="row">
                          <div class="col-md-12">
                            <h4> <i class="fa fa-truck" aria-hidden="true"></i> Endereço   </h4>

                          </div>
                    </div>

                          <div class="row">
                              <div class="col-md-2">
                                  <label for="Cep">* Cep</label>
                                  <input class="form-control" type="text" id="CepFor" name="CepFor" placeholder="Cep"
                                  onkeypress="mascara(this, '##.###-###')" maxlength="10" required/>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-6">
                                  <label for="Cep">* Endereço</label>
                                  <input class="form-control" type="text" id="EndFor" name="EndFor" placeholder="Endereço" required/>
                              </div>

                              <div class="col-md-2">
                                  <label for="NumCli">* Número</label>
                                  <input class="form-control" type="text" id="NumFor" name="NumFor" placeholder="Numero"  required/>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-3">
                                  <label for="Cep">Complemento</label>
                                  <input class="form-control" type="text" id="CplFor" name="CplFor" placeholder="Complemento" />
                              </div>

                              <div class="col-md-3">
                                  <label for="Cep">* Bairro</label>
                                  <input class="form-control" type="text" id="BaiFor" name="BaiFor" placeholder="Bairro " required/>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-3">
                                  <label for="Cep">* Cidade</label>
                                  <input class="form-control" type="text" id="CidFor" name="CidFor" placeholder="Cidade" required/>
                              </div>

                              <div class="col-md-2">
                                  <label for="Cep">* Estado</label>
                                  <input class="form-control" type="text" id="UfsFor" Size="2" name="UfsFor"  placeholder="Estado" required/>
                              </div>
                          </div>

                         
                        <div class="row">
                            <div class="col-md-2">
                                <label for="Cep">* Código País</label>
                                <input class="form-control" type="text" id="PaiFor" name="PaiFor" placeholder="Código País" />
                            </div>
                            
                            <div class="col-md-2">
                                <label for="Cep">* Código Municipio IBGE</label>
                                <input class="form-control" type="text" id="MunFor" name="MunFor"  placeholder="Código Municipo Ibge" required/>
                            </div>
                        </div>

                              <br>
                                <div class="row">
                                      <div class="col-md-2">
                                            <button type="button" name="btnvoltaendereco" onclick="voltadados()" class="btn btn-primary btn-sm custom-button-width"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Anterior</button>
                                      </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" name="btnmostrafiscal"  onclick="validarendereco()" class="btn btn-primary btn-sm custom-button-width .navbar-right"> <i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
                                     </div>

                  </div>



                          </div>

</div>
    <input type="hidden" name="CodUsu" value="{{ Auth::user()->CodUsu }}">
</div>

<br>
</form>
</div>
</div>
</div>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class=" modal-dialog modal-sm  modal-dialog-centered" role="document">
    <div class="modal-content">
      <center>
      <img src="/img/aguarde.gif" width="100px" height="100px" >
    </center>
    </div>
  </div>
</div>

@stop
