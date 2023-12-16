<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $name
 * @property string|null $date
 * @property string|null $description
 *
 * @property EventOrganizer[] $eventOrganizers
 * @property Organizer[] $organizers
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date' => 'Date',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[EventOrganizers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventOrganizers()
    {
        return $this->hasMany(EventOrganizer::class, ['event_id' => 'id']);
    }

    /**
     * Gets query for [[Organizers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizers()
    {
        return $this->hasMany(Organizer::class, ['id' => 'organizer_id'])->viaTable('event_organizer', ['event_id' => 'id']);
    }
}
