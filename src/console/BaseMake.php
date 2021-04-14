<?php

namespace SmartContact\UiMaker\console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BaseMake extends Command
{
    protected $basePath;
    protected $fileName;
    protected $resource;
    protected $template;
    protected $description = '';
    protected $signature = 'make:base {resource}';

    public function getPath()
    {
        return app_path("{$this->basePath}/{$this->fileName}");
    }

    public function fileAlreadyExists($path)
    {
        return File::exists($path);
    }

    public function makeFile($path)
    {
        File::makeDirectory(app_path($path), $mode = 0777, true, true);
    }

    public function filePutContests()
    {
        file_put_contents($this->getPath(), $this->template);
    }
    public function getStub($stubName)
    {
        return file_get_contents(__DIR__ . "/$stubName.stub");
    }

}
