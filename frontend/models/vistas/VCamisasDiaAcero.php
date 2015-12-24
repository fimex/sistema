<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_CamisasDiaAcero".
 *
 * @property integer $IdProductoCasting
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
 * @property integer $IdCamisaTipo
 * @property string $Tamano
 * @property string $TiempoDesmoldeo
 * @property integer $Requeridas
 */
class VCamisasDiaAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CamisasDiaAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProductoCasting', 'Anio', 'Semana', 'Programadas', 'Llenadas', 'CantidadPorPaquete', 'Cantidad', 'IdCamisaTipo', 'Requeridas'], 'integer'],
            [['ProductoCasting', 'Descripcion', 'DUX_CodigoPesos', 'DUX_CodigoDolares', 'Tamano'], 'string'],
            [['Anio', 'Semana', 'Dia', 'Programadas', 'Descripcion', 'CantidadPorPaquete', 'Cantidad', 'IdCamisaTipo'], 'required'],
            [['Dia'], 'safe'],
            [['ExistenciaPesos', 'ExistenciaDolares', 'TiempoDesmoldeo'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProductoCasting' => 'Id Producto Casting',
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
            'IdCamisaTipo' => 'Id Camisa Tipo',
            'Tamano' => 'Tamano',
            'TiempoDesmoldeo' => 'Tiempo Desmoldeo',
            'Requeridas' => 'Requeridas',
        ];
    }
}
