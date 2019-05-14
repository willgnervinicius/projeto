<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'CRNS',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>CRNS</b>',

    'logo_mini' => '<b>C</b>RNS',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue-light',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',
    
    'logarempresa' => 'selecione',
    
    'aberturaperiodo' => 'periodo',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [

        [
            'text'    => 'Cadastros',
            'icon'    => 'file',
            'submenu' => [

              [
                  'text'       => 'Empresa',
                  'icon' => 'desktop',
                  'submenu' => [
                      [
                          'text' => 'Empresa',
                          'icon' => 'plus',
                          'url' => '/cadastro/empresa',
                      ],
                  ],
              ],

              [
                  'text'       => 'Filial',
                  'icon' => 'group',
                  'submenu' => [
                      [
                          'text' => 'Filial',
                          'icon' => 'plus',
                          'url' => '/cadastro/filial',
                      ],
                      [
                          'text' => 'Consulta',
                          'icon' => 'search',
                          'url'  => '/consulta/cadastro/filial',
                      ],
                      
                     
                  ],

              ],


              [
                  'text' => 'Cliente',
                  'icon'        => 'user',
                  'submenu' => [
                    [
                        'text' => 'Cadastro',
                        'icon' => 'plus' ,
                        'url'  => '/cadastro/cliente',
                    ],

                    [
                        'text' => 'Consulta',
                        'icon' => 'search' ,
                        'url'  => '/consulta/cadastro/cliente',
                    ],
                  ],

              ],
              [
                  'text' => 'Fornecedor',
                  'icon'        => 'handshake-o',
                  'submenu' => [
                    [
                        'text' => 'Cadastro',
                        'icon' => 'plus' ,
                        'url'  => '/cadastro/fornecedor',
                    ],

                    [
                        'text' => 'Consulta',
                        'icon' => 'search' ,
                        'url'  => '/consulta/cadastro/fornecedor',
                    ],
                  ],


              ],
              [
                  'text' => 'Usuários',
                  'icon'        => 'user-circle-o',
                  'submenu' => [
                        [
                            'text' => 'Usuários',
                            'url'  => '/cadastro/usuario',
                            'icon'        => 'user-plus',

                        ],

                       

                        [
                            'text' => 'Ligação',
                            'icon'        => 'cogs',
                            'submenu' => [
                                [
                                    'text' => 'Usuário x Filial',
                                    'icon'        => 'user-plus',
                                    'url' => '/ligacao/usuario/filial',
                                ],

                                
                            ],

                        ],

                        
                  ],

              ],

              [
                  'text' => 'Transportadora',
                  'url'  => '/cadastro/transportadora',
                  'icon'        => 'truck'

              ],

              [
                  'text' => 'Representante',
                  'url'  => '/cadastro/representante',
                  'icon'        => 'group'

              ],


              

              [
                  'text' => 'Produtos',
                  'icon' => 'coffee' ,

                  'submenu' => [
                [
                    'text' => 'Produtos',
                    'url'  => '/cadastro/produto',
                    'icon' => 'coffee' ,
                ],
                [
                    'text'    => 'Gerais',
                    'url'     => '#',
                    'icon'    => 'cogs',
                    'submenu' => [
                      [
                          'text' => 'Depto / Seção',
                          'url'  => '/cadastro/departamento',
                      ],
                        [
                            'text' => 'Grupos',
                            'url'  => '/cadastro/grupo',
                        ],
                        [
                            'text' => 'SubGrupos',
                            'url'  => '/cadastro/subgrupo',
                        ],
                        [
                            'text' => 'Tributação',
                            'url'  => '/cadastro/tributacao',
                        ],
                        
                    ],

                ],

            ],





              ],
              [
                'text'       => 'Parâmetros',
                'icon' => 'cog',
                'submenu' => [
                    [
                        'text' => 'Fiscal',
                        'icon' => 'plus',
                        'submenu' => [
                            
                          [
                              'text' => 'Abertura De Período',
                              'icon' => 'plus',
                              'url'  => '/abertura/periodo',
                            ],

                            [
                                'text' => 'Centro de Custo',
                                'icon' => 'search',
                                'url'  => '/cadastro/centro/custo',
                            ],
                            
                      ],
                    ],
                    [
                        'text' => 'Financeiro',
                        'icon' => 'search','submenu' => [
                            [
                                'text' => 'Banco',
                                'icon' => 'plus',
                                'url'  => '/novo/banco',
                            ],
                            [
                                'text' => 'Portador',
                                'icon' => 'plus',
                                'url'  => '/novo/portador',
                            ],
                            [
                                'text' => 'Tipo de Título',
                                'icon' => 'plus',
                                'url'  => '/novo/tipo/titulo',
                            ],



                          
                      ],
                        
                    ],
                    
                   
                ],

            ],

             ],



            

            ],


            


        

        


        
        [
            'text'    => 'Financeiro',
            'icon'    => 'bank',
            'submenu' => [
                [
                    'text'    => 'Contas a Pagar',
                    'url'     => '#',
                    'submenu' => [
                                [
                                    'text' => 'Entrada / Manutenção',
                                    'icon' => 'plus-square',
                                    'url'  => '/novo/titulo/pagar',
                                ],
                                [
                                    'text' => 'Aprovação Título',
                                    'icon' => 'check-square-o',
                                    'url'  => '/aprovacao/titulo/pagar',
                                ],
                                [
                                    'text' => 'Baixa Manual',
                                    'icon' => 'chevron-circle-down',
                                    'url'  => '/baixa/titulo/pagar',
                                ],
                                
                            ],
                             
                        
                        ],
                        [
                            'text'    => 'Contas a Receber',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'Entrada / Manutenção',
                                    'icon' => 'plus-square',
                                    'url'  => '/novo/titulo/receber',
                                ],
                                [
                                    'text' => 'Consulta Título',
                                    'icon' => 'search',
                                    'url'  => '/consulta/titulo/receber',
                                ],
                                
                        ],
                    ],
                ],               
        ],

       



    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
