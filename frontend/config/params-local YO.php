<?php
return [
    'menu'=>[
        [],
        [ ['label' => 'Acero', 'url' => ['/productos?area=2']],
          ['label' => 'Bronce', 'url' => ['/productos?area=3']],
          ['label' => 'Moldeo Permanente', 'url' => ['/productos?area=4']],
          ['label' => 'Salir', 'url' => ['/site/quit']],
        ],
        
        [ //menu para Aceros
            ['label' => 'Inicio', 'url' => ['/site/index']],
            [
                'label' => 'Programacion',
                'items' => [
                    ['label' => 'Programacion Semanal', 'url' => ['/programacion-angular-acero/semanal']],
                    ['label' => 'Programacion Diaria', 'url' => ['/programacion-angular/diaria?AreaProceso=2&subProceso=6']],
                    ['label' => 'Programacion Tarimas', 'url' => ['/programacion-angular-acero/tarimas']],
                ],
            ],
			[
                'label' => 'Almas',
                'items' => [
                    ['label' => 'Catalogo Almas', 'url' => ['/reportes/almas-catalogo-acero']],
                    ['label' => 'Programacion Semanal', 'url' => ['/programacion-almas/semanal']],
                    ['label' => 'Programacion Diaria', 'url' => ['/programacion-almas/diaria?AreaProceso=2&subProceso=2']],
                    ['label' => 'Produccion', 'url' => ['/angular/almasac']],
                    ['label' => 'Pintado', 'url' => ['/pintura/']],
                ],
            ],
            [
                'label' => 'Captura de Produccion',
                'items' => [
                    ['label' => 'Almas', 'url' => ['/produccion2/captura?proceso=1']],
                    '<li class="divider"></li>',
                    '<li class="dropdown-header">Moldeo</li>',
                    ['label' => 'Moldeo Varel', 'url' => ['/produccion-acero/moldeo-v']],
                    ['label' => 'Moldeo Kloster', 'url' => ['/produccion-acero/moldeo-k']],
                    ['label' => 'Moldeo Especial', 'url' => ['/produccion-acero/moldeo-e']],
                    '<li class="divider"></li>',
                    '<li class="dropdown-header">Cerrado</li>',
                    ['label' => 'Cerrado Kloster', 'url' => ['/produccion-acero/cerrado-k']],
                    '<li class="divider"></li>',
                    ['label' => 'Vaciado', 'url' => ['/produccion-acero/vaciado-acero']],
                    ['label' => 'Limpieza', 'url' => ['/produccion']],
                    ['label' => 'Configuracion Series', 'url' => ['/produccion-acero/series']],
                    ['label' => 'Tiempos Muertos', 'url' => ['/produccion-acero/tiemposmuertos']],
                ],
                'url' => ['/programaciones']
            ],
            [
                'label' => 'Reportes',
                'items' => [
                    '<li class="dropdown-header">Requerimiento de material</li>',
                    '<li class="divider"></li>',
                    ['label' => 'Metal', 'url' => ['/reportes/material-aceros']],
                    ['label' => 'Camisas', 'url' => ['/reportes/camisas']],
                    ['label' => 'Filtros', 'url' => ['/reportes/filtros-aceros']],
                    '<li class="divider"></li>',
                    ['label' => 'Series', 'url' => ['/reportes/series-aceros']],
                    ['label' => 'Almas', 'url' => ['/site/about']],
                    ['label' => 'Moldeo', 'url' => ['/site/about']],
                    ['label' => 'Cerrado', 'url' => ['/site/about']],
                    ['label' => 'Vaciado', 'url' => ['/site/about']],
                    ['label' => 'Limpieza', 'url' => ['/site/about']],
                    
                ],
                'url' => ['/programaciones']
            ],
            ['label' => 'Salir', 'url' => ['/site/quit']],
        ],
        [ //menu para bronces
            ['label' => 'Inicio', 'url' => ['/site/index']],
            [
                'label' => 'Programacion',
                'items' => [
                    ['label' => 'Programacion Semanal', 'url' => ['/programacion-angular/semanal']],
                    ['label' => 'Programacion Diaria', 'url' => ['/programacion-angular/diaria?AreaProceso=3&subProceso=6']],
                ],
            ],
            [
                'label' => 'Almas',
                'items' => [
                    ['label' => 'Catalogo Almas', 'url' => ['/reportes/almas-catalogo']],
                    ['label' => 'Programacion Semanal', 'url' => ['/programacion-almas/semanal']],
                    ['label' => 'Programacion Diaria', 'url' => ['/programacion-almas/diaria?AreaProceso=3&subProceso=2']],
                    ['label' => 'Produccion', 'url' => ['/angular/almas']],
                    ['label' => 'Rebabeo y Ensamble', 'url' => ['/angular/rebabeo']],
                ],

            ],
            [
                'label' => 'Produccion Moldeo',
                'items' => [
                    ['label' => 'Moldeo', 'url' => ['/angular/moldeo']],
                    ['label' => 'Vaciado', 'url' => ['/angular/vaciado']],
                ],

            ],
            [
                'label' => 'Produccion Limpieza',
                'items' => [
                    ['label' => 'Programacion Diaria', 'url' => ['/programacion-angular/diaria?AreaProceso=3&subProceso=12']],
                    ['label' => 'Limpieza', 'url' => ['/angular/limpieza']],
                    ['label' => 'Empaque', 'url' => ['/angular/empaque']],
                ],

            ],
            [
                'label' => 'Reportes',
                'items' => [
                    ['label' => 'Productos Colli', 'url' => ['/reportes/productoscolli']],
                    '<li class="dropdown-header">Produccion</li>',
                    ['label' => 'Almas', 'url' => ['/reportes/almas']],
                    ['label' => 'Moldeo', 'url' => ['/reportes/moldeo']],
                    ['label' => 'Vaciado', 'url' => ['/reportes/vaciado']],
                    '<li class="divider"></li>',
                    ['label' => 'Tiempos Muertos', 'url' => ['/reportes/tiempos-muertos']],
                    '<li class="divider"></li>',
                    '<li class="dropdown-header">ETE</li>',
                    ['label' => 'Moldeo', 'url' => ['/reportes/ete?subProceso=6']],
                    ['label' => 'Almas', 'url' => ['/reportes/ete-almas']],
                    '<li class="divider"></li>',
                    '<li class="dropdown-header">Materiales Requeridos</li>',
                    ['label' => 'Metal', 'url' => ['/reportes/material']],
                    ['label' => 'Cajas', 'url' => ['/reportes/piezascajas']],
                    ['label' => 'Filtros', 'url' => ['/reportes/filtros-bronces']],
                ],
                'url' => ['/programaciones']
            ],
            ['label' => 'Salir', 'url' => ['/site/quit']],
        ],
        [ //menu para Moldeo permanente
            ['label' => 'Inicio', 'url' => ['/site/index']],
            ['label' => 'Programacion Semanal', 'url' => ['/programacion/semanal']],
            [
                'label' => 'Almas',
                'items' => [
                    ['label' => 'Programacion', 'url' => ['/almas/semanal']],
                    ['label' => 'Produccion', 'url' => ['/produccion/almas?proceso=15']],
                ],
            ],
            [
                'label' => 'Moldeo',
                'items' => [
                    ['label' => 'Programacion', 'url' => ['/programacion/diaria?AreaProceso=4&subProceso=6']],
                    ['label' => 'Produccion', 'url' => ['/produccion2/captura2?subProceso=6']],
                ],

            ],
            [
                'label' => 'Reportes',
                'items' => [
                    ['label' => 'Almas', 'url' => ['/site/about']],
                    ['label' => 'Moldeo', 'url' => ['/reportes/moldeo']],
                    ['label' => 'Cerrado', 'url' => ['/site/about']],
                    ['label' => 'Vaciado', 'url' => ['/reportes/vaciado']],
                    ['label' => 'Limpieza', 'url' => ['/site/about']],
                    ['label' => 'Tiempos Muertos', 'url' => ['/reportes/tiemposmuertos?ini=0&fin=0']],
                    ['label' => 'ETE', 'url' => ['/reportes/ete']],
                ],
                'url' => ['/programaciones']
            ],
            ['label' => 'Salir', 'url' => ['/site/quit']],
        ],
        [],
    ]
];
