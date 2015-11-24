<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "Existencias".
 *
 * @property integer $Id
 * @property integer $IdProducto
 * @property integer $IdCentroTrabajo
 * @property integer $Cantidad
 *
 * @property Productos $idProducto
 * @property CentrosTrabajo $idCentroTrabajo
 */
class Existencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Existencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdCentroTrabajo', 'Cantidad'], 'required'],
            [['Id', 'IdProducto', 'IdCentroTrabajo', 'Cantidad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdProducto' => 'Id Producto',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId()
    {
        return $this->hasOne(Productos::className(), ['Id' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCentroTrabajo()
    {
        return $this->hasOne(CentrosTrabajo::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }
}
