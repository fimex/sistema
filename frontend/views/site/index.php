<?php
use yii\helpers\Url;

$area = Yii::$app->session->get('area');
$this->title = $area['Descripcion'];//Define el titulo de la página

$this->params['selected-nav']='home';
$this->params['content']=[
    'main-tab-home'=>[
        'method'=>'add',
        'clientOptions'=>[
            'title'=>'Home',
            'data'=>['url'=>Url::to([''],true)],
            'closable'=>true,
            'iconCls'=>'fa fa-home',
            //bisa juga menggunakan $this->render('partials/_home',[],true) jika content cukup kompleks
            'content'=>'isi content di sini ' 
        ]
    ]
];