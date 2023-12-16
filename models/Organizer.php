<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organizer".
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string|null $phone
 *
 * @property EventOrganizer[] $eventOrganizers
 * @property Event[] $events
 */
class Organizer extends \yii\db\ActiveRecord
{
    const PHONE_PATTERN = '/^\d{1,4}\d{1,}\d{1,}$/';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organizer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'email'], 'required'],
            [['email'], 'email'],
            [['phone'], 'match', 'pattern' => self::PHONE_PATTERN],
            [['full_name', 'email', 'phone'], 'string', 'max' => 255],
            [['email', 'phone'], 'trim'],
            [['phone'], 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }

    /**
     * Gets query for [[EventOrganizers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventOrganizers()
    {
        return $this->hasMany(EventOrganizer::class, ['organizer_id' => 'id']);
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::class, ['id' => 'event_id'])->viaTable('event_organizer', ['organizer_id' => 'id']);
    }
}
