<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\lib\Utils;
use \DateTime;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $operationsFile;

    public function rules()
    {
        return [
            [['operationsFile'], 'file', 'skipOnEmpty' => false],
            [['operationsFile'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'json'],
        ];
    }

    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }

        $upload = new Upload();
        $upload->filename = $this->operationsFile->baseName;
        $upload->filesize = $this->operationsFile->size;
        $upload->extension = $this->operationsFile->extension;
        $upload->id_user = Yii::$app->user->id;
        $time = new DateTime();
        $upload->uploaded_at = $time->format(DateTime::W3C);
        $upload->path = 'uploads/operations/' . Utils::guidv4() .".". $upload->extension;

        if (!file_exists('uploads/operations')) {
            mkdir('uploads/operations', 0777, true);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($upload->save()) {
                $this->operationsFile->saveAs($upload->path);
                $transaction->commit();
                return true;
            }
        } catch (\Throwable $e) {
            if (file_exists($upload->path))
                unlink($upload->path);

            $transaction->rollBack();
            return false;
        }
    }
}
