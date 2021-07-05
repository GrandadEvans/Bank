<?php

namespace Tests\Unit;

use Bank\UtilityClasses\CsvFileImporter;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Tests\TestCase;
use \InvalidArgumentException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CSVFileImporterTest
 * @package Tests\Unit
 */
class CSVFileImporterTest extends TestCase
{
    public $validExampleFile;

    
    /**
     * Run before each test
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->validExampleFile    = base_path() . '/tests/resources/valid.csv';
    }
}
