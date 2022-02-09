<?php

namespace Bank\UtilityClasses;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class CsvFileParser
 * @package Bank\UtilityClasses
 *
 * What functionality to I want to expose?
 *
 * methods:
 * - get validated data
 * - __destruct to make sure file pointer is closed
 *
 *
 * properties:
 * - enforce column length
 * - line separator
 * - column separator
 * - validate data before return
 */
class CsvFileParser extends FileHandler
{
    /**
     * Is the first row of the data a list of header columns?
     *
     * @var bool
     */
    public $firstRowAreHeaders = true;

    /**
     * A sensible maximum line length is 100, but to disable this limit by default I shall select 0
     * @var int
     */
    private $maximumRowLength = 0;

    /**
     * Should we return the headers in the data array?
     *
     * @var bool
     */
    public $returnHeadersInData = false;

    /**
     * Sometimes there will be a need for a flexible row
     *
     * This will happen when a column has a comma/delimiter in the field value itself but is unescaped
     *
     * @var string  $flexibleRow
     */
    public $flexibleRow = '';

    /**
     * The array of headers (if they are included
     * @var
     */
    protected $arrayOfHeaders;

    /**
     * We want to give the user the option to have an associative array returned by default
     *
     * This will be the default, but for a csv file with possibly tens of thousands of entries
     * this can add a lot to the response size/time
     *
     * @var bool
     */
    public $returnAssociativeArray = true;


    /**
     * CsvFileParser constructor.
     * @param $file
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
        $this->confirmFileExists($file);
        
        parent::__construct();
    }

    /**
     * Return the number of rows in a given csv file
     *
     * @throws FileException
     *
     * @return int
     */
    public function countRowsOfData(): int
    {
        $this->openFileHandle();

        $rowsWithData = 0;

        while ($data = $this->moreLinesOfCsvNeedProcessing()) {
            $columns = count($data);

            // If there are more than 0 columns then add iterate the usable row count
            if ($columns !== [null]) {
                $rowsWithData++;
            }
            // Go to the next row
        }

        $this->closeFileHandle();

        return (int) $rowsWithData;
    }

    /**
     * Shortcut to see if there are more lines of csv that need parsing
     *
     * This is done for readability
     *
     * @return array|false|null
     */
    private function moreLinesOfCsvNeedProcessing()
    {
        return fgetcsv($this->fileHandle, $this->maximumRowLength, ",");
    }

    /**
     * Return an array of headers
     *
     * Let's assume that the headers are included as default for the time being
     *
     * @throws FileException
     *
     * @return array
     */
    public function getArrayOfHeaders(): array
    {
        $this->openFileHandle();
        while ($data = $this->moreLinesOfCsvNeedProcessing()) {
            // We can use $this->array_trim to filter out empty lines
            // which are returned as a single null value inside an array
            $data = $this->array_trim($data);

            $this->closeFileHandle();

            $this->arrayOfHeaders = $data;
            return (array) $data;
        }
        // If we reach this point then no line in the file has any headers ( or indeed any data)
        return (array) [];
    }

    /**
     * Return an array of data from the file
     *
     * @return array
     */
    public function getData(): array
    {
        $headersArray = $this->getArrayOfHeaders();
        $this->openFileHandle();
        $arrayToReturn = [];

        while ($data = $this->moreLinesOfCsvNeedProcessing()) {
            $data = $this->array_trim($data);

            if ($this->returnAssociativeArray) {
                $actionedData = array_combine($headersArray, $data);
            } else {
                $actionedData = $data;
            }

            if ($data) {
                array_push($arrayToReturn, $actionedData);
            }
        }
        $this->closeFileHandle();
        if ((bool) $this->returnHeadersInData === false && (bool) $this->firstRowAreHeaders === true) {
            array_shift($arrayToReturn);
        }

        // The array is now in a reversed state so we need to put it back in the correct order (#BA-51)
        $arrayToReturn = array_reverse($arrayToReturn);
        return (array) $arrayToReturn;
    }

    /**
     * Trim empty elements from the front/back of the array
     *
     * This is a method I found on the PHP manual site. It only trims
     * empty elements from the front and the back of the array and not throughout
     * the entire array
     *
     * @param array $array
     *
     * @return array
     */
    private function array_trim(array $array): array
    {
        while (strlen(reset($array)) === 0) {
            array_shift($array);
        }
        while (strlen(end($array)) === 0) {
            array_pop($array);
        }
        return (array) $array;
    }

    /**
     * Convert the various date formats into a standard format
     *
     * @param  string  $dateIn
     * @return string
     */
    public static function convertDate(string $dateIn): string
    {
        switch ($dateIn) {
            case (preg_match('/^(\d{2})[\/-](\d{2})[\/-](\d{4})$/', $dateIn, $matches) ? true : false):
                $dateOut = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
                break;
            case (preg_match('/^(\d{4})[\/-](\d{2})[\/-](\d{2})$/', $dateIn, $matches) ? true : false):
                $dateOut = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
                break;
            default:
                $dateOut = $dateIn;
        }
        return $dateOut;
    }

