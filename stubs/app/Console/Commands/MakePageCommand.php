<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakePageCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:page {name} {--F|form} {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new page page using Momentum pages. Customise the stub as needed.';

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
        return $this->laravel->basePath($this->getLocation().'/'.str_replace('\\', '/', $name).'.vue');
    }

    protected function alreadyExists($name) 
    {
        return $this->files->exists($this->getPath($name));
    }

    protected function getInputName()
    {
        return $this->argument('name');
    }

    protected function getLocation()
    {
        return 'resources/js/Pages';
    }

    protected function getStub(bool $form = false)
    {
        if ($form) {
            return $this->resolveStubPath('/stubs/page.vue.form.stub');
        }
        return $this->resolveStubPath('/stubs/page.vue.stub');
    }


    public function handle()
    {
        if (!$this->option('force') && $this->alreadyExists($this->getInputName())) {
            $this->error('Page at this path already exists.');
            return false;
        }
        $path = $this->getPath($this->argument('name'));
        $this->makeDirectory($path);
        $this->files->put($path, $this->files->get($this->getStub($this->option('form'))));
        $this->info('Page created successfully.');
    }
}
