<?php

namespace Bank\Http\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

/**
 * This is just for the statement transfer, and maybe unused at the minute
 */
class ImporterController extends Controller
{
    /**
     * @return Application|ResponseFactory|Response
     */
    public function transferStatement(): Response|Application|ResponseFactory
    {
        try {
            $responseText = 'OK';

            $files = glob(base_path() .'/statement_downloads/*.csv', GLOB_BRACE);

            foreach ($files as $file) {
                $properFile = explode('/', $file);
                $filename = array_pop($properFile);
                $fileContents = file_get_contents($file);
                Storage::disk('ftp')->put($filename, $fileContents);
                chdir(base_path() . '/statement_downloads');
                unlink($filename);
            }
        } catch (Exception $e) {
            $responseText = $e->getMessage();
        }

        /**
         * @todo Come up with a proper handler
         */
        if ($responseText === 'OK') {
            return \response('OK', Response::HTTP_ACCEPTED)
                ->header('Content-Type', 'text/plain');
        } else {
            return \response($responseText, Response::HTTP_BAD_REQUEST)
                ->header('Content-Type', 'text/plain');
        }
    }
}
