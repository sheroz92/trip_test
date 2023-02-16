<?php

use yii\db\Migration;

/**
 * Class m230215_212053_import_cbt
 */
class m230215_212054_import_nemo_guide_etalon extends Migration
{

    /**
     * меняем базу данных для миграции
     */
    public function init()
    {
        $this->db = 'dbTwo';
        parent::init();
    }

    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $this->execute(file_get_contents(__DIR__.'/nemo_guide_etalon.sql'));
    }

    public function down()
    {

    }
}
