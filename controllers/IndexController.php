<?php


namespace app\controllers;


use yii\web\Controller;

class IndexController extends Controller
{
    public function actionVue()
    {
        // set the specific layout for pages that will render vue
//        $this->layout = 'vue_main';
        $this->layout = 'main_vue';

        // override bundle configuration if needed
        \Yii::$app->assetManager->bundles = [];

        // render page
        return $this->render('vue_page');
    }
}