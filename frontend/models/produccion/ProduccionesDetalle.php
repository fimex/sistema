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
    
    public function getDatos($maquina,$ini,$fin,$area,$subProceso,$turno){
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
        $result = $command->createCommand('SELECT pr.Fecha, pd.IdProduccionDetalle, pd.Inicio, pd.Fin, pd.Hechas, pd.Rechazadas, 
                                                  p.Identificacion, p.MoldesHora, pr.IdMaquina, DATEPART("ww", pd.Inicio) as Semana
                                          FROM ProduccionesDetalle AS pd
                                          LEFT JOIN Productos AS p ON pd.IdProductos = p.IdProducto
                                          LEFT JOIN Producciones AS pr ON pd.IdProduccion = pr.IdProduccion
                                          '.$where.' '.$and.' AND pr.IdTurno = '.$turno.' ORDER BY pr.Fecha ASC, pd.Inicio ASC ')->queryAll();

        foreach ($result as &$key) {
            $key['SU'] = 0;
            $key['MC'] = 0;
            $key['MP'] = 0;
            $key['MI'] = 0;
            $key['MPRO'] = 0;
            $key['TT'] = 0;
            $key['OK'] = 0;
            $key['Rec'] = 0;
            
            $key['Fecha'] = date('Y-m-d',strtotime($key['Fecha']));
            $Fecha = $key['Fecha'];
            $key['Inicio'] = date('H:i:s',strtotime($key['Inicio']));
            $key['Fin'] = date('H:i:s',strtotime($key['Fin']));
            
            $HIni = $turno == 1 ? '07:00' : '22:00';
            $HFin = $turno == 1 ? '17:00' : '07:00';
            
            $res = $this->limiteHoras($key['Inicio'], $key['Fin'], "$Fecha $HIni",($HIni <= $HFin ? $Fecha : date('Y-m-d',strtotime('+1 day',strtotime($Fecha))))." $HFin");
            
            $key['Inicio'] = $res[0];
            $key['Fin'] = $res[1];
            //$key['Fin'] = $this->limiteHoras($key['Fin'], "$Fecha $HIni",($HIni <= $HFin ? $Fecha : date('Y-m-d',strtotime('+1 day',strtotime($Fecha))))." $HFin");
            
            $TiP = strtotime(date('H:i',strtotime($key['Inicio'])))/60;
            $TfP = strtotime(date('H:i',strtotime($key['Fin'])))/60;

            $fecha = date('Y-m-d',strtotime($key['Fecha']));
            $semana = date('W',strtotime($key['Fecha']));
            
            $timeDead = \common\models\vistas\VTiemposMuertos::find()->where("IdArea = $area AND IdMaquina = ".$key['IdMaquina']."AND Fecha = '$fecha' AND IdTurno = $turno ")->asArray()->all();
            
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
                
                $datos['Inicio'] = date('H:i:s',strtotime($datos['Inicio']));
                $datos['Fin'] = date('H:i:s',strtotime($datos['Fin']));
                
                //echo "In :  ";
                $res = $this->limiteHoras($datos['Inicio'],$datos['Fin'], $key['Inicio'], $key['Fin']);
                
                $datos['Inicio'] = $res[0];
                $datos['Fin'] = $res[1];
                //echo $datos['Inicio']." - ".$datos['Fin'] ;
                //$datos['Fin'] = $this->limiteHoras($datos['Fin'], $key['Inicio'], $key['Fin']);
                
                $TiM = strtotime($datos['Inicio'])/60;
                $TfM = strtotime($datos['Fin'])/60;
                
                //echo "$TfM - $TiM = ".($TfM - $TiM)."<br />";
                $key[$datos['ClaveTipo']] += ($TfM - $TiM);
            }
        }
        //exit;
        return $result;
    }
    
    function limiteHoras($horaIni,$horaFin,$limiteIni,$limiteFin){
        
        $fecha = date('Y-m-d',strtotime($limiteIni));
        $horaIni = date('H:i:s',strtotime($horaIni));
        $horaFin = date('H:i:s',strtotime($horaFin));
        
        $fecha2 = strtotime(date('H:i:s',strtotime($limiteIni))) <= strtotime(date('H:i:s',strtotime($limiteFin))) ? $fecha : date('Y-m-d',strtotime('+1 day',strtotime($fecha)));
        $fecha3 = strtotime(date('H:i:s',strtotime($limiteIni))) <= strtotime(date('H:i:s',strtotime($limiteFin))) ? $fecha : date('Y-m-d',strtotime('-1 day',strtotime($fecha)));
        $horaIni = (strtotime($horaIni) <= strtotime('07:00') ? $fecha2 : $fecha) ." $horaIni";
        $horaFin = (strtotime($horaFin) <= strtotime('07:00') ? $fecha2 : $fecha) ." $horaFin";
        $horaIni =  strtotime($horaIni) > strtotime($horaFin) ? date('Y-m-d H:i:s',strtotime('-1 day',strtotime($horaIni))) : $horaIni;
        
        
        $hora = $horaIni;
        $hora2 = $horaFin;
        
        $hora = strtotime($hora) <= strtotime($limiteFin) ? $hora : $limiteFin;
        $hora = strtotime($hora) >= strtotime($limiteIni) ? $hora : $limiteIni;
        $hora2 = strtotime($hora2) <= strtotime($limiteFin) ? $hora2 : $limiteFin;
        $hora2 = strtotime($hora2) >= strtotime($limiteIni) ? $hora2 : $limiteIni;
        
        //echo "<hr />$limiteIni - $limiteFin :::: $horaIni == $hora  |||| $horaFin == $hora2 <br />";
        
        return [$hora,$hora2];
    }
}
