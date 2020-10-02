<?
use yii\helpers\Url;
$url = Url::toRoute(['apiauth/registration/', 'phone' => 42,'password'=>'parolik','token'=>'123890','key'=>'666']);
echo $url;
?>