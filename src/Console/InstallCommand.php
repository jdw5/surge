<?php

namespace Jdw5\Surge\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'surge:install
        {--composer=global : Absolute path to the Composer binary which should be used to install packages}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the starter kit';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {        
        $this->installNodePackages();
        $this->installComposerPackages();
        $this->installFrontend();
        $this->installBackend();
        $this->installTests();

        return 1;
    }

    protected function installNodePackages()
    {
        copy(__DIR__.'/../../stubs/package.json', base_path('package.json'));
    }

    protected function installComposerPackages()
    {
        if (!$this->requireComposerPackages([
            'inertiajs/inertia-laravel:^0.6.11', 
            'laravel/sanctum:^3.2', 
            'tightenco/ziggy:^1.0',
            'spatie/laravel-data:^2.2.3',
            'spatie/laravel-typescript-transformer:^2.1.7',
            'league/flysystem-aws-s3-v3:^3.0',
            'hashids/hashids:^5.0',
            'laravel/socialite:^5.10',
            'based/momentum-modal:^0.2.0',
            'laravel/cashier:^13.17',
            'laravel/fortify:^1.19',
        ])) {
            return 1;
        }

        if (!$this->requireComposerPackages([
            'barryvdh/laravel-debugbar:^3.9',
        ], true)) {
            return 1;
        }
    }    

    protected function installFrontend()
    {
        // Copy over config files for running frontend
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/../../stubs/.prettierrc', base_path('.prettierrc'));
        copy(__DIR__.'/../../stubs/.prettierignore', base_path('.prettierignore'));
        copy(__DIR__.'/../../stubs/.eslintrc.js', base_path('.eslintrc.js'));
        copy(__DIR__.'/../../stubs/.eslintignore', base_path('.eslintignore'));
        copy(__DIR__.'/../../stubs/settings.json', base_path('settings.json'));
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/vite.config.ts', base_path('vite.config.ts'));
        copy(__DIR__.'/../../stubs/tsconfig.json', base_path('tsconfig.json'));
        copy(__DIR__.'/../../stubs/resources/js/app.ts', resource_path('js/app.ts'));
        copy(__DIR__.'/../../stubs/resources/js/ssr.ts', resource_path('js/ssr.ts'));
        copy(__DIR__.'/../../stubs/resources/views/app.blade.php', resource_path('views/app.blade.php'));

        if (file_exists(base_path('vite.config.js'))) {
            unlink(base_path('vite.config.js'));
        }

        if (file_exists(resource_path('js/app.js'))) {
            unlink(resource_path('js/app.js'));
        }

        if (file_exists(resource_path('js/bootstrap.js'))) {
            rename(resource_path('js/bootstrap.js'), resource_path('js/bootstrap.ts'));
        }

        $this->replaceInFile('.js', '.ts', resource_path('views/app.blade.php'));
        
        // Create directories
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Components'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Lib'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Modals'));

        // Copy over
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Components', resource_path('js/Components'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Layouts', resource_path('js/Layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Pages', resource_path('js/Pages'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Lib', resource_path('js/Lib'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Modals', resource_path('js/Modals'));

    }

    protected function installBackend()
    {
        // Run the Cashier migrations
        $this->call(
            'vendor:publish', 
            [
                '--tag' => 'cashier-migrations',
            ]
        );

        // Run fortify
        $this->call(
            'vendor:publish', 
            [
                '--provider' => 'Laravel\Fortify\FortifyServiceProvider',
            ]
        );

        $this->call(
            'vendor:publish', 
            [
                '--provider' => 'Spatie\LaravelTypeScriptTransformer\TypeScriptTransformerServiceProvider'
            ]
        );

        // Ensure Fortify is registered in the app config
        $this->replaceInFile(
            'App\Providers\RouteServiceProvider::class,',
            'App\Providers\RouteServiceProvider::class,'.PHP_EOL.'        App\Providers\FortifyServiceProvider::class,',
            config_path('app.php')
        );

        // Change the location of the typescript transformer types
        (new Filesystem)->ensureDirectoryExists(resource_path('js/types'));
        $this->replaceInFile(
            "'output_file' => resource_path('types/generated.d.ts')",
            "'output_file' => resource_path('js/types/generated.d.ts')",
            config_path('typescript-transformer.php')
        );

        // Update authenticate middleware
        $this->replaceInFile(
            'login',
            'auth.login',
            app_path('Http/Kernel.php')
        );
        
        // Actions...
        (new Filesystem)->ensureDirectoryExists(app_path('Actions'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Actions', app_path('Actions'));

        // Casts...
        (new Filesystem)->ensureDirectoryExists(app_path('Casts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Casts', app_path('Casts'));

        // Config...
        copy(__DIR__.'/../../stubs/config/hashids.php', config_path('hashids.php'));
        copy(__DIR__.'/../../stubs/config/socialite.php', config_path('socialite.php'));

        // Commands...
        (new Filesystem)->ensureDirectoryExists(app_path('Console/Commands'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Console/Commands', app_path('Console/Commands'));

        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Http/Controllers', app_path('Http/Controllers'));

        // Data...
        (new Filesystem)->ensureDirectoryExists(app_path('Data'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Data', app_path('Data'));

        // Models...
        copy(__DIR__.'/../../stubs/app/Models/User.php', app_path('Models/User.php'));

        // Middleware...
        $this->installMiddlewareAfter('SubstituteBindings::class', '\App\Http\Middleware\HandleInertiaRequests::class');
        $this->installMiddlewareAfter('\App\Http\Middleware\HandleInertiaRequests::class', '\Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class');
        copy(__DIR__.'/../../stubs/app/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));

        // Fortify provider
        copy(__DIR__.'/../../stubs/app/Providers/FortifyServiceProvider.php', app_path('Providers/FortifyServiceProvider.php'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Http/Requests', app_path('Http/Requests'));

        // Responses...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Responses'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Http/Responses', app_path('Http/Responses'));

        // Routes...
        copy(__DIR__.'/../../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__.'/../../stubs/routes/auth.php', base_path('routes/auth.php'));

        // Services...
        (new Filesystem)->ensureDirectoryExists(app_path('Services'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Services', app_path('Services'));

        // Stubs...
        (new Filesystem)->ensureDirectoryExists(base_path('Stubs'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/stubs', base_path('stubs'));
    }

    /**
     * Install the test suite.
     *
     * @return bool
     */
    protected function installTests()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('tests/Feature'));
        (new Filesystem)->ensureDirectoryExists(base_path('tests/Unit'));

        if (!$this->requireComposerPackages([
            'pestphp/pest:^2.0', 
            'pestphp/pest-plugin-laravel:^2.0'
        ], true)) {
            return false;
        }

        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Feature', base_path('tests/Feature'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Unit', base_path('tests/Unit'));
        copy(__DIR__.'/../../stubs/tests/Pest.php', base_path('tests/Pest.php'));

        return true;
    }

    /**
     * Install the middleware to a group in the application Http Kernel.
     *
     * @param  string  $after
     * @param  string  $name
     * @param  string  $group
     * @return void
     */
    protected function installMiddlewareAfter($after, $name, $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (! Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $after.',',
                $after.','.PHP_EOL.'            '.$name.',',
                $middlewareGroup,
            );

            file_put_contents(app_path('Http/Kernel.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }

    /**
     * Determine if the given Composer package is installed.
     *
     * @param  string  $package
     * @return bool
     */
    protected function hasComposerPackage($package)
    {
        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        return array_key_exists($package, $packages['require'] ?? [])
            || array_key_exists($package, $packages['require-dev'] ?? []);
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  array  $packages
     * @param  bool  $asDev
     * @return bool
     */
    protected function requireComposerPackages(array $packages, $asDev = false)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Removes the given Composer Packages from the application.
     *
     * @param  array  $packages
     * @param  bool  $asDev
     * @return bool
     */
    protected function removeComposerPackages(array $packages, $asDev = false)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'remove'];
        }

        $command = array_merge(
            $command ?? ['composer', 'remove'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    protected static function flushNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Get the path to the appropriate PHP binary.
     *
     * @return string
     */
    protected function phpBinary()
    {
        return (new PhpExecutableFinder())->find(false) ?: 'php';
    }
}
