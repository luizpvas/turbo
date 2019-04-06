<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Deployment;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class DeploymentsController extends Controller
{
    /**
     * POST /deployments
     * Creates a new deployment for the website.
     *
     * @return Illuminate\Http\Response
     */
    function store()
    {
        request()->validate([
            'key' => 'required',
            'file' => 'required|file'
        ]);

        $website = Website::findOrFailByKey(request('key'));

        $zipDir = $this->extractUploadedZipFile();

        // We need to check if the extracted zip had a directory or
        // the files directly. If the extracted zip had exactly one
        // directory, we'll read the templates from this dir.
        $files = scandir($zipDir);
        if (count($files) == 3 && is_dir($zipDir. '/' . $files[2])) {
            $templatesDir = $zipDir . '/' . $files[2];
        } else {
            $templatesDir = $zipDir;
        }

        try {
            $deployment = $website->publishTemplatesFromDirectory($templatesDir);
        } finally {
            (new Filesystem)->deleteDirectory($zipDir);
        }

        if (isset($deployment)) {
            return $deployment;
        } else {
            return ['status' => 'failed'];
        }
    }

    /**
     * Extracts the zip file in a directory.
     *
     * @return void
     */
    protected function extractUploadedZipFile()
    {
        $zip = new \ZipArchive();
        $res = $zip->open(request('file')->getPathName());
        if ($res) {
            $path = storage_path('templates/' . Str::random(15));
            mkdir($path);
            $zip->extractTo($path);
            $zip->close();
            return $path;
        } else {
            throw new \Exception('unable to extract uploaded file');
        }
    }
}
