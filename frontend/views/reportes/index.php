<div ng-controller="Pruebas">
    <?= $this->render($vista,[
        'IdArea' => isset($IdArea) ? $IdArea : '',
        'IdSubProceso' => $IdSubProceso,
        'serie' => isset($serie) ? $serie : ''
        ]);?>
</div>