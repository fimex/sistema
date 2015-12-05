<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_TipoMonitoreo".
 *
 * @property integer $IdTipoEstatusMonitoreo
 * @property integer $IdTipoMonitoreo
 * @property string $Concepto
 * @property integer $IdTipoEstatusUbic
 * @property string $Descripcion
 * @property integer $Tipo
 */
class VTipoMonitoreo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_TipoMonitoreo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTipoEstatusMonitoreo', 'IdTipoMonitoreo', 'IdTipoEstatusUbic'], 'required'],
            [['IdTipoEstatusMonitoreo', 'IdTipoMonitoreo', 'IdTipoEstatusUbic', 'Tipo'], 'integer'],
            [['Concepto', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTipoEstatusMonitoreo' => 'Id Tipo Estatus Monitoreo',
            'IdTipoMonitoreo' => 'Id Tipo Monitoreo',
            'Concepto' => 'Concepto',
            'IdTipoEstatusUbic' => 'Id Tipo Estatus Ubic',
            'Descripcion' => 'Descripcion',
            'Tipo' => 'Tipo',
        ];
    }
}
