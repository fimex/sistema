<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use common\models\Areas;
use yii\db\ActiveQuery;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<?php $this->registerCSS(".container{width:100%;}");?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="programa">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            padding: 0 8px;
        }
        .form-control, .filter{
            //width: 100px;
            height: 30px;
            font-size: 10pt;
        }
        th, td{
            text-align: center;
        }

        .success2{
            background-color: lightgreen;
        }

        .scrollable {
            margin: auto;
            height: 742px;
            border: 2px solid #ccc;
            overflow-y: scroll; /* <-- here is what is important*/
        }
        #pedidos{
            height: 300px;
        }
        thead {
            background: white;
        }
        table {
            width: 100%;
            border-spacing:0;
            margin:0;
        }
        table th , table td  {
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
        }
        .par{
            background-color: #BFB2CF;
        }
        .par2{
            background-color: #DFDBE7;
        }
        .impar{
            background-color: #A4D5E2;
        }
        .impar2{
            background-color: #D1EAF0;
        }
    </style>
</head>
<body onkeypress="return getkey(event,this)">
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            //echo Html::img('@web/frontend/assets/img/fimex_logo.png',['width'=>'100']);
            $area = Yii::$app->session->get('area');
            $brandLabel = ($area !== null ? "<b>Sistema de ".$area['Descripcion']." :: </b>" : "<b>Sistema Fimex :: </b>");
            //var_dump($area);exit;
            if($area !== null){
                $menuItems = Yii::$app->params['menu'][$area['IdArea']];
            }else{
                $model = new Areas();
                
                foreach($model->find()->asArray()->all() as $area => $valores){
                    $menuItems[] = ['label' => $valores['Descripcion'], 'url' => ['/site/index?area='.$valores['IdArea']]];
                }
            }

            NavBar::begin([
                'brandLabel' => $brandLabel,
                'brandUrl'=> '#',
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            if (Yii::$app->user->isGuest) {
                $menuLogin[] = ['label' => 'Iniciar Sesion', 'url' => ['/site/login']];
            } else {
                $menuLogin[] = [
                    'label' => 'Cerrar Sesion (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            if (!Yii::$app->user->isGuest) {
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-left'],
                    'items' => $menuItems,
                ]);
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuLogin,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>