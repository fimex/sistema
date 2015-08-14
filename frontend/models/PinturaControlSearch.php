<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\produccion\PinturaControl;

/**
 * PinturaControlSearch represents the model behind the search form about `frontend\models\produccion\PinturaControl`.
 */
class PinturaControlSearch extends PinturaControl
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pintura'], 'integer'],
            [['fecha', 'turno', 'Motivo', 'pintura', 'serie', 'comentarios', 'nomina', 'area', 'base', 'timestamp'], 'safe'],
            [['den_ini', 'den_fin', 'pin_nueva', 'pin_recicl', 'alcohol', 'base_cant'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PinturaControl::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->load($params) && !$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_pintura' => $this->id_pintura,
            'fecha' => $this->fecha,
            'den_ini' => $this->den_ini,
            'den_fin' => $this->den_fin,
            'pin_nueva' => $this->pin_nueva,
            'pin_recicl' => $this->pin_recicl,
            'alcohol' => $this->alcohol,
            'base_cant' => $this->base_cant,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'turno', $this->turno])
            ->andFilterWhere(['like', 'Motivo', $this->Motivo])
            ->andFilterWhere(['like', 'pintura', $this->pintura])
            ->andFilterWhere(['like', 'serie', $this->serie])
            ->andFilterWhere(['like', 'comentarios', $this->comentarios])
            ->andFilterWhere(['like', 'nomina', $this->nomina])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'base', $this->base]);

        return $dataProvider;
    }
}
