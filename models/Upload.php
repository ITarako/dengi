<?php

namespace app\models;

use Yii;
use DateTime;
use DateTimeZone;

/**
 * This is the model class for table "uploads".
 *
 * @property int $id
 * @property string $filename
 * @property int $filesize Bytes
 * @property string $extension
 * @property string $path
 * @property string $uploaded_at
 * @property int $id_user
 *
 * @property User $user
 */
class Upload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uploads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename', 'filesize', 'extension', 'path', 'uploaded_at', 'id_user'], 'required'],
            [['filesize', 'id_user'], 'default', 'value' => null],
            [['filesize', 'id_user'], 'integer'],
            [['uploaded_at'], 'safe'],
            [['filename', 'extension', 'path'], 'string', 'max' => 255],
            [['path'], 'unique'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'filesize' => 'Filesize',
            'extension' => 'Extension',
            'path' => 'Path',
            'uploaded_at' => 'Uploaded At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * {@inheritdoc}
     * @return UploadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UploadQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();

        $dateTime = new DateTime($this->uploaded_at);
        // TODO: После добаления указания таймзоны пользователем, изменять таймзону на соответствующую
        $dateTime->setTimeZone(new DateTimeZone('Asia/Barnaul'));
        $this->uploaded_at = $dateTime->format('Y-m-d H:i');

        $size = $this->filesize;
        if ($size < 1024) {
            $size .= ' B';
        } elseif ($size < 1024*1024) {
            $size /= 1024;
            $size = number_format($size, 2);
            $size .= ' KB';
        } else {
            $size /= 1024*1024;
            $size = number_format($size, 2);
            $size .= ' MB';
        }
        $this->filesize = $size;
    }
}