    /**
     * Get the providers for imported transactions
     *
     * @param array $transaction
     * @param $providers
     *
     * @return array
     */
    public static function getTransactionsProviders(String $entry, $providers) {
        // for each of the transactions, we need to get the regex and then test gainst each of the providers regex
        $results = [];
        $providerInResults = false;

        if(!$providers instanceof Collection) {
            $providers = collect([$providers])->groupBy('name');
        }

        // for each provider to be tested
        $providers->each(function($provider, $key) use ($entry, &$results, $providerInResults) {
            $providerInResults = false;

            $provider_id = $provider->id;
            $provider_regex = trim($provider->regular_expressions);
            $provider_name = $provider->name;
            $provider_logo = $provider->logo;
            $provider_remarks = $provider->remarks;

            // Grab each regular expression we should test against
            $expressions = explode("\n", $provider_regex);

            foreach($expressions as $expression) {
                if (!$providerInResults) {

                    $expression = trim($expression);
                    if(strpos($expression, '/') !== 0) {

                        // see if there is an exact match

                        // I am only going to test one side... for now
                        $expression = "/".$expression."/i";
                    }

                    // Make sure we have a valid regular expression
                    if (filter_var($entry, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $expression]])) {
                        // If the expression is not surrounded in slashes, then add them automatically
                        array_push($results, [
                            'transaction_id' => null,
                            'id' => $provider_id,
                            'regular_expressions' => $provider_regex,
                            'remarks' => $provider_remarks,
                            'logo' => $provider_logo,
                            'name' => $provider_name
                        ]);
                        $providerInResults = true;
                    }
                }
            }
        });
        // var_dump($results);
        return $results;

    }



    // /**
    //  * Convert the various date formats into a standard format
    //  *
    //  * @param  string  $dateIn
    //  * @return string
    //  */
    // public static function convertDate(string $dateIn): string
    // {
    //     switch ($dateIn) {
    //         case (preg_match('/^(\d{2})[\/-](\d{2})[\/-](\d{4})$/', $dateIn, $matches) ? true : false):
    //             $dateOut = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
    //             break;
    //         case (preg_match('/^(\d{4})[\/-](\d{2})[\/-](\d{2})$/', $dateIn, $matches) ? true : false):
    //             $dateOut = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
    //             break;
    //         default:
    //             $dateOut = $dateIn;
    //     }
    //     return $dateOut;
    // }

    /**
     *    These are for the flexible row functionality, which I'm not sure is needed
    public function setFlexibleField(String $filterToApply, bool $regularExpression = false)
    {
    $headers = $this->getHeaderArray();

    if ($regularExpression) {
    // Search through the header titles to see if there is a match
    $filteredHeaders = preg_grep($filterToApply, $headers);

    // Hopefully we have a match
    if (count($filteredHeaders) === 1) {
    // Go to the start (although there should only be one entry)
    // Now get the key that matches
    $key = key($filteredHeaders);

    // Now we can set the filtered header to be set
    $this->flexibleRow = $key;
    return true;
    } elseif (count($filteredHeaders) > 1) {
    throw new InvalidArgumentException(
    "There was an error filtering the header columns. " .
    "Only one column is allowed but there was more than one match.");
    } else {
    // count is 0 - there are no matches
    throw new InvalidArgumentException(
    "There was an error filtering the header list. " .
    "There were no matches for the provided expression. Here are the available headers:\n");
    }
    } elseif (in_array($filterToApply, $headers)) {
    $this->flexibleRow = $filterToApply;
    return true;
    } else {
    throw new InvalidArgumentException(
    "There was an error setting the flexible row, as there were no matching fields. " .
    "Here are the choices you have. ");
    }
    }

    private function fixIncorrectDelimiter(array $data)
    {
    $flexibleColumnIndex = null;
    $dataToReturn = [];

    if (!$this->flexibleRow) {
    throw new InvalidArgumentException("There are extra fields, but no flexible row is set");
    }

    // Get a list of the headers
    $headers = $this->getHeaderArray();

    // For every header that isn't flexible, take it off as well as the corresponding
    // column in the data array
    $index = 0;
    foreach($headers as $colName) {
    if ($colName !== $this->flexibleRow) {
    $dataToReturn[$index] = $data[0];
    array_shift($data);
    array_shift($headers);
    $index++;
    } else {
    $dataToReturn[$index] = 'NULL';
    $flexibleColumnIndex = $index;
    $index++;
    break;
    }
    }

    // Now we have made the first column the flexible one, reverse the arrays...
    $data = array_reverse($data);
    $headers = array_reverse($headers);

    // ... and do the same again
    $dataToReverseThenReturn = [];
    foreach($headers as $colName) {
    if ($colName !== $this->flexibleRow) {
    array_push($dataToReverseThenReturn, $data[0]);
    array_shift($data);
    array_shift($headers);
    $index++;
    } else {
    break;
    }
    }

    // Now that we have the elements to join, we need to reverse them again
    $data = array_reverse($data);
    $dataToReverseThenReturn = array_reverse($dataToReverseThenReturn);

    // Now every column of data should be from the same column in the original data but had delimiters in them
    $join = join(",", $data);
    $dataToReturn[$flexibleColumnIndex] = $join;
    $data = array_merge($dataToReturn, $dataToReverseThenReturn);

    return $data;
    }
     */
}
