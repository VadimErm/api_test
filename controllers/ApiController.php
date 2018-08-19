<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 04.08.18
 * Time: 18:48
 */

namespace app\controllers;

use Yii;
use ErrorException;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use app\models\TweeterUser;
use app\components\SecretParamAuth;
use app\components\TwitterHelper;


class ApiController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => SecretParamAuth::class,
        ];
        return $behaviors;
    }

    public function actionAdd()
    {
        $tweeterUser = Yii::$app->request->get('name');
        $model = new TweeterUser;
        $model->name = $tweeterUser;
        if(!$model->save()) {
            throw new ErrorException;
        }
    }

    public function actionFeed()
    {
        $users = TweeterUser::find()->select('name')->all();
        return TwitterHelper::getFeed($users);

    }

    public function actionRemove()
    {
        $tweeterUserName = Yii::$app->request->get('name');
        $model = $this->findModel($tweeterUserName);
        $model->delete();
    }

    private function findModel($name)
    {
        if (($model = TweeterUser::findByName($name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException;
        }
    }


}