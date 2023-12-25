<?php

namespace Laravel\Breeze\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'surge:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all controllers, routes, components, pages and commands for the Surge starter kit.';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {        
        $this->installNodePackage();
        $this->installComposerPackages();
        $this->installConfig();
        $this->installFrontend();
        $this->installBackend();
        $this->installTests();

        return 1;
    }

    protected function installNodePackages()
    {
        // Dev dependencies
        $this->updateNodePackages(function ($packages) {
            return [
                '@inertiajs/vue3' => '^1.0.0',
                "@tailwindcss/forms" => "^0.5.3",
                '@tailwindcss/typography' => '^0.4.0',
                "@types/node" => "^18.11.18",
                "@vue/server-renderer" => "^3.2.45",
                "axios" => "^1.2.0",
                "npm-run-all" => "^4.1.5",
                "laravel-vite-plugin" => "^0.8.0",
                "@typescript-eslint/eslint-plugin" => "^5.48.1",
                "@typescript-eslint/parser" => "^5.40.0",
                "@vitejs/plugin-vue" => "^4.2.3",
                "autoprefixer" => "^10.4.13",
                "eslint" => "^8.25.0",
                "eslint-config-prettier" => "^8.5.0",
                "eslint-plugin-tailwindcss" => "^3.8.0",
                "eslint-plugin-unused-imports" => "^2.0.0",
                "eslint-plugin-vue" => "^9.9.0",
                "npm-run-all" => "^4.1.5",
                "postcss" => "^8.4.20",
                "prettier" => "^2.8.1",
                "prettier-plugin-tailwindcss" => "^0.2.1",
                "tailwindcss" => "^3.2.4",
                "typescript" => "^4.9.4",
                "unplugin-auto-import" => "^0.13.0",
                "unplugin-vue-components" => "^0.23.0",
                "vite" => "^4.3.9",
                "vite-plugin-eslint" => "^1.8.1",
                "vite-plugin-watch" => "^0.1.1",
                "vue" => "^3.3.4",
                "vue-tsc" => "^1.6.5"
            ] + $packages;
        }, true);

        // Other dependencies
        $this->updateNodePackages(function ($packages) {
            return [
                "@headlessui/vue" => "^1.7.16",
                "@heroicons/vue" => "^2.0.18",
                "@vueuse/core" => "^10.7.0",
                "momentum-modal" => "^0.2.1",
            ] + $packages;
        }, false);

        $this->replaceInFile(
            search: '"scripts": {', 
            replace: '
                "scripts": {
                    "dev": "vite",
                    "build-only": "vite build && vite build --ssr",
                    "build": "run-p format lint type-check && npm run build-only",
                    "build-all": "composer helpers && ./vendor/bin/pint && ./vendor/bin/phpstan analyse --memory-limit=512M && ./vendor/bin/pest && npm run build",
                    "type-check": "vue-tsc --noEmit",
                    "lint": "eslint \"resources/{scripts,views}/**/*.{js,ts,vue}\" --fix",
                    "format": "prettier \"resources/{scripts,views,css}/**/*.{js,ts,vue,css}\" --write",
                    "release": "npm run build-all && node ./release.js",
                    "patch": "npm version patch --no-git-tag-version && npm run release",
                    "minor": "npm version minor --no-git-tag-version && npm run release"
                },
            ', 
            path: base_path('package.json')
        );

        return 1;

        // copy(__DIR__.'/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
        // copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        // copy(__DIR__.'/../../stubs/resources/js/app.js', resource_path('js/app.js'));
        // copy(__DIR__.'/../../stubs/resources/js/Pages/Welcome.vue', resource_path('js/Pages/Welcome.vue'));
        // copy(__DIR__.'/../../stubs/resources/js/Layouts/AppLayout.vue', resource_path('js/Layouts/AppLayout.vue'));
        // copy(__DIR__.'/../../stubs/resources/js/Shared', resource_path('js/Shared'));
        // copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        // copy(__DIR__.'/../../stubs/resources/css/tailwind.css', resource_path('css/tailwind.css'));
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
        // Copy over the package.json files

        // Copy over typescript
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));
        // copy(__DIR__.'/../../stubs/tsconfig.json', base_path('tsconfig.json'));
        copy(__DIR__.'/../../stubs/resources/js/app.ts', resource_path('js/app.ts'));

        if (file_exists(resource_path('js/app.js'))) {
            unlink(resource_path('js/app.js'));
        }

        if (file_exists(resource_path('js/bootstrap.js'))) {
            rename(resource_path('js/bootstrap.js'), resource_path('js/bootstrap.ts'));
        }

        $this->replaceInFile('.js', '.ts', base_path('vite.config.js'));
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
            'migrate'
        );

        // Add billable trait to user model

        // Actions...
        (new Filesystem)->ensureDirectoryExists(app_path('Actions'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Actions', app_path('Actions'));

        // Casts...
        (new Filesystem)->ensureDirectoryExists(app_path('Casts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Casts', app_path('Casts'));

        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Http/Controllers', app_path('Http/Controllers'));

        // Data...
        (new Filesystem)->ensureDirectoryExists(app_path('Data'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Data', app_path('Data'));

        // Middleware...
        $this->installMiddlewareAfter('SubstituteBindings::class', '\App\Http\Middleware\HandleInertiaRequests::class');
        $this->installMiddlewareAfter('\App\Http\Middleware\HandleInertiaRequests::class', '\Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class');
        copy(__DIR__.'/../../stubs/app/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Http/Requests', app_path('Http/Requests'));

        // Routes...
        copy(__DIR__.'/../../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__.'/../../stubs/routes/auth.php', base_path('routes/auth.php'));

        // Services...
        (new Filesystem)->ensureDirectoryExists(app_path('Services'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Services', app_path('Services'));

        // Stubs
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

        $stubStack = 'default';

        if (!$this->requireComposerPackages([
            'pestphp/pest:^2.0', 
            'pestphp/pest-plugin-laravel:^2.0'
        ], true)) {
            return false;
        }

        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Feature', base_path('tests/Feature'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Unit', base_path('tests/Unit'));
        (new Filesystem)->copy(__DIR__.'/../../stubs/default/tests/Pest.php', base_path('tests/Pest.php'));
        

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
