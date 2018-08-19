<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 04.08.18
 * Time: 20:22
 */
namespace app\exceptions;

use yii\base\Exception;

class MissingParameterException extends Exception
{
    protected $message = 'missing parameter';

    public function getName()
    {
        return 'MissingParameterException';
    }

}