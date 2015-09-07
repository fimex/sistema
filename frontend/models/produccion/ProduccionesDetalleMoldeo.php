<?php

namespace frontend\models\produccion;

use Yii;
use yii\data\ArrayDataProvider;
use common\models\dux\Productos;

/**
 * This is the model class for table "ProduccionesDetalleMoldeo".
 *
 * @property integer $IdProduccionDetalleMoldeo
 * @property integer $IdProduccion
 * @property integer $IdProgramacion
 * @property integer $IdProducto
 * @property string $Eficiencia
 * @property integer $IdParteMolde
 * @property integer $IdEstatus
 * @property integer $Linea
 *
 * @property CiclosTipo $idEstatus
 * @property PartesMolde $idParteMolde
 * @property Producciones $idProduccion
 * @property Productos $idProducto
 * @property Programaciones $idProgramacion
 */
class ProduccionesDetalleMoldeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesDetalleMoldeo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdProgramacion', 'IdProducto', 'Eficiencia'], 'required'],
            [['IdProduccion', 'IdProgramacion', 'IdProducto', 'IdParteMolde', 'IdEstatus', 'Linea'], 'integer'],
            [['Eficiencia'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccionDetalleMoldeo' => 'Id Produccion Detalle Moldeo',
            'IdProduccion' => 'Id Produccion',
            'IdProgramacion' => 'Id Programacion',
            'IdProducto' => 'Id Producto',
            'Eficiencia' => 'Eficiencia',
            'IdParteMolde' => 'Id Parte Molde',
            'IdEstatus' => 'Id Estatus',
            'Linea' => 'Linea',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstatus()
    {
        return $this->hasOne(CiclosTipo::className(), ['IdCicloTipo' => 'IdEstatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdParteMolde()
    {
        return $this->hasOne(PartesMolde::className(), ['IdParteMolde' => 'IdParteMolde']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacion()
    {
        return $this->hasOne(Programaciones::className(), ['IdProgramacion' => 'IdProgramacion']);
    }
}
