<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\httpclient\Client;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RestController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $client = new Client(['baseUrl'=>'https://fleet-api.taxi.yandex.net']);
		$request = $client->createRequest()
							->setMethod('post')
							->addHeaders(['content-type' => 'application/json'])
							->addHeaders(['X-API-Key' => 'ZmrOTXOvioph+fEQLPyNRiMEDKQXXz+adlcIpo'])
							->addHeaders(['X-Client-ID' => 'taxi/park/8e974b78dc284add96cf02515098d1e2'])
							->setUrl('v1/parks/driver-profiles/list')
							->setFormat(Client::FORMAT_JSON)
							->setContent(
								'{"fields": {"driver_profile": []}, "limit": 10, "query": {"park": {"car": {  }, "id": "8e974b78dc284add96cf02515098d1e2"}}}'
							)
							->send();
       return $request;
    }
}
