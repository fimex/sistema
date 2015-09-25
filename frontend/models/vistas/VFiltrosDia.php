<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_FiltrosDia".
 *
 * @property integer $IdProductoCasting
 * @property integer $IdArea
 * @property string $ProductoCasting
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
class VFiltrosDia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_FiltrosDia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProductoCasting', 'IdArea', 'Anio', 'Semana', 'Programadas', 'Llenadas', 'CantidadPorPaquete', 'Cantidad', 'IdFiltroTipo', 'Requeridas'], 'integer'],
            [['IdArea', 'Anio', 'Semana', 'Dia', 'Programadas', 'CantidadPorPaquete', 'Cantidad', 'IdFiltroTipo'], 'required'],
            [['ProductoCasting', 'Descripcion', 'DUX_CodigoPesos', 'DUX_CodigoDolares'], 'string'],
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
            'IdProductoCasting' => 'Id Producto Casting',
            'IdArea' => 'Id Area',
            'ProductoCasting' => 'Producto Casting',
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
