<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "parmediciones".
 *
 * @property integer $id
 * @property integer $idFolio
 * @property string $fecha
 * @property integer $operacion
 * @property integer $inspeccion
 * @property string $serie
 * @property string $cantidad
 * @property string $observaciones
 * @property integer $status
 * @property string $usuario
 * @property string $file
 *
 * @property MedicionesDimenciones[] $medicionesDimenciones
 * @property Mediciones $idFolio0
 * @property CatInspeccion $inspeccion0
 * @property Usuarios $usuario0
 */
class Parmediciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parmediciones';
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
            [['idFolio', 'operacion', 'inspeccion', 'cantidad', 'usuario'], 'required'],
            [['idFolio', 'operacion', 'inspeccion', 'status'], 'integer'],
            [['fecha'], 'safe'],
            [['serie', 'observaciones', 'file'], 'string'],
            [['cantidad'], 'number'],
            [['usuario'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idFolio' => 'Id Folio',
            'fecha' => 'Fecha',
            'operacion' => 'Operacion',
            'inspeccion' => 'Inspeccion',
            'serie' => 'Serie',
            'cantidad' => 'Cantidad',
            'observaciones' => 'Observaciones',
            'status' => 'Status',
            'usuario' => 'Usuario',
            'file' => 'File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicionesDimenciones()
    {
        return $this->hasMany(MedicionesDimenciones::className(), ['parMedicion' => 'id'])->orderBy('pieza , dimension');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFolio0()
    {
        return $this->hasOne(Mediciones::className(), ['folio' => 'idFolio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInspeccion0()
    {
        return $this->hasOne(CatInspeccion::className(), ['id' => 'inspeccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuarios::className(), ['usuario' => 'usuario']);
    }
}
