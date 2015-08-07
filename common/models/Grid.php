<?php
namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\URL;

/**
 * Grid 
 * 
 * Esta clase fue generada para poder llamar el grid de JQuery Easy UI desde cualquier parte del proyecto
 * La clase esta en proceso de actualizacion pero quedaria funcional en poco tiempo.
 * 
 */
class Grid
{
    public $id;
    public $class = "easyui-datagrid";
    public $title = "";
    public $style;
    public $data;
    
    public $columns;
    public $frozenColumns;
    
    public $dataOptions;
    public $toolbar;
    public $loadMsg = "Cargando datos";
    
    public $onClickRow;
    public $onLoadSuccess;
    public $onAfterEdit;
    public $onUnselect;
    public $groupFormatter;
    public $view;
    public $queryParams;
    
    /**
     * @inheritdoc
     */
    public function __construct($params=[]){
        foreach($params as $key =>$val){
            $this->{$key} = $val;
        }
    }
    
    public function display(){
        $this->prepareDataOptions();
        
        echo Html::beginTag('table',[
            'id'=>$this->id,
            'class'=>$this->class,
            'title'=>$this->title,
            'style'=>$this->style,
            'data-options'=>$this->dataOptions
        ]);
            $this->displayFrozenColumns();
            $this->displayColumns();
        echo Html::endTag('table');
    }
    
    public function prepareDataOptions(){
        $this->dataOptions = $this->getText($this->dataOptions);
        $this->dataOptions .= $this->data !== null ? ", data: ".$this->data : "";
        $this->dataOptions .= $this->queryParams !== null ? ", queryParams: ".$this->queryParams : "";
        $this->dataOptions .= ", loadMsg: '".$this->loadMsg."'";
        $this->dataOptions .= $this->onLoadSuccess !== null ? ", onLoadSuccess: ".$this->onLoadSuccess : "";
        $this->dataOptions .= $this->onAfterEdit !== null ? ", onAfterEdit: ".$this->onAfterEdit : "";
        $this->dataOptions .= $this->onClickRow !== null ? ", onClickRow: ".$this->onClickRow : "";
        $this->dataOptions .= $this->onUnselect !== null ? ", onUnselect: ".$this->onUnselect : "";
        $this->dataOptions .= $this->toolbar !== null ? ", toolbar: ".$this->toolbar : "";
        $this->dataOptions .= $this->groupFormatter !== null ? ", groupFormatter: ".$this->groupFormatter : "";
        $this->dataOptions .= $this->view !== null ? ", view: ".$this->view : "";
    }
    
    public function displayFrozenColumns(){
        if(isset($this->frozenColumns)){
            echo Html::beginTag('thead',['data-options'=>'frozen:true']);
            foreach ($this->frozenColumns as $frozen){
                echo Html::beginTag('tr');
                    echo $this->setField($frozen);
                echo Html::endTag('tr');
            }
            echo Html::endTag('thead');
        }
    }
    public function displayColumns(){
        if(isset($this->columns)){
            echo Html::beginTag('thead');
            foreach ($this->columns as $item){
                echo Html::beginTag('tr');
                    echo $this->setField($item);
                echo Html::endTag('tr');
            }
            echo Html::endTag('thead');
        }
    }
    
    public function setField($columns){
        foreach ($columns as $field => $params){
            $label = $field;
            if(isset($params['label'])){
                $label = $params['label'];
                unset($params['label']);
            }
            if(isset($params['data-options']) && !is_numeric($label)){
                $params['data-options'] = isset($params['data-options']) ? "field:'$field',".$this->getText($params['data-options']) : "field:'$field'";
                $params['data-options'] = str_replace('"', "'", json_encode($params['data-options']));
                $params['data-options'] = substr($params['data-options'],1, (strlen($params['data-options'])-2));
            }else{
                $params['data-options'] =  "field:'$field'";
            }
            if(isset($params)){
                echo Html::Tag('th',$label,$params);
            }else{
                echo Html::Tag('th');
            }
            
        }
    }

    public function getText($array){
        $text = "";
        foreach($array as $key => $data){
            if(is_array($data)){
                $val="$key:{".$this->getText($data)."},";
            }else{
                $val = is_numeric($data) || $data=='true' || $data=='false' ? "$key:$data," : "$key:'$data',";
                if(is_bool($data)){
                    $val = $data == true ? "$key:true," : "$key:false,";
                }

            }
            $text .= $val;
        }
        return substr($text,0,strlen($text)-1);
    }
}
