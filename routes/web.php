<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
        return redirect('login')->with(Auth::logout());
});






Route::get('/recuperacao/senha', 'RecuperacaoSenhaController@index');
Route::post('/recuperacao/senha', 'RecuperacaoSenhaController@resgatarsenha');

Auth::routes();
                        Route::post('/sair', 'SelecionaEmpresaFilialController@Deslogar')->name('sair');
                        Route::get('/home', 'HomeController@index')->name('home');

                        Route::get('/movimentacao/estoque', 'MovimentacaoEstoqueController@index')->name('movimentacao');

                        /*Selecão Empresa e Filial */
                        Route::get('/selecione', 'SelecionaEmpresaFilialController@index')->name('selecione');
                        Route::get('/seleciona/filial/{CodEmp}','SelecionaEmpresaFilialController@ConsultaFilial');
                        Route::get('/seleciona/empresa/','SelecionaEmpresaFilialController@ListarEmpresa');
                        Route::post('/logar','SelecionaEmpresaFilialController@logarempresa');



                        /*Cadastro Transportadora */
                        Route::get('/cadastro/transportadora',['as'=>'cadastro.transportadora','uses'=>'CadastroTransportadoraController@index']);
                        Route::get('/consulta/transportadora/cgccpf/{CgcCpf}',['as'=>'consulta.transportadora.cgccpf','uses'=>'CadastroTransportadoraController@consultarcgccpf']);
                        Route::get('/consulta/transportadora/codigo/{CodTra}',['as'=>'cadastro.transportadora.codtra','uses'=>'CadastroTransportadoraController@consultarcodigo']);
                        Route::post('/nova/transportadora',['as'=>'nova.transportadora','uses'=>'CadastroTransportadoraController@processar']);

                        /*Representante*/
                        Route::get('/cadastro/representante',['as'=>'cadastro.representante','uses'=>'CadastroRepresentanteController@index']);
                        Route::get('/consulta/representante/cgccpf/{CgcCpf}',['as'=>'consulta.representante.cgccpf','uses'=>'CadastroRepresentanteController@consultarcgccpf']);
                        Route::get('/consulta/representante/codigo/{CodTra}',['as'=>'cadastro.representante.codigo','uses'=>'CadastroRepresentanteController@consultarcodigo']);
                        Route::post('/novo/representante',['as'=>'nova.representante','uses'=>'CadastroRepresentanteController@processar']);





                        /* Usuário */

                        Route::get('/consultausuario', 'UserController@index')->name('consultausuario');
                        Route::post('/cadastro/usuario','RegistroUsuarioController@processar');
                        Route::get('/ligacao/usuario/filial', 'LigacaoEmpresaUsuarioController@index');
                        Route::get('/consulta/filial/ligacao/{CodFil}', 'LigacaoEmpresaUsuarioController@consultaFilial');
                        Route::get('/consulta/nome/usuario/{CgcCpf}', 'LigacaoEmpresaUsuarioController@consultaUsuario');
                        Route::get('/excluir/ligacao/filial/usuario/{CgcCpf}', 'LigacaoEmpresaUsuarioController@excluir');
                        Route::post('/ligacao/usuario/filial', 'LigacaoEmpresaUsuarioController@adicionar');

                        Route::get('/sms',['as'=>'cadastro.sms','uses'=>'CadastroEnvioSmsController@index']);

                        Route::post('/sms',['as'=>'cadastro.sms.processar','uses'=>'CadastroEnvioSmsController@processar']);

                        /* Cadastro Produto */
                        Route::get('/cadastro/produto',['as'=>'cadastro.produto','uses'=>'CadastroProdutoController@index']);
                        Route::post('/novo/produto',['as'=>'cadastro.novo.produto','uses'=>'CadastroProdutoController@processar']);
                        Route::get('/novo/produto/grupo/{CodDep}',['as'=>'novo.produto.grupo','uses'=>'CadastroProdutoController@ConsultaGrupo']);
                        Route::get('/novo/produto/subgrupo/{CodGru}',['as'=>'novo.produto.subgrupo','uses'=>'CadastroProdutoController@ConsultaSubGrupo']);
                        Route::get('/consulta/cadastro/produto/{CodPro}',['as'=>'consulta.produto','uses'=>'CadastroProdutoController@ConsultarProduto']);
                        Route::get('/consulta/descricao/produto/{CodPro}',['as'=>'consulta.descricao.produto','uses'=>'CadastroProdutoController@ConsultarDescricaoProduto']);
                        Route::get('/consulta/movimentacao/estoque/produto/{CodPro}',['as'=>'consulta.movimentacao.estoque.produto','uses'=>'CadastroProdutoController@ConsultarMovimentacaoEstoqueProduto']);

                        /*Estoque */
                        Route::get('/saida/estoque',['as'=>'saida.estoque','uses'=>'SaidaEstoqueController@index']);
                        Route::post('/saida/estoque',['as'=>'saida.estoque','uses'=>'SaidaEstoqueController@processar']);
                        Route::get('/entrada/estoque',['as'=>'entrada.estoque','uses'=>'EntradaEstoqueController@index']);
                        Route::post('/entrada/estoque',['as'=>'entrada.estoque','uses'=>'EntradaEstoqueController@processar']);
                        Route::get('/movimentacao/estoque/troca',['as'=>'entrada.estoque','uses'=>'MovimentacaoEstoqueTrocaController@index']);
                        Route::get('/inventario/estoque',['as'=>'inventario.estoque','uses'=>'InventarioController@index']);
                        Route::post('/inventario/estoque',['as'=>'inventario.estoque','uses'=>'InventarioController@processar']);
                        Route::post('/inventario/movimenta/produto/estoque',['as'=>'inventario.movimenta.produto.estoque','uses'=>'InventarioController@atualizarprodutoinventario']);
                        Route::post('/inventario/imprimir/listagem',['as'=>'inventario.imprimir.listagem','uses'=>'InventarioController@GerarPdf']);
                        Route::post('/efetivar/inventario',['as'=>'efetivar.inventario','uses'=>'InventarioController@Efetivar']);

                        /*Compras*/
                        Route::get('/nota/fiscal/compra',['as'=>'nota.fiscal.compra','uses'=>'NotaFiscalEntradaController@index']);

                        /* Vendas */
                        /* Nota Fiscal de Sáida */
                                Route::get('/nota/fiscal/saida','NotaFiscaSaidaController@index');
                                Route::get('/gera/nota','NotaFiscaSaidaController@GeraNota');
                                Route::post('/salvar/capa/nota','NotaFiscaSaidaController@SalvaCapaNfe');
                                Route::post('/atualizar/capa/nota','NotaFiscaSaidaController@AtualizarCapaNfe');
                                Route::get('/gerar/parcelas/nota/','NotaFiscaSaidaController@gerarparcelas');



                        /* Cadastro Departamento */
                        Route::get('/cadastro/departamento',['as'=>'cadastro.departamento','uses'=>'CadastroDepartamentoSecaoController@index']);
                        Route::post('/cadastro/departamento',['as'=>'cadastro.departamento.processar','uses'=>'CadastroDepartamentoSecaoController@processar']);


                        /* Cadastro Grupo */
                        Route::get('/cadastro/grupo',['as'=>'cadastro.grupo','uses'=>'CadastroGrupoController@index']);
                        Route::post('/cadastro/grupo',['as'=>'cadastro.grupo.processar','uses'=>'CadastroGrupoController@processar']);


                        /* Cadastro SubGrupo */
                        Route::get('/cadastro/subgrupo',['as'=>'cadastro.subgrupo','uses'=>'CadastroSubGrupoController@index']);
                        Route::post('/cadastro/subgrupo',['as'=>'cadastro.subgrupo.processar','uses'=>'CadastroSubGrupoController@processar']);


                        /* Cadastro Tributação */
                        Route::get('/cadastro/tributacao',['as'=>'cadastro.subgrupo','uses'=>'CadastroTributacaoController@index']);
                        Route::get('/consulta/cadastro/transacao/{CodTns}',['as'=>'consulta.produto','uses'=>'CadastroTributacaoController@consultarCfop']);
                        Route::get('/consulta/cadastro/transacao/entrada/{CodTns}',['as'=>'consulta.transacao.entrada','uses'=>'ControllerConsultaGerais@consultarCfopEntrada']);
                        Route::get('/consulta/cadastro/transacao/saida/{CodTns}','ControllerConsultaGerais@consultarCfopSaida');
                        Route::get('/consulta/cadastro/produto/tributacao/{CodTns}',['as'=>'consulta.produto','uses'=>'CadastroTributacaoController@ConsultaProduto']);
                        Route::post('/cadastro/tributacao/produto',['as'=>'cadastro.tributacao.produto','uses'=>'CadastroTributacaoController@processar']);
                        //Route::post('/cadastro/subgrupo',['as'=>'cadastro.subgrupo.processar','uses'=>'CadastroSubGrupoController@processar']);

                        
                        /*Cadastro Cliente */
                        Route::get('/cadastro/cliente',['as'=>'cadastro.cliente','uses'=>'CadastroClienteController@index']);
                        Route::get('/cadastro/cliente/{CodFil}',['as'=>'cadastro.cliente','uses'=>'CadastroClienteController@consultar']);
                        Route::post('/cadastro/cliente',['as'=>'cadastro.cliente','uses'=>'CadastroClienteController@processar']);
                        Route::get('/consulta/cadastro/cliente/geral/{CgcCpf}',['as'=>'consulta.cadastro.cliente','uses'=>'CadastroClienteController@consultarclientecgc']);
                        Route::get('/consulta/cadastro/cliente/geral/codigo/{CodCli}',['as'=>'consulta.cadastro.cliente','uses'=>'CadastroClienteController@consultarclientecodigo']);
                        Route::get('/consulta/cadastro/cliente',['as'=>'cadastro.cliente','uses'=>'CadastroClienteController@indexConsulta']);
                        Route::get('/consulta/cadastro/cliente/{CodCli}',['as'=>'cadastro.cliente','uses'=>'CadastroClienteController@buscarcliente']);


                        /*Cadastro Fornecedor */
                        Route::get('/cadastro/fornecedor','CadastroFornecedorController@index');
                        Route::post('/cadastro/fornecedor','CadastroFornecedorController@processar');
                        Route::get('/consulta/cadastro/geral/fornecedor/codigo/{CodFor}','CadastroFornecedorController@consultarfornecedorcodigo');
                        Route::get('/consulta/cadastro/geral/fornecedor/cnpj/{CgcCpf}','CadastroFornecedorController@consultarfornecedorcgc');
                        Route::get('/consulta/cadastro/fornecedor','CadastroFornecedorController@indexConsulta');
                        Route::get('/consulta/cadastro/fornecedor/{CodFor}','CadastroFornecedorController@buscarfornecedor');

                        /* Cadastro Centro de Custo */
                        Route::get('/cadastro/centro/custo',['as'=>'cadastro.centro.custo','uses'=>'CentrodeCustoController@index']);
                        Route::post('/cadastro/centro/custo',['as'=>'cadastro.centro.custo','uses'=>'CentrodeCustoController@processar']);
                        Route::get('/consulta/centro/custo/{CocCcu}',['as'=>'cadastro.centro.custo','uses'=>'CentrodeCustoController@consultar']);


                        Route::get('/cadastro/empresa',['as'=>'cadastro.empresa','uses'=>'EmpresaController@index']);
                       
                        
                        Route::post('/cadastro/empresa',['as'=>'cadastro.empresa.processar','uses'=>'EmpresaController@processar']);
                       


                        Route::post('/nova/empresa',['as'=>'nova.empresa','uses'=>'EmpresaController@processar']);
                        Route::get('/nova/empresa',['as'=>'nova.empresa','uses'=>'EmpresaController@index']);

                        Route::get('/nova/empresa/{CgcEmp}',['as'=>'nova.empresa','uses'=>'EmpresaController@ConsultaEmpresa']);
                        Route::get('/nova/empresa/{CgcMat}',['as'=>'nova.empresa','uses'=>'EmpresaController@ConsultaEmpresaCGC']);


                        /*Cadastro de Filial */
                        Route::get('/cadastro/filial','FilialController@index');
                        Route::post('/cadastro/filial','FilialController@processar');
                        Route::get('/consulta/cadastro/filial/{CodEmp}','FilialController@consultar');
                        Route::get('/consulta/empresa/x/filial/{CodEmp}','FilialController@validaempresaxfilialcnpj');

                        Route::get('/cadastro/mensagem','CadastroMensagensController@index');
                        Route::post('/cadastro/mensagem','CadastroMensagensController@processar');








                        Route::post('/consulta/cadastro/fornecedor','CadastroFornecedorController@consultar');

                        //


                        Route::get('/cadastro/usuario','CadastroUsuarioController@index');


                        /*Representante*/
                        Route::get('/cadastro/representante','CadastroRepresentanteController@index');


                        /*Financeiro*/
                        /**Contas Pagar **/
                        Route::get('/novo/titulo/pagar','TitulosPagarController@index');
                        Route::post('/novo/titulo/pagar','TitulosPagarController@processar');
                        Route::get('/consulta/titulo/pagar/{NumTit}','TitulosPagarController@consultar');
                        Route::get('/consulta/cadastro/banco/{CodBan}','ControllerConsultaGerais@consultarbanco');
                        Route::get('/consulta/cadastro/favorecido/{CgcCpf}','ControllerConsultaGerais@consultarfavorecido');
                        Route::get('/consulta/cadastro/portador/{CodPor}','ControllerConsultaGerais@consultarportador');
                        Route::get('/baixa/titulo/pagar','TitulosPagarController@indexbaixa');
                        Route::post('/baixa/titulo/pagar','TitulosPagarController@baixar');
                        Route::get('/consulta/titulo/baixa/a/pagar/{CodFor}','TitulosPagarController@consultartitulobaixar');
                        Route::get('/aprovacao/titulo/pagar','TitulosPagarController@indexaprovacao');
                        Route::post('/aprovacao/titulo/pagar','TitulosPagarController@aprovar');
                        Route::get('/consulta/titulo/aprovacao/pagar/{CodFor}','TitulosPagarController@consultartitulosaprovacao');
                        Route::post('/estornar/aprovacao/titulo/pagar','TitulosPagarController@estornaraprovacao');



                        /*Financeiro*/
                        /**Contas Pagar **/
                        Route::get('/novo/titulo/receber','TituloReceberController@index');
                        Route::get('/consulta/titulo/receber/{NumTit}','TituloReceberController@consultar');
                        Route::post('/novo/titulo/receber','TituloReceberController@processar');
                        Route::get('/novo/titulo/receber/notificacao','TituloReceberController@notificacao');
                        Route::get('/consulta/titulo/receber','TituloReceberController@indexconsulta');
                        Route::get('/buscar/titulos/receber/{NumTit}','TituloReceberController@consultartitulo');
                        Route::post('/enviar/boleto','TituloReceberController@enviaremail');
                        Route::post('/baixar/boleto','TituloReceberController@baixamanual');
                        /*Route::get('/consulta/titulo/pagar/{NumTit}','TitulosPagarController@consultar');
                        Route::get('/consulta/cadastro/banco/{CodBan}','ControllerConsultaGerais@consultarbanco');
                        Route::get('/consulta/cadastro/favorecido/{CgcCpf}','ControllerConsultaGerais@consultarfavorecido');
                        Route::get('/consulta/cadastro/portador/{CodPor}','ControllerConsultaGerais@consultarportador');
                        Route::get('/baixa/titulo/pagar','TitulosPagarController@indexbaixa');
                        Route::post('/baixa/titulo/pagar','TitulosPagarController@baixar');
                        Route::get('/consulta/titulo/baixa/a/pagar/{CodFor}','TitulosPagarController@consultartitulobaixar');
                        Route::get('/aprovacao/titulo/pagar','TitulosPagarController@indexaprovacao');
                        Route::post('/aprovacao/titulo/pagar','TitulosPagarController@aprovar');
                        Route::get('/consulta/titulo/aprovacao/pagar/{CodFor}','TitulosPagarController@consultartitulosaprovacao');
                        Route::post('/estornar/aprovacao/titulo/pagar','TitulosPagarController@estornaraprovacao');*/


                        /*Parametros Gerais */
                        /** Abertura de Periodo **/
                                Route::get('/abertura/periodo','AberturaPeriodoController@index');
                                Route::post('/abertura/periodo','AberturaPeriodoController@processar');
                                Route::get('/consulta/periodo/aberto/{CodFil}','AberturaPeriodoController@consultar');

                        /** Cadastro de Portador **/
                                Route::get('/novo/portador',['as'=>'novo.portador','uses'=>'PortadorController@index']);
                                Route::post('/novo/portador',['as'=>'novo.portador','uses'=>'PortadorController@processar']);
                                Route::get('/consulta/portador/{CodPor}',['as'=>'consulta.portador','uses'=>'PortadorController@consultarPortador']);

                        /** Cadastro de Banco **/
                                Route::get('/novo/banco',['as'=>'novo.banco','uses'=>'BancoController@index']);
                                Route::post('/novo/banco',['as'=>'novo.banco','uses'=>'BancoController@processar']);
                                Route::get('/consulta/banco/{CodBan}',['as'=>'consulta.banco','uses'=>'BancoController@consultarBanco']);

                        /** Cadastro de Tipo Título **/
                                Route::get('/novo/tipo/titulo','TipoTituloController@index');
                                Route::post('/novo/tipo/titulo','TipoTituloController@processar');
                                Route::get('/consulta/tipo/titulo/{TipTit}','TipoTituloController@consultar');
                                
                        



                        /** Consulta Gerais  **/           
                                /** Fornecedor  **/
                                                Route::get('/consulta/cadastro/fornecedor/gerais/{CodFor}','ControllerConsultaGerais@consultarfornecedorcodigo');
                                                Route::get('/consulta/cadastro/fornecedor/gerais/cnpj/{CgcCpf}','ControllerConsultaGerais@consultarfornecedor');
                                /** Cliente  **/
                                                Route::get('/consulta/cadastro/cliente/gerais/{CodCli}','ControllerConsultaGerais@consultarclientecodigo');
                                                Route::get('/consulta/cadastro/cliente/gerais/cnpj/{CgcCpf}','ControllerConsultaGerais@consultarCliente');
                                                Route::get('/consultar/cadastro/clientes/','ControllerConsultaGerais@listarclientes');

                                                
                                /** Parâmetros **/
                                                Route::get('/consulta/tipo/titulo/receber/{CodTip}','ControllerConsultaGerais@consultartipoReceber');
                                                Route::get('/consulta/tipo/titulo/pagar/{CodTip}','ControllerConsultaGerais@consultartipoPagar');
                                                Route::get('/consulta/tipo/titulo/receber/{CodTip}','ControllerConsultaGerais@consultartipoReceber');

                                /** Transportadora  **/
                                        Route::get('/consultar/transportadora/{CodTra}','ControllerConsultaGerais@consultartransportadora');

                                /** Produtos * */
                                        Route::get('/consultar/produto/venda/{CodPro}','ControllerConsultaGerais@consultarproduto');      
                                
                                /** Transações * */
                                        Route::get('/consultar/transacoes/saida/','ControllerConsultaGerais@listarcfopsaida');      





