<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'Backer');

// Project repository
set('repository', 'git@github.com:budhilaw/backer-web.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', ['.env']);
add('shared_dirs', ['storage']);

// Writable dirs by web server
set('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

set('log_files', 'storage/logs/*.log');
set('laravel_version', function () {
    $result = run('{{bin/php}} {{release_or_current_path}}/artisan --version');
    preg_match_all('/(\d+\.?)+/', $result, $matches);
    return $matches[0][0] ?? 5.5;
});

/**
 * Run an artisan command.
 *
 * Supported options:
 * - 'min' => #.#: The minimum Laravel version required (included).
 * - 'max' => #.#: The maximum Laravel version required (included).
 * - 'skipIfNoEnv': Skip and warn the user if `.env` file is inexistant or empty.
 * - 'failIfNoEnv': Fail the command if `.env` file is inexistant or empty.
 * - 'showOutput': Show the output of the command if given.
 *
 * @param string $command The artisan command (with cli options if any).
 * @param array $options The options that define the behaviour of the command.
 * @return callable A function that can be used as a task.
 */
function artisan($command, $options = [])
{
    return function () use ($command, $options) {

        // Ensure the artisan command is available on the current version.
        $versionTooEarly = array_key_exists('min', $options)
            && laravel_version_compare($options['min'], '<');

        $versionTooLate = array_key_exists('max', $options)
            && laravel_version_compare($options['max'], '>');

        if ($versionTooEarly || $versionTooLate) {
            return;
        }

        // Ensure we warn or fail when a command relies on the ".env" file.
        if (in_array('failIfNoEnv', $options) && !test('[ -s {{release_or_current_path}}/.env ]')) {
            throw new \Exception('Your .env file is empty! Cannot proceed.');
        }

        if (in_array('skipIfNoEnv', $options) && !test('[ -s {{release_or_current_path}}/.env ]')) {
            warning("Your .env file is empty! Skipping...</>");
            return;
        }

        $artisan = '{{release_or_current_path}}/artisan';

        // Run the artisan command.
        $output = run("{{bin/php}} $artisan $command");

        // Output the results when appropriate.
        if (in_array('showOutput', $options)) {
            writeln("<info>$output</info>");
        }
    };
}

function laravel_version_compare($version, $comparator)
{
    return version_compare(get('laravel_version'), $version, $comparator);
}

/*
 * Maintenance mode.
 */

desc('Puts the application into maintenance / demo mode');
task('artisan:down', artisan('down', ['showOutput']));

desc('Brings the application out of maintenance mode');
task('artisan:up', artisan('up', ['showOutput']));

/*
 * Generate keys.
 */

desc('Sets the application key');
task('artisan:key:generate', artisan('key:generate'));

desc('Creates the encryption keys for API authentication');
task('artisan:passport:keys', artisan('passport:keys'));

/*
 * Database and migrations.
 */

desc('Seeds the database with records');
task('artisan:db:seed', artisan('db:seed --force', ['showOutput']));

desc('Runs the database migrations');
task('artisan:migrate', artisan('migrate --force', ['skipIfNoEnv']));

desc('Drops all tables and re-run all migrations');
task('artisan:migrate:fresh', artisan('migrate:fresh --force'));

desc('Rollbacks the last database migration');
task('artisan:migrate:rollback', artisan('migrate:rollback --force', ['showOutput']));

desc('Shows the status of each migration');
task('artisan:migrate:status', artisan('migrate:status', ['showOutput']));

/*
 * Cache and optimizations.
 */

desc('Flushes the application cache');
task('artisan:cache:clear', artisan('cache:clear'));

desc('Creates a cache file for faster configuration loading');
task('artisan:config:cache', artisan('config:cache'));

desc('Removes the configuration cache file');
task('artisan:config:clear', artisan('config:clear'));

desc('Discovers and cache the application\'s events and listeners');
task('artisan:event:cache', artisan('event:cache', ['min' => '5.8.9']));

desc('Clears all cached events and listeners');
task('artisan:event:clear', artisan('event:clear', ['min' => '5.8.9']));

desc('Lists the application\'s events and listeners');
task('artisan:event:list', artisan('event:list', ['showOutput', 'min' => '5.8.9']));

desc('Cache the framework bootstrap files');
task('artisan:optimize', artisan('optimize'));

desc('Removes the cached bootstrap files');
task('artisan:optimize:clear', artisan('optimize:clear'));

desc('Creates a route cache file for faster route registration');
task('artisan:route:cache', artisan('route:cache'));

desc('Removes the route cache file');
task('artisan:route:clear', artisan('route:clear'));

desc('Lists all registered routes');
task('artisan:route:list', artisan('route:list', ['showOutput']));

desc('Creates the symbolic links configured for the application');
task('artisan:storage:link', artisan('storage:link', ['min' => 5.3]));

desc('Compiles all of the application\'s Blade templates');
task('artisan:view:cache', artisan('view:cache', ['min' => 5.6]));

desc('Clears all compiled view files');
task('artisan:view:clear', artisan('view:clear'));

// Hosts

host('157.230.40.38')
    ->set('hostname', '157.230.40.38')
    ->set('remote_user', 'kai')
    ->set('deploy_path', '~/{{application}}');

/**
 * Main deploy task.
 */
desc('Deploys your project');
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:view:cache',
    'artisan:migrate',
]);

