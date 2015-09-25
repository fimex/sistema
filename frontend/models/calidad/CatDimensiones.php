<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "cat_dimensiones".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $operacion
 * @property string $val_nominal
 * @property string $tol_min
 * @property string $tol_max
 * @property integer $atributo
 * @property integer $final
 * @property integer $no_parte
 *
 * @property CatPartes $noParte
 * @property MedicionesDimenciones[] $medicionesDimenciones
 */
class CatDimensiones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_dimensiones';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mysql_calidad');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'operacion', 'atributo', 'final', 'no_parte'], 'required'],
            [['nombre'], 'string'],
            [['operacion', 'atributo', 'final', 'no_parte'], 'integer'],
            [['val_nominal', 'tol_min', 'tol_max'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'operacion' => 'Operacion',
            'val_nominal' => 'Val Nominal',
            'tol_min' => 'Tol Min',
            'tol_max' => 'Tol Max',
            'atributo' => 'Atributo',
            'final' => 'Final',
            'no_parte' => 'No Parte',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoParte()
    {
        return $this->hasOne(CatPartes::className(), ['id' => 'no_parte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicionesDimenciones()
    {
        return $this->hasMany(MedicionesDimenciones::className(), ['dimension' => 'id']);
    }
}
