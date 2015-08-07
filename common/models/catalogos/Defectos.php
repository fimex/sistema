<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "Defectos".
 *
 * @property integer $IdDefecto
 * @property integer $IdDefectoTipo
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdProceso
 *
 * @property DefectosTipo $idDefectoTipo
 * @property Procesos $idProceso
 * @property ProduccionesDefecto[] $produccionesDefectos
 * @property AlmasProduccionDefecto[] $almasProduccionDefectos
 */
class Defectos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Defectos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdDefectoTipo', 'Identificador', 'Descripcion', 'IdProceso'], 'required'],
            [['IdDefectoTipo', 'IdProceso'], 'integer'],
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdDefecto' => 'Id Defecto',
            'IdDefectoTipo' => 'Id Defecto Tipo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'IdProceso' => 'Id Proceso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDefectoTipo()
    {
        return $this->hasOne(DefectosTipo::className(), ['IdDefectoTipo' => 'IdDefectoTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProceso()
    {
        return $this->hasOne(Procesos::className(), ['IdProceso' => 'IdProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDefectos()
    {
        return $this->hasMany(ProduccionesDefecto::className(), ['IdDefecto' => 'IdDefecto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmasProduccionDefectos()
    {
        return $this->hasMany(AlmasProduccionDefecto::className(), ['IdDefecto' => 'IdDefecto']);
    }
}
