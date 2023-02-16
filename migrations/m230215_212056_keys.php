<?php

use yii\db\Migration;

/**
 * Class m230215_212056_keys
 */
class m230215_212056_keys extends Migration
{

    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $this->createIndex('flight_segment_depAirportId', 'flight_segment', 'depAirportId');
        //эти ключи есть изначально
        //$this->createIndex('trip_service_service_id', 'trip_service', 'service_id');
        //$this->createIndex('trip_corporate_id', 'trip', 'corporate_id');
    }

    public function down()
    {
        $this->dropIndex('flight_segment_depAirportId', 'flight_segment');
        //$this->dropIndex('trip_service_service_id', 'trip_service');
        //$this->dropIndex('trip_corporate_id', 'trip');
    }
}
