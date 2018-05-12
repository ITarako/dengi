<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

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
        if ($this->validate()) {
            $this->operationsFile->saveAs('uploads/' . $this->operationsFile->baseName . '.' . $this->operationsFile->extension);
            return true;
        } else {
            return false;
        }
    }
}