@extends('adminlte::page')

@section('title', 'Cronus (ERP)')

@section('js')
<script type="text/javascript">

function enviar(){

                var json = ConvertFormToJSON("#ChatCRNS");
                var Form = this;
                var divPai = $('.direct-chat-messages');
                var Msg = document.getElementById("Msg").value;
                var Usuario = document.getElementById("NomUsu").value;

                document.getElementById("Msg").value='';




                divPai.append("<div class='direct-chat-msg right'>"+
                        "<div class='direct-chat-info clearfix'>"+
                              "<span class='direct-chat-name pull-right'>"+ Usuario +"</span>"+
                              "<span class='direct-chat-timestamp pull-left'>23 Jan 2:05 pm</span>" +
                        "</div>" +
                        "<img class='direct-chat-img' src='{{ asset('/img/') }}/{{ Auth::user()->FotUsu }}'  class='img-circle'>"+
                        "<div class='direct-chat-text'>" +
                               Msg +
                        "</div>" +
                    "</div>"+
                    "</div>"
                  );




	$.ajax({

			type: "GET",
			dataType : "json",
		  data : json,
		  context : Form,
			//data: {CgcMat: $("#CgcMat").val()},
			url: "/chat/conversa/"+{DesMsg : Msg},
			success: function(Retorno) {
				var status = (Retorno.Status);



        if (status ="OK"){

          var option = new Array();//resetando a variável

          var Cabecalho , Mensagem ;

          Cabecalho = "<div class='direct-chat-msg'>"+
                  "<div class='direct-chat-info clearfix'>"+
                        "<span class='direct-chat-name pull-left'>Plinio (Assistente Virtual)</span>"+
                        "<span class='direct-chat-timestamp pull-right'>23 Jan 2:05 pm</span>" +
                  "</div>";

         if(Msg == "1"){
                Mensagem = "<img class='direct-chat-img' src='{{ asset('/img/') }}/avatar5.png'  class='img-circle'>"+
                "<div class='direct-chat-text pull-left'>" +
                  "4 - Consultar Chamado <br>" +
                  "5 - Cancelar Chamado <br>" +

                "</div>" +
            "</div>"
          } else if (Msg == "4"){
                Mensagem = "<img class='direct-chat-img' src='{{ asset('/img/') }}/avatar5.png'  class='img-circle'>"+
                "<div class='direct-chat-text pull-left'>" +
                  "Informe o Numero do Chamado" +

                "</div>" +
            "</div>"
          }
          else if (Msg == "5"){
                  Mensagem = "<img class='direct-chat-img' src='{{ asset('/img/') }}/avatar5.png'  class='img-circle'>"+
                  "<div class='direct-chat-text pull-left'>" +
                    "Informe o Numero do Chamado" +
                  "</div>" +
              "</div>"
          }




                divPai.append( Cabecalho + Mensagem

                  );
      }
		}


	});

};


function ConvertFormToJSON(form){
					 //console.log('ConvertFormToJSON invoked!');
					 var array = jQuery(form).serializeArray();
					 var json = {};

					 jQuery.each(array, function() {
							 json[this.name] = this.value || '';
					 });

					 //console.log('JSON: '+json);
					 return json;
			 }





 </script>


@section('content_header')
<div class="row">
        <div class="col-sm-4">
          <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-blue"><i class="fa fa-cloud"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Notas Emitidas</span>
              <span class="info-box-number">93,139</span>
            </div>
            <!-- /.info-box-content -->
            </div>
        </div>


        <div class="col-sm-4">
          <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-red"><i class="fa fa-bank"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Contas a Pagar</span>
              <span class="info-box-number">93,139</span>
            </div>
            <!-- /.info-box-content -->
            </div>
          </div>


        <div class="col-sm-4">
          <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-green"><i class="fa fa-barcode"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Contas a Receber</span>
              <span class="info-box-number">93,139</span>
            </div>
            <!-- /.info-box-content -->
            </div>
        </div>
</div>


<input type="hidden" name="NomUsu" id="NomUsu" value="{{ Auth::user()->NomUsu }}" />
</form>



@stop

@section('content')

@stop
