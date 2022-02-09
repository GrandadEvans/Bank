<?php


namespace Bank\UtilityClasses;


use Exception;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileHandler
{

    /**
     * @var String $file
     */
    public $file;

    /**
     * File handle returned by the fopen method
     *
     * @var bool|resource
     */
    protected $fileHandle;

    public function __construct()
    {

    }

    /**
     * Check the file exists
     *
     * This is performed automatically, when the class is instantiated
     *
     * @return bool
     */
    protected function confirmFileExists(): bool
    {
        $fs = new Filesystem();

        if ($fs->exists($this->file) && $fs->isReadable($this->file)) {
            return true;
        } else {
            throw new FileException();
        }
    }

    /**
     * Open a file handle using fopen and store the resource in a private property
     *
     * @throws FileException
     *
     * @returns void
     */
    protected function openFileHandle(): void
    {
        try {
            $this->fileHandle = fopen($this->file, "r");
        } catch (Exception $e) {
            throw new FileException('Either the passed file does not exist or it can\'t be read');
        }
    }

    /**
     * Close the classes file handle
     *
     * @returns void
     */
    protected function closeFileHandle(): void
    {
        fclose($this->fileHandle);
    }

}
