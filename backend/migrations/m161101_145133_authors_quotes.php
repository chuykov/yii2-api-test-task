<?php

use yii\db\Migration;

class m161101_145133_authors_quotes extends Migration
{
    public function up()
    {
        $this->createTable('authors_quotes', [
            'authorId' => $this->primaryKey(),
            'authorName' => $this->string(),
            'quote' => $this->text(),
        ]);
        $quotes = json_decode(file_get_contents('quotes.json'));
        foreach ($quotes as $quote) {
            $this->insert('authors_quotes', [
                'authorName' => $quote[1],
                'quote' => $quote[0]
            ]);
        }
    }

    public function down()
    {

        echo "m161101_145133_authors_quotes cannot be reverted.\n";
        $this->dropTable('authors');
        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
