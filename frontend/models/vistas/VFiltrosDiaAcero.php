<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_FiltrosDiaAcero".
 *
 * @property integer $IdProducto
 * @property integer $IdArea
 * @property string $Producto
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $Programadas
 * @property integer $Llenadas
 * @property string $Descripcion
 * @property integer $CantidadPorPaquete
 * @property string $DUX_CodigoPesos
 * @property string $DUX_CodigoDolares
 * @property integer $Cantidad
 * @property string $ExistenciaPesos
 * @property string $ExistenciaDolares
 * @property integer $IdFiltroTipo
 * @property integer $Requeridas
 */
class VFiltrosDiaAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_FiltrosDiaAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdArea', 'Anio', 'Semana', 'Dia', 'Programadas', 'CantidadPorPaquete', 'Cantidad', 'IdFiltroTipo'], 'required'],
            [['IdProducto', 'IdArea', 'Anio', 'Semana', 'Programadas', 'Llenadas', 'CantidadPorPaquete', 'Cantidad', 'IdFiltroTipo', 'Requeridas'], 'integer'],
            [['Producto', 'Descripcion', 'DUX_CodigoPesos', 'DUX_CodigoDolares'], 'string'],
            [['Dia'], 'safe'],
            [['ExistenciaPesos', 'ExistenciaDolares'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProducto' => 'Id Producto',
            'IdArea' => 'Id Area',
            'Producto' => 'Producto',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'Programadas' => 'Programadas',
            'Llenadas' => 'Llenadas',
            'Descripcion' => 'Descripcion',
            'CantidadPorPaquete' => 'Cantidad Por Paquete',
            'DUX_CodigoPesos' => 'Dux  Codigo Pesos',
            'DUX_CodigoDolares' => 'Dux  Codigo Dolares',
            'Cantidad' => 'Cantidad',
            'ExistenciaPesos' => 'Existencia Pesos',
            'ExistenciaDolares' => 'Existencia Dolares',
            'IdFiltroTipo' => 'Id Filtro Tipo',
            'Requeridas' => 'Requeridas',
        ];
    }
}
