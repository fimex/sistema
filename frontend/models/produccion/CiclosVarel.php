<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "CiclosVarel".
 *
 * @property integer $IdCiclos
 * @property integer $IdProducto
 * @property integer $IdTurno
 * @property integer $IdSubProceso
 * @property string $ParteMolde
 * @property string $Serie
 * @property string $Comentarios
 * @property string $Fecha
 * @property integer $Cantidad
 *
 * @property Productos $idProducto
 * @property SubProcesos $idSubProceso
 * @property Turnos $idTurno
 */
class CiclosVarel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CiclosVarel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdTurno', 'IdSubProceso', 'Fecha', 'Tipo'], 'required'],
            [['IdProducto', 'IdTurno', 'IdSubProceso', 'Cantidad'], 'integer'],
            [['ParteMolde', 'Serie', 'Comentarios', 'Tipo'], 'string'],
            [['Fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCiclos' => 'Id Ciclos',
            'IdProducto' => 'Id Producto',
            'IdTurno' => 'Id Turno',
            'IdSubProceso' => 'Id Sub Proceso',
            'ParteMolde' => 'Parte Molde',
            'Serie' => 'Serie',
            'Comentarios' => 'Comentarios',
            'Fecha' => 'Fecha',
            'Cantidad' => 'Cantidad',
            'Tipo' => 'Tipo',
        ];
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
    public function getIdSubProceso()
    {
        return $this->hasOne(SubProcesos::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTurno()
    {
        return $this->hasOne(Turnos::className(), ['IdTurno' => 'IdTurno']);
    }
}
