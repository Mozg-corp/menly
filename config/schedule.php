<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */
 // echo 'tast job';
 $schedule->command('balance/gett-report')->hourly();//->sendOutputTo('@app/log/application.log');;
 // $schedule->call(function(\yii\console\Application $app) {
    //Some code here...
	// echo 'ok';
// })->hourly();
// $schedule->exec('ls')->sendOutputTo('/app/output.txt')->everyOneMinutes();
// $schedule->command('balance/gett-report')->hourly();