<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Filtros".
 *
 * @property integer $IdFiltro
 * @property integer $IdProducto
 * @property integer $IdFiltroTipo
 * @property integer $Cantidad
 *
 * @property FiltrosTipo $idFiltroTipo
 * @property Productos $idProducto
 */
class Filtros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Filtros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdFiltroTipo'], 'required'],
            [['IdProducto', 'IdFiltroTipo', 'Cantidad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdFiltro' => 'Id Filtro',
            'IdProducto' => 'Id Producto',
            'IdFiltroTipo' => 'Id Filtro Tipo',
            'Cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFiltroTipo()
    {
        return $this->hasOne(FiltrosTipo::className(), ['IdFiltroTipo' => 'IdFiltroTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne( \common\models\dux\Productos::className(), ['IdProducto' => 'IdProducto']);
    }
    
    public function getFiltros($id)
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT IdFiltro, IdProducto, Cantidad,Descripcion FROM  Filtros f left join FiltrosTipo tf on  f.IdFiltroTipo = tf.IdFiltroTipo Where idProducto = $id ")->queryAll();
      
        return $result;
    }
}
