<?php

namespace Laravel\Breeze\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
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
        return 1;
    }

    protected function installFrontend()
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

        

        // AAdd the following to the scripts section of your package.json file:
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
        
        $this->replaceInFile(
            search: "'root' => storage_path('app/public'),",
            replace: "'root' => public_path('storage'),",
            path: config_path('filesystems.php'),
        );

        $this->replaceInFile(
            search: "'url' => env('APP_URL').'/storage',",
            replace: "'url' => env('APP_URL'),",
            path: config_path('filesystems.php'),
        );

        copy(__DIR__.'/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/../../stubs/resources/js/Pages/Welcome.vue', resource_path('js/Pages/Welcome.vue'));
        copy(__DIR__.'/../../stubs/resources/js/Layouts/AppLayout.vue', resource_path('js/Layouts/AppLayout.vue'));
        copy(__DIR__.'/../../stubs/resources/js/Shared', resource_path('js/Shared'));
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/resources/css/tailwind.css', resource_path('css/tailwind.css'));
    }

    /**
     * Install Breeze's tests.
     *
     * @return bool
     */
    protected function installTests()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('tests/Feature'));

        $stubStack = match ($this->argument('stack')) {
            'api' => 'api',
            'livewire' => 'livewire-common',
            'livewire-functional' => 'livewire-common',
            default => 'default',
        };

        if ($this->option('pest') || $this->isUsingPest()) {
            if ($this->hasComposerPackage('phpunit/phpunit')) {
                $this->removeComposerPackages(['phpunit/phpunit'], true);
            }

            if (!$this->requireComposerPackages(['pestphp/pest:^2.0', 'pestphp/pest-plugin-laravel:^2.0'], true)) {
                return false;
            }

            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Feature', base_path('tests/Feature'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Unit', base_path('tests/Unit'));
            (new Filesystem)->copy(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Pest.php', base_path('tests/Pest.php'));
        } else {
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/tests/Feature', base_path('tests/Feature'));
        }

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

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }

    /**
     * Interact further with the user if they were prompted for missing arguments.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        $stack = $input->getArgument('stack');

        if (in_array($stack, ['react', 'vue'])) {
            collect(multiselect(
                label: 'Would you like any optional features?',
                options: [
                    'dark' => 'Dark mode',
                    'ssr' => 'Inertia SSR',
                    'typescript' => 'TypeScript (experimental)',
                ]
            ))->each(fn ($option) => $input->setOption($option, true));
        } elseif (in_array($stack, ['blade', 'livewire', 'livewire-functional'])) {
            $input->setOption('dark', confirm(
                label: 'Would you like dark mode support?',
                default: false
            ));
        }

        $input->setOption('pest', select(
            label: 'Which testing framework do you prefer?',
            options: ['PHPUnit', 'Pest'],
            default: $this->isUsingPest() ? 'Pest' : 'PHPUnit',
        ) === 'Pest');
    }

    /**
     * Determine whether the project is already using Pest.
     *
     * @return bool
     */
    protected function isUsingPest()
    {
        return class_exists(\Pest\TestSuite::class);
    }
}
