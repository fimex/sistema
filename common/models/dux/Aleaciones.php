<?php

namespace common\models\dux;

use Yii;

/**
 * This is the model class for table "Aleaciones".
 *
 * @property integer $IdAleacion
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdAleacionTipo
 *
 * @property Vaciados[] $vaciados
 * @property AleacionesTipo $idAleacionTipo
 * @property Productos[] $productos
 */
class Aleaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Aleaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'string'],
            [['IdAleacionTipo'], 'required'],
            [['IdAleacionTipo'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAleacion' => 'Id Aleacion',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'IdAleacionTipo' => 'Id Aleacion Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVaciados()
    {
        return $this->hasMany(Vaciados::className(), ['IdAleacion' => 'IdAleacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAleacionTipo()
    {
        return $this->hasOne(AleacionesTipo::className(), ['IdAleacionTipo' => 'IdAleacionTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['IdAleacion' => 'IdAleacion']);
    }
}
