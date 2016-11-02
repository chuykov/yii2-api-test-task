<?php
namespace app\api\modules\v1\models;
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author';
    }

    public function getQuotes()
    {
        return $this->hasMany(Quote::className(), ['authorId' => 'authorId']);
    }

//        'SELECT * FROM author AS r1 JOIN
//               (SELECT (RAND() *
//                             (SELECT MAX(authorId)
//                                FROM author)) AS authorId)
//                AS r2
//         WHERE r1.authorId >= r2.authorId
//         ORDER BY r1.authorId ASC
//         LIMIT 1;';
    public static function getRandom() {
        return (new \yii\db\Query())->select(['r1.authorId', 'r1.name'])->from('author r1')
            ->join('JOIN', '('.(new \yii\db\Query())->select('authorId', "(RAND() * (" . (new \yii\db\Query())
                        ->select('MAX(authorId)')
                        ->from('author')
                        ->createCommand()->rawSql . "))")->createCommand()->rawSql.') as r2')
            ->where('r1.authorId>=r2.authorId')
            ->orderBy('r1.authorId ASC')
            ->limit(1);
    }
}