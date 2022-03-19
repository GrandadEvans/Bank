<?php

namespace Bank\UtilityClasses;

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;
use JetBrains\PhpStorm\Pure;

/**
 * This is a general utility class that imports data into InfluxDB.
 * Currently, it is only written in order to import transactions
 * There are no tests as yet for this facility (FOR SHAME!!!!)
 * If I put it in production I'll obviously tidy the code up
 * and obviously, write tests that'll cover the code base
 */
class InfluxDB
{

    /**
     * Auth token for InfluxFB
     *
     * @var string $token You can generate a Token from the "Tokens Tab" in the INFLUXDB UI
     */
    private string $token;

    /**
     * InfluxDB Org
     *
     * @var string $organisation Organisation under which is registered InfluxDB
     */
    public string $organisation;

    /**
     * InfluxDB Bucket
     *
     * @var string $bucket The Bucket in InfluxDB that you want to work on
     */
    public string $bucket;

    /**
     * InfluxDB URL
     *
     * @var string $dbUrl This is the URL of the InfluxDB you are working on
     */
    private string $dbUrl;


    /**
     * The obvious constructor
     */
    public function __construct()
    {
        $this->setSensitiveData();
    }

    /**
     * Assign the influxDB sensitive data from the environment
     */
    private function setSensitiveData()
    {
        $this->token        = env('INFLUXDB_TOKEN');
        $this->dbUrl        = env('INFLUXDB_URL');
        $this->organisation = env('INFLUXDB_ORG');
        $this->bucket       = env('INFLUXDB_BUCKET');
    }

    /**
     * I haven't looked at what this does (if it ain't broke...), but it made sense to stick it in its own method.
     *
     * @return string
     */
    public function writePrecision(): string
    {
        return WritePrecision::S;
    }

    /**
     * Establish a connection
     *
     * @return Client
     */
    #[Pure] public function getClient(): Client
    {
        return new Client([
            'token' => $this->token,
            'url'   => $this->dbUrl,
        ]);
    }

    /**
     * Write to the DB
     *
     * @param Point $pointer
     *
     * @return void
     */
    public static function write(Point $pointer)
    {
        $influx = new self();
        $writeApi =  $influx->getClient()->createWriteApi();

        $writeApi->write(
            data: $pointer,
            precision: $influx->writePrecision(),
            bucket: $influx->bucket,
            org: $influx->organisation
        );
    }
}
