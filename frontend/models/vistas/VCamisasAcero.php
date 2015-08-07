<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_CamisasAcero".
 *
 * @property integer $Cant_Camisas
 * @property integer $Cam_hechas
 * @property integer $IdCamisa
 * @property integer $IdProducto
 * @property integer $IdCamisaTipo
 * @property string $Tamaño
 * @property string $Descripcion
 * @property integer $Cantidad
 * @property integer $Programadas
 * @property integer $CantidadPorPaquete
 * @property string $DUX_CodigoPesos
 * @property string $DUX_CodigoDolares
 * @property integer $Hechas
 * @property integer $Semana
 */
class VCamisasAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CamisasAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Cant_Camisas', 'Cam_hechas', 'IdCamisa', 'IdProducto', 'IdCamisaTipo', 'Cantidad', 'Programadas', 'CantidadPorPaquete', 'Hechas', 'Semana'], 'integer'],
            [['IdCamisa', 'IdProducto', 'IdCamisaTipo', 'Cantidad'], 'required'],
            [['Tamaño', 'Descripcion', 'DUX_CodigoPesos', 'DUX_CodigoDolares'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Cant_Camisas' => 'Cant  Camisas',
            'Cam_hechas' => 'Cam Hechas',
            'IdCamisa' => 'Id Camisa',
            'IdProducto' => 'Id Producto',
            'IdCamisaTipo' => 'Id Camisa Tipo',
            'Tamaño' => 'Tamaño',
            'Descripcion' => 'Descripcion',
            'Cantidad' => 'Cantidad',
            'Programadas' => 'Programadas',
            'CantidadPorPaquete' => 'Cantidad Por Paquete',
            'DUX_CodigoPesos' => 'Dux  Codigo Pesos',
            'DUX_CodigoDolares' => 'Dux  Codigo Dolares',
            'Hechas' => 'Hechas',
            'Semana' => 'Semana',
        ];
    }
    
    public function getCamisasXtam($cant){
        $command = \Yii::$app->db;
        $result = $command->createCommand("SELECT * FROM v_CamisasAcero")->queryAll();
    }
}
