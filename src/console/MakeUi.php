<?php

namespace SmartContact\UiMaker\console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeUi extends BaseMake
{
    protected $signature = 'make:ui {resource}';
    protected $description = 'Create Ui Modules Resource';

    public function __construct()
    {
        $this->basePath = "Modules/Ui";
        parent::__construct();

    }

    public function handle()
    {
        $this->resource = ucfirst($this->argument('resource'));
        $this->fileName = "Ui$this->resource.php";

        if(! $this->fileAlreadyExists("Modules")) {
            $this->makeFile("Modules");
        }

        if(! $this->fileAlreadyExists($this->basePath)) {
            $this->makeFile($this->basePath);
        }

        if($this->fileAlreadyExists("$this->basePath/$this->fileName")) {
            $this->warn("Resource $this->resource alredy exists!");
            return;
        }
        $this->setTemplate();
        $this->filePutContests();
        $this->info("Resource Create");
    }

    public function setTemplate()
    {
        $this->template = str_replace(
            ['{{ class }}', '{{ resource }}'],
            ["Ui$this->resource", Str::lower(Str::plural($this->resource))],
            $this->getStub("ui")
        );
    }
}
