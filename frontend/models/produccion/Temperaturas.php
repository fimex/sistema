<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Temperaturas".
 *
 * @property integer $IdTemperatura
 * @property integer $IdProduccion
 * @property integer $IdMaquina
 * @property string $Fecha
 * @property string $Temperatura
 * @property string $Temperatura2
 * @property integer $IdEmpleado
 * @property integer $Moldes
 * @property integer $IdProducto
 *
 * @property Empleados $idEmpleado
 * @property Maquinas $idMaquina
 * @property Producciones $idProduccion
 * @property Productos $idProducto
 */
class Temperaturas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Temperaturas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdMaquina', 'Fecha', 'IdEmpleado'], 'required'],
            [['IdProduccion', 'IdMaquina', 'IdEmpleado', 'Moldes', 'IdProducto'], 'integer'],
            [['Fecha'], 'safe'],
            [['Temperatura', 'Temperatura2'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTemperatura' => 'Id Temperatura',
            'IdProduccion' => 'Id Produccion',
            'IdMaquina' => 'Id Maquina',
            'Fecha' => 'Fecha',
            'Temperatura' => 'Temperatura',
            'Temperatura2' => 'Temperatura2',
            'IdEmpleado' => 'Id Empleado',
            'Moldes' => 'Moldes',
            'IdProducto' => 'Id Producto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaquina()
    {
        return $this->hasOne(Maquinas::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
}
