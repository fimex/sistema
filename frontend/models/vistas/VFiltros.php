<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_FiltrosAcero".
 *
 * @property integer $IdArea
 * @property integer $IdProducto
 * @property string $Producto
 * @property integer $Anio
 * @property integer $Semana
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
class VFiltros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_FiltrosAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'IdProducto', 'Anio', 'Semana', 'CantidadPorPaquete', 'Cantidad', 'IdFiltroTipo'], 'required'],
            [['IdArea', 'IdProducto', 'Anio', 'Semana', 'Programadas', 'Llenadas', 'CantidadPorPaquete', 'Cantidad', 'IdFiltroTipo', 'Requeridas'], 'integer'],
            [['Producto', 'Descripcion', 'DUX_CodigoPesos', 'DUX_CodigoDolares'], 'string'],
            [['ExistenciaPesos', 'ExistenciaDolares'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'IdProducto' => 'Id Producto',
            'Producto' => 'Producto',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
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
