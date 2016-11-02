<?php

use yii\db\Migration;
use yii\db\Schema;
class m161101_145133_authors_quotes extends Migration
{
    public function up()
    {
        $this->createTable('author', [
            'authorId' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->createTable('quote', [
            'quoteId' => $this->primaryKey(),
            'authorId' => Schema::TYPE_INTEGER,
            'quote' => $this->text(),
        ]);

        $this->addForeignKey('fk_author_quote', 'quote', 'authorId', 'author', 'authorId', 'CASCADE', 'RESTRICT');

        Yii::$app->db->createCommand()->batchInsert('author', ['authorId', 'name'], [
            [1, 'Walt Disney'],
            [2, 'Mark Twain'],
            [3, 'Albert Einstein'],
        ])->execute();

        Yii::$app->db->createCommand()->batchInsert('quote', ['quoteId', 'authorId', 'quote'], [
            [ 1, 1,"The more you like yourself, the less you are like anyone else, which makes you unique."],
            [ 2, 1,"Disneyland is a work of love. We didn't go into Disneyland just with the idea of making money."],
            [ 3, 1,"I always like to look on the optimistic side of life, but I am realistic enough to know that life is a complex matter."],
            [ 4, 2,"The secret of getting ahead is getting started."],
            [ 5, 2,"Part of the secret of a success in life is to eat what you like and let the food fight it out inside."],
            [ 6, 2,"You can't depend on your eyes when your imagination is out of focus."],
            [ 7, 3,"Look deep into nature, and then you will understand everything better."],
            [ 8, 3,"Learn from yesterday, live for today, hope for tomorrow. The important thing is not to stop questioning."],
            [ 9, 3,"The only source of knowledge is experience."]
        ])->execute();
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
