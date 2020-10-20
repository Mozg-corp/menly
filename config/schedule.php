<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */
 // echo 'tast job';
 $schedule->command('balance/gett-report')->everyThirtyMinutes();
 // $schedule->call(function(\yii\console\Application $app) {
    //Some code here...
	// echo 'ok';
// })->hourly();
// $schedule->exec('ls')->sendOutputTo('/app/output.txt')->everyOneMinutes();
// $schedule->command('balance/gett-report')->hourly();