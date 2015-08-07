<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<?php $this->registerCSS(".container{width:100%;}");?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Configuracion :: ',
                'brandUrl' => '#',
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Inicio', 'url' => ['/site/index']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems2[] = ['label' => 'Nuevo usuario', 'url' => ['/site/signup']];
                $menuItems2[] = ['label' => 'Iniciar Sesion', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Maquinaria',
                    'items' => [
                        ['label' => 'Centros de trabajo', 'url' => ['/centros-trabajo']],
                        ['label' => 'Maquinas', 'url' => ['/maquinas']],
                    ]];
                $menuItems[] = [
                    'label' => 'Departamentos',
                    'items' => [
                        ['label' => 'Areas', 'url' => ['/areas']],
                        ['label' => 'Procesos', 'url' => ['/procesos']],
                        ['label' => 'Materiales', 'url' => ['/materiales']],
                    ]];
                $menuItems[] = [
                    'label' => 'Almas',
                    'items' => [
                        ['label' => 'Tipos', 'url' => ['/tipo']],
                        ['label' => 'Recetas', 'url' => ['/recetas']],
                        ['label' => 'Procesos', 'url' => ['/procesos']],
                    ]];
                $menuItems[] = [
                    'label' => 'Tiempo Muerto',
                    'items' => [
                        ['label' => 'Clasificacion', 'url' => ['/causas-tipo']],
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Dropdown Header</li>',
                        ['label' => 'Causas', 'url' => ['/causas']],
                    ]];
                $menuItems[] = [
                    'label' => 'Usuarios',
                    'items' => [
                        ['label' => 'Nuevo usuario', 'url' => ['/site/signup']],
                        ['label' => 'Empleados', 'url' => ['/empleados']],
                    ]];
                
                $menuItems2[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => $menuItems,
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems2,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
