<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\lib\OperationsGenerator;
use yii\helpers\Console;

class GenerateController extends Controller
{
    public $file;
    public $count;
    public $account;

    public function options($actionID)
    {
        return [
            'file',
            'count',
            'account'
        ];
    }

    public function optionAliases()
    {
        return [
            'f' => 'file',
            'c' => 'count',
            'a' => 'account'
        ];
    }

    public function actionOperations()
    {
        $path = './generated/operations';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $operation = new OperationsGenerator($this->account);
        $data = $operation->getJsonOperations($this->count);
        file_put_contents("$path/{$this->file}", $data);

        $res = Console::ansiFormat($path . '/' . $this->file, [Console::BG_GREEN]);
        Console::output($res);

        return ExitCode::OK;
    }
}
