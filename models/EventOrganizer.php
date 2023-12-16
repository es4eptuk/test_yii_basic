<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event_organizer".
 *
 * @property int $event_id
 * @property int $organizer_id
 *
 * @property Event $event
 * @property Organizer $organizer
 */
class EventOrganizer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_organizer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'organizer_id'], 'required'],
            [['event_id', 'organizer_id'], 'default', 'value' => null],
            [['event_id', 'organizer_id'], 'integer'],
            [['event_id', 'organizer_id'], 'unique', 'targetAttribute' => ['event_id', 'organizer_id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
            [['organizer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizer::class, 'targetAttribute' => ['organizer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'organizer_id' => 'Organizer ID',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

    /**
     * Gets query for [[Organizer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizer()
    {
        return $this->hasOne(Organizer::class, ['id' => 'organizer_id']);
    }
}
