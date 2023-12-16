<?php

namespace app\models\organizer;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\Event;
use app\models\Organizer;
use app\models\EventOrganizer;

class UpdateOrganizer extends Model
{
    public $_model;

    public $full_name;
    public $email;
    public $phone;
    public $events = [];

    public $listEvents;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'email'], 'required'],
            [['email'], 'email'],
            [['phone'], 'match', 'pattern' => Organizer::PHONE_PATTERN],
            [['full_name', 'email', 'phone'], 'string', 'max' => 255],
            [['email', 'phone'], 'trim'],
            [['phone'], 'default', 'value' => null],
            [['events'], 'safe'],
            [['events'], 'default', 'value' => []],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->listEvents = ArrayHelper::map(Event::find()->all(), 'id', 'name');

        $this->full_name = $this->_model->full_name;
        $this->email = $this->_model->email;
        $this->phone = $this->_model->phone;

        foreach ($this->_model->events as $event) {
            $this->events[] = $event->id;
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
        $model->full_name = $this->full_name;
        $model->email = $this->email;
        $model->phone = $this->phone;
        $organizer_id = $this->_model->id;
        $transaction = Yii::$app->db->beginTransaction();
        $events = EventOrganizer::findAll(['organizer_id' => $organizer_id]);
        $status_delete = count($events) === 0 || EventOrganizer::deleteAll(['organizer_id' => $organizer_id]);
        if ($model->save() && $status_delete) {
            $status = true;
            foreach ($this->events as $event_id) {
                $event = new EventOrganizer();
                $event->event_id = $event_id;
                $event->organizer_id = $organizer_id;
                if (!$event->save()) {
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
        return (new Organizer)->attributeLabels();
    }
}