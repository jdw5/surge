<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeEndpointCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:endpoint {name} {-m|--modal} {-p|--page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a single action controller and request pair';

    /**
     * Execute the console command.
     */

    protected function getInputName()
    {
        return $this->argument('name');
    }

    public function handle()
    {
        $this->call('make:controller', [
            'name' => $this->getInputName(),
            '--invokable' => true,
        ]);

        $rawPath = explode('/', $this->getInputName());
        $end = array_pop($rawPath);
        $path = implode('/', $rawPath);
        $requestName = $this->removeCamelCaseEnd($end) . 'Request';
        $request = $path . '/' . $requestName;

        $this->call('make:request', [
            'name' => $request,
        ]);

        $this->overwriteFile($rawPath, $requestName, app_path("Http/Controllers/{$this->getInputName()}.php"));
    }

    protected function removeCamelCaseEnd(string $name)
    {
        $start = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY);
        array_pop($start);
        return implode('', $start);
    }

    protected function overwriteFile(array $requestPath, string $request, string $controllerPath)
    {
        $importInertia = $this->useInertia($request);
        $namespace = implode('\\', $requestPath);
        $fullNamespace = "App\\Http\\Requests\\$namespace" . '\\' . $request;
        $file = file_get_contents($controllerPath);
        if ($importInertia) {
            $file = str_replace('use Illuminate\Http\Request;', "use $fullNamespace;\nuse Inertia\Inertia;", $file);
        } else {
            $file = str_replace('use Illuminate\Http\Request;', "use $fullNamespace;", $file);
        }
        $file = str_replace('public function __invoke(Request $request)', "public function __invoke($request \$request)", $file);
        file_put_contents($controllerPath, $file);
    }

    protected function useInertia(string $name)
    {
        $split = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY);
        return in_array('Index', $split) || in_array('View', $split) || in_array('Show', $split);
    }
}
