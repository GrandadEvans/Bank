<?php

namespace Bank\UtilityClasses;

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;

/**
 * This is a general utility class that imports data into InfluxDB.
 * Currently, it is only written in order to import transactions
 * There are no tests as yet for this facility (FOR SHAME!!!!)
 * If I put it in production I'll obviously tidy the code up
 * and obviously, write tests that'll cover the code base
 */
class InfluxDB {

    /**
     * Auth token for InfluxFB
     *
     * @var string $token You can generate a Token from the "Tokens Tab" in the INFLUXDB UI
     */
    private string $token;

    /**
     * InfluxDB Org
     *
     * @var string $org Organisation under which is registered InfluxDB
     */
    public string $org;

    /**
     * InfluxDB Bucket
     *
     * @var string $bucket The Bucket in InfluxDB that you want to work on
     */
    public string $bucket;

    /**
     * InfluxDB URL
     *
     * @var string$url This is the URL of the InfluxDB you are working on
     */
    private string $url;


    /**
     * The obvious constructor
     */
    public function __construct()
    {
        $this->assignSensitiveData();
    }

    /**
     * Assign the influxDB sensitive data from the environment
     */
    private function assignSensitiveData()
    {
        $this->token  = env('INFLUXDB_TOKEN');
        $this->url    = env('INFLUXDB_URL');
        $this->org    = env('INFLUXDB_ORG');
        $this->bucket = env('INFLUXDB_BUCKET');
    }

    /**
     * I haven't looked at what this does (if it ain't broke...), but it made sense to stick it in its own method.
     *
     * @return string
     */
    private function getPrecision(): string
    {
        return WritePrecision::S;
    }

    /**
     * Establish a connection
     *
     * @return Client
     */
    public function getClient()
    {
        return new Client([
            "url" => $this->url,
            "token" => $this->token,
        ]);
    }

    /**
     * Write to the DB
     *
     * @param Point $pointer
     *
     * @return void
     */
    public static function write(Point $pointer) {
        $influx = new self();
        $writerApi =  $influx->getClient()->createWriteApi();

        $writerApi->write($pointer, $influx->getPrecision(), $influx->bucket, $influx->org);
    }
}
