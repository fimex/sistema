<?php

namespace common\models\vistas;

use Yii;

/**
 * This is the model class for table "v_MaterialArania".
 *
 * @property string $Aleacion
 * @property integer $Semana
 * @property integer $Anio
 * @property string $TonTotales
 * * @property string $TonTotalesCasting 
 */
class VMaterialArania extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_MaterialArania';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Aleacion'], 'string'],
            [['Semana', 'Anio'], 'required'],
            [['Semana', 'Anio'], 'integer'],
            [['TonTotales', 'TonTotalesCasting'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Aleacion' => 'Aleacion',
            'Semana' => 'Semana',
            'Anio' => 'Anio',
            'TonTotales' => 'Ton Totales',
        ];
    }
    
    public function getMaterial($semanas,$anio,$cant,$sem,$area){

        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM (SELECT TonTotales,Semana,Aleacion,Anio FROM FIMEX_Produccion.dbo.v_MaterialArania WHERE Anio = $anio AND IdArea = $area) PI
                                            PIVOT (SUM(TonTotales) FOR Semana IN ( $semanas ) ) AS PivotTable"
                )->queryAll();

        $aleacion = '';
        $i = 1;
        foreach ($result as &$value) {
            
            $value['PesoTot'] = $value[$sem];
            $sem = $sem + 1;
            
            if ($aleacion != $value['Aleacion']) {
                $sem = $sem - $i; 
                $i = 0;
            } 
            
            $aleacion = $value['Aleacion'];
            
            $i++;
        }
        
        return $result;
    }
    
    public function getMaterialCasting($semanas,$anio,$cant,$sem,$area){

        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM (SELECT TonTotalesCasting,Semana,Aleacion,Anio FROM FIMEX_Produccion.dbo.v_MaterialArania WHERE Anio = $anio AND IdArea = $area) PI
                                            PIVOT (SUM(TonTotalesCasting) FOR Semana IN ( $semanas ) ) AS PivotTable"
                )->queryAll();

        $aleacion = '';
        $i = 1;
        foreach ($result as &$value) {
            
            $value['PesoTot'] = $value[$sem];
            $sem = $sem + 1;
            
            if ($aleacion != $value['Aleacion']) {
                $sem = $sem - $i; 
                $i = 0;
            } 
            
            $aleacion = $value['Aleacion'];
            
            $i++;
        }
        
        return $result;
    }
}
