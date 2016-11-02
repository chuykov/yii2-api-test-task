<?php
namespace app\api\modules\v1\models;
class Quote extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quote';
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['authorId' => 'authorId']);
    }

//        'SELECT * FROM quote AS r1 JOIN
//               (SELECT (RAND() *
//                             (SELECT MAX(quoteId)
//                                FROM quote)) AS quoteId)
//                AS r2
//         WHERE r1.quoteId >= r2.quoteId
//         ORDER BY r1.quoteId ASC
//         LIMIT 1;';
    public static function getRandom() {
        return (new \yii\db\Query())->select(['r1.quoteId', 'r1.authorId', 'r1.quote'])->from('quote r1')
            ->join('JOIN', '('.(new \yii\db\Query())->select('quoteId', "(RAND() * (" . (new \yii\db\Query())
                        ->select('MAX(quoteId)')
                        ->from('quote')
                        ->createCommand()->rawSql . "))")->createCommand()->rawSql.') as r2')
            ->where('r1.quoteId>=r2.quoteId')
            ->orderBy('r1.quoteId ASC')
            ->limit(1);
    }
}