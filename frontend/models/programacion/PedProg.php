<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "PedProg".
 *
 * @property integer $IdPedProg
 * @property integer $IdPedido
 * @property integer $IdProgramacion
 * @property string $OrdenCompra
 * @property string $FechaMovimiento
 *
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
            [['IdPedido', 'IdProgramacion', 'FechaMovimiento'], 'required'],
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
            'IdPedProg' => 'Id Ped Prog',
            'IdPedido' => 'Id Pedido',
            'IdProgramacion' => 'Id Programacion',
            'OrdenCompra' => 'Orden Compra',
            'FechaMovimiento' => 'Fecha Movimiento',
        ];
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
