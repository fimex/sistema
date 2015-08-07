<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "ResumenFechaMoldeo".
 *
 * @property integer $IdResumenFechaMoldeo
 * @property integer $IdFechaMoldeo
 * @property integer $IdSubProceso
 * @property integer $Existencia
 *
 * @property FechaMoldeo $idFechaMoldeo
 * @property SubProcesos $idSubProceso
 */
class ResumenFechaMoldeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ResumenFechaMoldeo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdFechaMoldeo', 'IdSubProceso', 'Existencia'], 'required'],
            [['IdFechaMoldeo', 'IdSubProceso', 'Existencia'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdResumenFechaMoldeo' => 'Id Resumen Fecha Moldeo',
            'IdFechaMoldeo' => 'Id Fecha Moldeo',
            'IdSubProceso' => 'Id Sub Proceso',
            'Existencia' => 'Existencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFechaMoldeo()
    {
        return $this->hasOne(FechaMoldeo::className(), ['IdFechaMoldeo' => 'IdFechaMoldeo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubProceso()
    {
        return $this->hasOne(SubProcesos::className(), ['IdSubProceso' => 'IdSubProceso']);
    }
    public function incrementa($idFechaMoldeo,$idSubProceso){
        $command = \Yii::$app->db;
        $result = $command->createCommand("UPDATE ResumenFechaMoldeo SET Existencia = Existencia +1 WHERE IdFechaMoldeo = '$idFechaMoldeo' AND IdSubProceso = '$idSubProceso' ")->execute();
    }
}
