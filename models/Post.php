<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $id_users
 * @property string|null $title
 * @property string|null $body
 * @property string|null $preview
 * @property string|null $img
 * @property string $createAt
 * @property string $updatedAt
 * @property string|null $postedAt
 *
 * @property Users $users
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([], parent::rules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_users' => 'Id Users',
            'title' => 'Title',
            'body' => 'Body',
            'preview' => 'Preview',
            'img' => 'Img',
            'createAt' => 'Create At',
            'updatedAt' => 'Updated At',
            'postedAt' => 'Posted At',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_users']);
    }

    /**
     * {@inheritdoc}
     * @return PostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostsQuery(get_called_class());
    }
}
