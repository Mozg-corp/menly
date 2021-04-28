<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_fotos".
 *
 * @property int $id
 * @property string $file
 * @property int|null $id_files_types
 * @property int $id_users
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property FilesTypes $filesTypes
 * @property Users $users
 */
class UsersFotos extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE = 'update file';
    const SCENARIO_CREATE = 'create file';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_fotos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'id_users'], 'required'],
            [['file'], 'string'],
            [['id_files_types', 'id_users'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_files_types'], 'exist', 'skipOnError' => true, 'targetClass' => FilesTypes::className(), 'targetAttribute' => ['id_files_types' => 'id']],
            [['id_users'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_users' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'id_files_types' => 'Id Files Types',
            'id_users' => 'Id Users',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[FilesTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilesTypes()
    {
        return $this->hasOne(FilesTypes::className(), ['id' => 'id_files_types']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_users']);
    }

}
