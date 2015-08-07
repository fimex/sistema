<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Almas".
 *
 * @property integer $IdAlma
 * @property integer $IdProducto
 * @property integer $IdAlmaTipo
 * @property integer $IdAlmaMaterialCaja
 * @property integer $IdAlmaReceta
 * @property integer $Existencia
 * @property integer $PiezasCaja
 * @property integer $PiezasMolde
 * @property double $Peso
 * @property double $TiempoLlenado
 * @property double $TiempoFraguado
 * @property double $TiempoGaseoDirectro
 * @property double $TiempoGaseoIndirecto
 *
 * @property AlmasMaterialCaja $idAlmaMaterialCaja
 * @property AlmasRecetas $idAlmaReceta
 * @property AlmasTipo $idAlmaTipo
 * @property Productos $idProducto
 * @property ProgramacionesAlma[] $programacionesAlmas
 * @property AlmasProduccionDetalle[] $almasProduccionDetalles
 */
class Almas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Almas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdAlmaTipo', 'IdAlmaMaterialCaja', 'IdAlmaReceta', 'PiezasCaja', 'PiezasMolde'], 'required'],
            [['IdProducto', 'IdAlmaTipo', 'IdAlmaMaterialCaja', 'IdAlmaReceta', 'Existencia', 'PiezasCaja', 'PiezasMolde'], 'integer'],
            [['Peso', 'TiempoLlenado', 'TiempoFraguado', 'TiempoGaseoDirecto', 'TiempoGaseoIndirecto'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlma' => 'Id Alma',
            'IdProducto' => 'Id Producto',
            'IdAlmaTipo' => 'Id Alma Tipo',
            'IdAlmaMaterialCaja' => 'Id Alma Material Caja',
            'IdAlmaReceta' => 'Id Alma Receta',
            'Existencia' => 'Existencia',
            'PiezasCaja' => 'Piezas Caja',
            'PiezasMolde' => 'Piezas Molde',
            'Peso' => 'Peso',
            'TiempoLlenado' => 'Tiempo Llenado',
            'TiempoFraguado' => 'Tiempo Fraguado',
            'TiempoGaseoDirecto' => 'Tiempo Gaseo Directo',
            'TiempoGaseoIndirecto' => 'Tiempo Gaseo Indirecto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmaMaterialCaja()
    {
        return $this->hasOne(AlmasMaterialCaja::className(), ['IdAlmaMaterialCaja' => 'IdAlmaMaterialCaja']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmaReceta()
    {
        return $this->hasOne(AlmasRecetas::className(), ['IdAlmaReceta' => 'IdAlmaReceta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmaTipo()
    {
        return $this->hasOne(AlmasTipo::className(), ['IdAlmaTipo' => 'IdAlmaTipo']);
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
    public function getProgramacionesAlmas()
    {
        return $this->hasMany(ProgramacionesAlma::className(), ['IdAlmas' => 'IdAlma']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmasProduccionDetalles()
    {
        return $this->hasMany(AlmasProduccionDetalle::className(), ['IdAlma' => 'IdAlma']);
    }
    
    public function getAlmas($id)
    {
        $command = \Yii::$app->db;
        //$result =$command->createCommand("SELECT * FROM Almas Where idProducto = $id ")->queryAll();
        $result =$command->createCommand("SELECT a.*, ta.Descripcion AS DescripTipo, am.Descripcion AS DescripMaterial, ar.Descripcion AS DescripReceta
	FROM  Almas a 
	LEFT JOIN AlmasTipo ta on  a.IdAlmaTipo = ta.IdAlmaTipo 
	LEFT JOIN AlmasMaterialCaja am ON a.IdAlmaMaterialCaja = am.IdAlmaMaterialCaja 
	LEFT JOIN AlmasRecetas ar ON a.IdAlmaReceta = ar.IdAlmaReceta
		WHERE idProducto = $id ")->queryAll();

        return $result;
    }
}
