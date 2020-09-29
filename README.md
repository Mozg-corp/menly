Создать файл db_local.php с данными для подключения к БД
В папке проекта:
	Docker-compose up
В docker машине menly_php_1
	Composer install
	php yii migrate 1
В gii
	Сгенерировать модель UserBase (т.е. ту что была на тот момент)
Запустить контроллер site/addadmin, который создаст первого пользователя, он нужен для следующей миграции в которой ему назначаться роль и права.

В docker машине menly_php_1
	php yii migrate --migrationPath=@yii/rbac/migrations
	
	Источник <https://yiiframework.com.ua/ru/doc/guide/2/security-authorization/> 
Накатить миграции
	php yii migrate
Сгенерировать модель UserBase (которая актуальна теперь)

(там я забыл ещё сделать миграции для создания пермишенов для разных действий, сделаю это чуть позже)

