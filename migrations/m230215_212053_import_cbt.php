<?php

use yii\db\Migration;

/**
 * Class m230215_212053_import_cbt
 */
class m230215_212053_import_cbt extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $this->execute(file_get_contents(__DIR__.'/cbt.sql'));
    }

    public function down()
    {

    }
}
