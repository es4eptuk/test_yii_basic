<?php

namespace app\models\event;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\Event;
use app\models\Organizer;
use app\models\EventOrganizer;

class UpdateEvent extends Model
{
    public $_model;

    public $name;
    public $date;
    public $description;
    public $organizers = [];

    public $listOrganizers;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['organizers'], 'safe'],
            [['organizers'], 'default', 'value' => []],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->listOrganizers = ArrayHelper::map(Organizer::find()->all(), 'id', 'full_name');

        $this->name = $this->_model->name;
        $this->date = $this->_model->date;
        $this->description = $this->_model->description;

        foreach ($this->_model->organizers as $organizer) {
            $this->organizers[] = $organizer->id;
        }
    }

    /**
     * Update model
     * @return bool|null
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $model = $this->_model;
        $model->name = $this->name;
        $model->date = $this->date;
        $model->description = $this->description;
        $event_id = $this->_model->id;
        $transaction = Yii::$app->db->beginTransaction();
        $organizers = EventOrganizer::findAll(['event_id' => $event_id]);
        $status_delete = count($organizers) === 0 || EventOrganizer::deleteAll(['event_id' => $event_id]);
        if ($model->save() && $status_delete) {
            $status = true;
            foreach ($this->organizers as $organizer_id) {
                $organizer = new EventOrganizer();
                $organizer->event_id = $event_id;
                $organizer->organizer_id = $organizer_id;
                if (!$organizer->save()) {
                    $status = false;
                    break;
                }
            }
            if ($status) {
                $transaction->commit();
                return true;
            }
        }
        $transaction->rollBack();
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new Event)->attributeLabels();
    }
}