<?php

namespace frontend\models\produccion;

use Yii;
use common\models\dux\Productos;
use frontend\models\produccion\TiemposMuerto;

/**
 * This is the model class for table "ProduccionesDetalle".
 *
 * @property integer $IdProduccionDetalle
 * @property integer $IdProduccion
 * @property integer $IdProgramacion
 * @property integer $IdProductos
 * @property string $Inicio
 * @property string $Fin
 * @property integer $CiclosMolde
 * @property integer $PiezasMolde
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $Rechazadas
 * @property string $Eficiencia
 *
 * @property SeriesDetalles[] $seriesDetalles
 * @property Productos $idProductos
 * @property Programaciones $idProgramacion
 * @property Producciones $idProduccion
 * @property FechaMoldeoDetalle[] $fechaMoldeoDetalles
 * @property ProduccionesDefecto[] $produccionesDefectos
 * @property ProduccionesCiclos[] $produccionesCiclos
 */
class ProduccionesDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdProgramacion', 'IdProductos', 'Eficiencia'], 'required'],
            [['IdProduccion', 'IdProgramacion', 'IdProductos', 'CiclosMolde', 'PiezasMolde', 'Programadas', 'Hechas', 'Rechazadas'], 'integer'],
            [['Inicio', 'Fin'], 'safe'],
            [['Eficiencia'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdProduccion' => 'Id Produccion',
            'IdProgramacion' => 'Id Programacion',
            'IdProductos' => 'Id Productos',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'CiclosMolde' => 'Ciclos Molde',
            'PiezasMolde' => 'Piezas Molde',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'Rechazadas' => 'Rechazadas',
            'Eficiencia' => 'Eficiencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeriesDetalles()
    {
        return $this->hasMany(SeriesDetalles::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProductos()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProductos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacion()
    {
        return $this->hasOne(Programaciones::className(), ['IdProgramacion' => 'IdProgramacion']);
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
    public function getFechaMoldeoDetalles()
    {
        return $this->hasMany(FechaMoldeoDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDefectos()
    {
        return $this->hasMany(ProduccionesDefecto::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesCiclos()
    {
        return $this->hasMany(ProduccionesCiclos::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }
    
    public function getDatos($maquina,$ini,$fin,$area,$subProceso){
        if($ini == 0){
            $fecha = date('Y-m-d');
            $where = " WHERE Fecha = '$fecha' AND pr.IdMaquina IN(SELECT IdMaquina FROM v_Maquinas WHERE IdArea = $area AND IdSubProceso = $subProceso) ";
        }else{
            $where = "WHERE Fecha between '$ini' AND '$fin'";
        }
        if($maquina){
            $and = "AND pr.IdMaquina = $maquina";
        }else{$and="AND pr.IdMaquina IN(SELECT IdMaquina FROM v_Maquinas WHERE IdArea = $area AND IdSubProceso = $subProceso)";}
        $command = \Yii::$app->db;
        $result = $command->createCommand('SELECT pd.IdProduccionDetalle, pd.Inicio, pd.Fin, pd.Hechas, pd.Rechazadas, 
                                                  p.Identificacion, p.MoldesHora, pr.IdMaquina, DATEPART("ww", pd.Inicio) as Semana
                                          FROM ProduccionesDetalle AS pd
                                          LEFT JOIN Productos AS p ON pd.IdProductos = p.IdProducto
                                          LEFT JOIN Producciones AS pr ON pd.IdProduccion = pr.IdProduccion
                                          '.$where.' '.$and.' ORDER BY pd.Inicio ASC ')->queryAll();

        foreach ($result as &$key) {
            $key['SU'] = 0;
            $key['MC'] = 0;
            $key['MP'] = 0;
            $key['MI'] = 0;
            $key['MPRO'] = 0;
            $key['TT'] = 0;
            $key['OK'] = 0;
            $key['Rec'] = 0;
            
            $key['Inicio'] = strtotime(date('H:i',strtotime($key['Inicio']))) < strtotime('07:00') ? (date('Y-m-d',strtotime($key['Inicio']))." 07:00") : $key['Inicio'];
            $key['Inicio'] = strtotime(date('H:i',strtotime($key['Inicio']))) > strtotime('17:00') ? (date('Y-m-d',strtotime($key['Inicio']))." 17:00") : $key['Inicio'];

            $key['Fin'] = strtotime(date('H:i',strtotime($key['Fin']))) > strtotime('17:00') ? (date('Y-m-d',strtotime($key['Fin']))." 17:00") : $key['Fin'];
            $key['Fin'] = strtotime(date('H:i',strtotime($key['Fin']))) < strtotime('07:00') ? (date('Y-m-d',strtotime($key['Fin']))." 07:00") : $key['Fin'];                                                       
            
            $TiP = strtotime(date('H:i',strtotime($key['Inicio'])))/60;
            $TfP = strtotime(date('H:i',strtotime($key['Fin'])))/60;

            $fecha = date('Y-m-d',strtotime($key['Inicio']));
            $semana = date('W',strtotime($key['Inicio']));
            
            $timeDead = \common\models\vistas\VTiemposMuertos::find()->where("IdArea = $area AND IdMaquina = ".$key['IdMaquina']."AND Fecha = '$fecha'")->asArray()->all();
            
            $ete = $command->createCommand("
                SELECT DATEPART(WW, DuxSinc.dbo.v_entrada_plb_detalle.FECHA) AS SEM, SUM(DuxSinc.dbo.v_entrada_plb_detalle.CANTIDAD) as U,
                    SUM(CAST(DuxSinc.dbo.v_entrada_plb_detalle.PESO AS FLOAT)* DuxSinc.dbo.v_entrada_plb_detalle.CANTIDAD) as KiloSprod FROM DuxSinc.dbo.v_entrada_plb_detalle
                WHERE DATEPART(WW, DuxSinc.dbo.v_entrada_plb_detalle.FECHA) = '$semana'
                GROUP BY DATEPART(WW, DuxSinc.dbo.v_entrada_plb_detalle.FECHA), DuxSinc.dbo.v_entrada_plb_detalle.FECHA")->queryAll();
            
            foreach ($ete as &$value) {
                $key['OK'] += $value['KiloSprod'];
            }
            //$key['OK'] /= count($ete);
            $eteR = $command->createCommand("
                SELECT DuxSinc.dbo.v_rechaza_plb.SEM,
                    COUNT(DuxSinc.dbo.v_rechaza_plb.FECHA) AS DiasTrab,
                    SUM(DuxSinc.dbo.v_rechaza_plb.U) AS pzas,
                    SUM(DuxSinc.dbo.v_rechaza_plb.KgRec) AS TotKgRec
                FROM DuxSinc.dbo.v_rechaza_plb
                WHERE DuxSinc.dbo.v_rechaza_plb.SEM = '$semana'
                GROUP BY DuxSinc.dbo.v_rechaza_plb.SEM;")->queryAll();
            
            foreach ($eteR as &$value) {
                $key['Rec'] = $value['TotKgRec'];
            }
            $x=1;
            foreach ($timeDead as $datos) {
                //echo "<h4>TiempoMuerto</h4>";
                //var_dump($datos);
                
                $datos['Inicio'] = strtotime(date('H:i',strtotime($datos['Inicio']))) < strtotime('07:00') ? (date('Y-m-d',strtotime($datos['Inicio']))." 07:00") : $datos['Inicio'];
                $datos['Inicio'] = strtotime(date('H:i',strtotime($datos['Inicio']))) > strtotime('17:00') ? (date('Y-m-d',strtotime($datos['Inicio']))." 17:00") : $datos['Inicio'];
                
                $datos['Fin'] = strtotime(date('H:i',strtotime($datos['Fin']))) > strtotime('17:00') ? (date('Y-m-d',strtotime($datos['Fin']))." 17:00") : $datos['Fin'];
                $datos['Fin'] = strtotime(date('H:i',strtotime($datos['Fin']))) < strtotime('07:00') ? (date('Y-m-d',strtotime($datos['Fin']))." 07:00") : $datos['Fin'];
                
                $TiM = strtotime(date('H:i',strtotime($datos['Inicio'])))/60;
                $TfM = strtotime(date('H:i',strtotime($datos['Fin'])))/60;
                
                if($TiM >= $TiP && $TfM <= $TfP ){
                    $key[$datos['ClaveTipo']] += $TfM - $TiM;
                }
            }
        }
        //exit;
        return $result;
    }
}
