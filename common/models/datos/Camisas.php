<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Camisas".
 *
 * @property integer $IdCamisa
 * @property integer $IdProducto
 * @property integer $IdCamisaTipo
 * @property integer $Cantidad
 *
 * @property CamisasTipo $idCamisaTipo
 * @property Productos $idProducto
 */
class Camisas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Camisas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdCamisaTipo'], 'required'],
            [['IdProducto', 'IdCamisaTipo', 'Cantidad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCamisa' => 'Id Camisa',
            'IdProducto' => 'Id Producto',
            'IdCamisaTipo' => 'Id Camisa Tipo',
            'Cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCamisaTipo()
    {
        return $this->hasOne(CamisasTipo::className(), ['IdCamisaTipo' => 'IdCamisaTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
    
    
    public function getCamisas($id)
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT c.*, tc.Descripcion FROM  Camisas c left join CamisasTipo tc on  c.IdCamisaTipo = tc.IdCamisaTipo Where idProducto = $id ")->queryAll();

        return $result;
    }
    

}
