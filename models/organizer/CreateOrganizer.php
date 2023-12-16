<?php

namespace app\models\organizer;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\Event;
use app\models\Organizer;
use app\models\EventOrganizer;

class CreateOrganizer extends Model
{
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
    }

    /**
     * Create new model
     * @return bool|null
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        $model = new Organizer();
        $model->full_name = $this->full_name;
        $model->email = $this->email;
        $model->phone = $this->phone;
        $transaction = Yii::$app->db->beginTransaction();
        if ($model->save()) {
            $organizer_id = $model->getPrimaryKey();
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