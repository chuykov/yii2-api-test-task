Yii 2 Api Test Project
============================

Start test server:
-------------------
    php yii migrate
    php yii serve 0.0.0.0:8080 --docroot=api     

Functional testing:
-------------------
    php tests/bin/yii serve 0.0.0.0:8000 --docroot=api --appconfig=config/test_console.php     
    composer exec codecept run
    
Required databases:
-------------------
    api
    api_test

Sample apache config:
-------------------
    <VirtualHost *:80>
        DocumentRoot /var/www/yii-api/api
        ServerName api.dev
    </VirtualHost>

Postman collection - [api.postman_collection.json](https://raw.githubusercontent.com/chuykov/yii2-api-test-task/master/api.postman_collection.json)

![alt tag](scheme.png?raw=true "db")