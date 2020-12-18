клиент на vue.js там в папке webclient

Создать файл db_local.php с данными для подключения к БД
В console папке проекта:
	Docker-compose up
В docker машине menly_php_1
	Composer install
	php yii migrate 1
В gii
Сгенерировать модель UserBase (т.е. ту что была на тот момент), иначе будет ошибка - неизвестное свойство status.
Запустить контроллер site/addadmin, который создаст первого пользователя, он нужен для следующей миграции в которой ему назначаться роль и права.
Сгенерировать модель UserBase (которая актуальна теперь)

В docker машине menly_php_1
	php yii migrate --migrationPath=@yii/rbac/migrations
	
	Источник <https://yiiframework.com.ua/ru/doc/guide/2/security-authorization/> 
Накатить миграции
	php yii migrate
Для использования memcached нужно выполнить эти инструкции
https://github.com/yiisoft/yii2-docker/issues/85#issuecomment-576159527
