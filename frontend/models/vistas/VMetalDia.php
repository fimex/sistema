<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_MetalDia".
 *
 * @property string $Aleacion
 * @property integer $IdArea
 * @property string $Dia
 * @property integer $Semana
 * @property integer $Anio
 * @property string $TonTotales
 * @property string $TonTotalesCasting
 */
class VMetalDia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_MetalDia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Aleacion'], 'string'],
            [['IdArea', 'Semana', 'Anio'], 'integer'],
            [['Dia'], 'safe'],
            [['Semana', 'Anio'], 'required'],
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
            'IdArea' => 'Id Area',
            'Dia' => 'Dia',
            'Semana' => 'Semana',
            'Anio' => 'Anio',
            'TonTotales' => 'Ton Totales',
            'TonTotalesCasting' => 'Ton Totales Casting',
        ];
    }

    public function getMaterial($dias,$anio,$sem,$area){

        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM (SELECT TonTotales,Dia,Aleacion,Anio FROM FIMEX_Produccion.dbo.v_MetalDia WHERE Anio = $anio AND IdArea = $area) PI
                                            PIVOT (SUM(TonTotales) FOR Dia IN ( $dias ) ) AS PivotTable"
                )->queryAll();
      

        /*$aleacion = '';
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
        }*/
        
        return $result;
    }
}
