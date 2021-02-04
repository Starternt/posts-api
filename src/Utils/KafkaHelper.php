<?php

namespace App\Utils;

use Kafka\Consumer;
use Kafka\ConsumerConfig;

trait KafkaHelper
{
    /**
     * @param string $host
     * @param string $port
     *
     * @return Consumer
     */
    public function configureConsumer(string $host, string $port): Consumer
    {
        $config = ConsumerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList($host.':'.$port);
        $config->setGroupId('votes');
        $config->setBrokerVersion('1.0.0');
        $config->setTopics(['votes']);
        $config->setOffsetReset('earliest');

        return new Consumer();
    }
}