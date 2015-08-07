<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "PedProg".
 *
 * @property integer $Id
 * @property integer $IdPedido
 * @property integer $IdProgramacion
 * @property string $OrdenCompra
 * @property string $FechaMovimiento
 *
 * @property PedProg $id
 * @property PedProg $pedProg
 * @property Pedidos $idPedido
 * @property Programaciones $idProgramacion
 */
class PedProg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PedProg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPedido', 'IdProgramacion', 'OrdenCompra', 'FechaMovimiento'], 'required'],
            [['IdPedido', 'IdProgramacion'], 'integer'],
            [['OrdenCompra'], 'string'],
            [['FechaMovimiento'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdPedido' => 'Id Pedido',
            'IdProgramacion' => 'Id Programacion',
            'OrdenCompra' => 'Orden Compra',
            'FechaMovimiento' => 'Fecha Movimiento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId()
    {
        return $this->hasOne(PedProg::className(), ['Id' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedProg()
    {
        return $this->hasOne(PedProg::className(), ['Id' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPedido()
    {
        return $this->hasOne(Pedidos::className(), ['IdPedido' => 'IdPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacion()
    {
        return $this->hasOne(Programaciones::className(), ['IdProgramacion' => 'IdProgramacion']);
    }
}
