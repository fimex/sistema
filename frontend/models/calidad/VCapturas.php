<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_capturas".
 *
 * @property integer $folio
 * @property string $cliente
 * @property string $no_parte
 * @property string $fecha
 * @property string $maquina
 * @property string $orden_fabricacion
 * @property integer $operacion
 */
class VCapturas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_capturas';
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
            [['folio', 'operacion'], 'integer'],
            [['cliente', 'no_parte', 'fecha', 'maquina', 'orden_fabricacion', 'operacion'], 'required'],
            [['cliente', 'maquina', 'orden_fabricacion'], 'string'],
            [['fecha'], 'safe'],
            [['no_parte'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'folio' => 'Folio',
            'cliente' => 'Cliente',
            'no_parte' => 'No Parte',
            'fecha' => 'Fecha',
            'maquina' => 'Maquina',
            'orden_fabricacion' => 'Orden Fabricacion',
            'operacion' => 'Operacion',
        ];
    }
}
