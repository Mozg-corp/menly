клиент на vue.js в папке webclient

Создать файл db_local.php с данными для подключения к БД


В console папке проекта:


	```Docker-compose up```
	
	
В docker машине menly_php_1


	```Composer install
	php yii migrate 1```
	
	
В localhost/gii

Сгенерировать модель UserBase (поставить галочку Singalarize)(т.е. ту что была на тот момент), иначе будет ошибка - неизвестное свойство status.

Запустить контроллер site/add-admin, который создаст первого пользователя, он нужен для следующей миграции в которой ему назначаться роль и права администратора.



В docker машине menly_php_1

	```php yii migrate --migrationPath=@yii/rbac/migrations```
	
	Источник <https://yiiframework.com.ua/ru/doc/guide/2/security-authorization/> 
	
	
Накатить миграции
	```php yii migrate 42```
	
Снова сгенерировать модель UserBase поставив галочку Singulirize (которая актуальна теперь).
И сгенерировать новый AregatorBase поставив галочку Singulirize.

Накатить оставшиеся миграции


Для использования memcached нужно выполнить эти инструкции

https://github.com/yiisoft/yii2-docker/issues/85#issuecomment-576159527

(только команду нужно записать в строчку!)
