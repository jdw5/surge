<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeEnumCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:enum {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Enum class';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    protected function getPath($name)
    {
        return $this->laravel->basePath($this->getLocation().'/'.str_replace('\\', '/', $name).'.php');
    }

    protected function alreadyExists($name) 
    {
        return $this->files->exists($this->getPath($name));
    }

    protected function getInputName()
    {
        return $this->argument('name');
    }

    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected function getLocation()
    {
        return app_path('Enums');
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/enum.stub');
    }

    public function handle()
    {
        if (!$this->option('force') && $this->alreadyExists($this->getInputName())) {
            $this->error('Enum at this path already exists.');
            return false;
        }
        $path = $this->getPath($this->argument('name'));
        $this->makeDirectory($path);
        $this->files->put($path, $this->files->get($this->getStub()));
        $this->replaceInFile($path, '{{ name }}', $this->getInputName());

        $this->info('Enum created successfully.');
    }
}
