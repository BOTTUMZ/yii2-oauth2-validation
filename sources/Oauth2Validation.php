<?php

namespace kolyunya\yii2\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;
use kolyunya\oauth2\validation\ClientFactory;

class Oauth2Validation extends ActionFilter
{

    public $userId;

    public $userToken;

    public $clientName;

    public $clientsData;

    public function beforeAction($action)
    {
        $clientFactory = new ClientFactory($this->clientName, $this->clientsData);
        $client = $clientFactory->make();
        $authenticated = $client->validate($this->userId, $this->userToken);
        if ($authenticated === true) {
            return true;
        } else {
            throw new UnauthorizedHttpException();
        }
    }
}
