<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 19.08.18
 * Time: 18:42
 */

namespace app\components;

use Yii;
use yii\authclient\OAuthToken;
use app\models\TweeterUser;

class TwitterHelper
{
    private static $client;

    private static function getClient()
    {
        if(self::$client === null) {
            $token = new OAuthToken([
                'token' => Yii::$app->params['accessToken'],
                'tokenSecret' => Yii::$app->params['accessTokenSecret']
            ]);
            /** @var yii\authclient\clients\Twitter $client */
            $client = Yii::$app->authClientCollection->getClient('twitter');
            $client->setAccessToken($token);
            self::$client = $client;
        }
        return self::$client;
    }

    private static function getLastTweet($userName)
    {
        $client = self::getClient();
        $tweet = $client->api('statuses/home_timeline.json?screen_name='.$userName.'&exclude_replies=true&include_rts=false&count=1', 'GET');
        if(!empty($tweet)) {
            return $tweet[0];
        }
        return null;
    }


    public static function getFeed($users)
    {
        $feed = [];
        /** @var TweeterUser $user */
        foreach ($users as $user) {
            $tweet = self::getLastTweet($user->name);
            if($tweet) {
                $feed[] = [
                    'user' => $user->name,
                    'tweet' => $tweet['text'],
                    'hashtag' => $tweet['entities']['hashtags']
                ];
            }
        }
        return ['feed' => $feed];
    }

}