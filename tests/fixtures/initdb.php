<?php
$migrateController = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
$migrateController->runAction('up', ['interactive' => 0]);
