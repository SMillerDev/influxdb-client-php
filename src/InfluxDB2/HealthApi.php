<?php

namespace InfluxDB2;

use Exception;
use InfluxDB2\Model\HealthCheck;

class HealthApi
{
    private $api;

    /**
     * HealthApi constructor.
     * @param DefaultApi $api
     */
    public function __construct(DefaultApi $api)
    {
        $this->api = $api;
    }

    /**
     * Get the health of an instance.
     *
     * @return HealthCheck
     */
    public function health(): HealthCheck
    {
        try {
            $response = $this->api->get(NULL, "/health", []);
            return ObjectSerializer::deserialize($response->getBody()->getContents(), '\InfluxDB2\Model\HealthCheck');
        } catch (Exception $e) {
            return new HealthCheck([
                "name" => "influxdb",
                "message" => $e->getMessage(),
                "status" => "fail",
            ]);
        }
    }
}
