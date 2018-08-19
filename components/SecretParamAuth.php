<?php

namespace app\components;

use Yii;
use yii\web\Request;
use yii\web\UnauthorizedHttpException;
use yii\base\ActionFilter;;
use app\exceptions\MissingParameterException;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 19.08.18
 * Time: 16:08
 */

class SecretParamAuth extends ActionFilter
{
    /**
     * @var string the parameter name for passing the access token
     */
    public $tokenParam = 'secret';
    public $idParam = 'id';
    public $nameParam = 'name';

    /**
     * Authenticates the request.
     * @param Request $request
     * @throws UnauthorizedHttpException if authentication information is provided but is invalid.
     * @throws MissingParameterException if miss some parameters
     */
    public function authenticate($request)
    {
        $accessToken = $request->get($this->tokenParam);
        $id = $request->get($this->idParam);
        $name = $request->get($this->nameParam);
        if($id === null || $accessToken === null) {
            throw new MissingParameterException;
        }
        $secret = ($name) ? sha1($id.$name) : sha1($id);
        if($secret !== $accessToken) {
            throw new UnauthorizedHttpException();
        }
    }

    public function beforeAction($action)
    {
        $this->authenticate(Yii::$app->request);
        return true;
    }

}