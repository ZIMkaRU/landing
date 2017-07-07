<?php

namespace Deployer;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Inline;

require 'vendor/deployer/deployer/recipe/symfony.php';


host('185.127.24.181')
    ->user('root')
    ->port(22)
    ->identityFile('C:\Dropbox\ssh\id_rsa')
    ->forwardAgent(true)
    ->multiplexing(false)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->stage('prod')
    ->roles('app')
    ->set('deploy_path', '/home/land.ru/www')
    ->set('branch', 'master');

//set('ssh_type', 'native');


set('repository', 'https://ZIMkaRU@bitbucket.org/ZIMkaRU/landing.git');//https://ZIMkaRU@bitbucket.org/ZIMkaRU/landing.git   git@bitbucket.org:ZIMkaRU/landing.git
set('keep_releases', 5);


// Add web/uploads to shared_dirs
set('shared_dirs', array_merge(get('shared_dirs'), [
    'web/uploads',
]));

// Add web/uploads to writable_dirs
set('writable_dirs', array_merge(get('shared_dirs'), [
    'web/uploads',
]));


//task('deploy:build-parameters', function () {
//    // Reset the tmp dir
//    $dir = '.deploy';
//    $tmpDir = $dir.'/tmp';
//    exec('rm -Rf '.$tmpDir);
//    @mkdir($tmpDir, 0775);
//
//    if(is_file('app/config/parameters.yml.dist')) exec('cp -f app/config/parameters.yml.dist '.$tmpDir);
//    if(is_file($dir.'/parameters.yml')) exec('cp -f '.$dir.'/parameters.yml '.$tmpDir);
//
//    // Download the parameters files
//    try {
//        download($tmpDir.'/parameters.yml', '{{release_path}}/app/config/parameters.yml');
////        download($tmpDir.'/parameters.yml.dist', '{{release_path}}/app/config/parameters.yml.dist');
//    } catch (\RuntimeException $e) {
//        //Ignore exceptions
//    }
//
//    // At least parameters.yml.dist should be downloaded
//    if (!is_file($tmpDir.'/parameters.yml.dist')) {
//        throw new \InvalidArgumentException(sprintf('The dist file "app/config/parameters.yml.dist" does not exist.'));
//    }
//
//    $file = $tmpDir.'/parameters.yml';
//    $distFile = $tmpDir.'/parameters.yml.dist';
//    $exists = is_file($file);
//
//    $yamlParser = new Parser();
//
//    $action = $exists ? 'Updating' : 'Creating';
//    writeln(sprintf('<info>%s the "%s" file</info>', $action, 'app/config/parameters.yml'));
//
//    // Find the expected params
//    $expectedValues = $yamlParser->parse(file_get_contents($distFile));
//    if (!isset($expectedValues['parameters'])) {
//        throw new \InvalidArgumentException(sprintf('The top-level key %s is missing.', 'parameters'));
//    }
//    $expectedParams = (array) $expectedValues['parameters'];
//
//    // find the actual params
//    $actualValues = array_merge(
//    // Preserve other top-level keys than `$parameterKey` in the file
//        $expectedValues,
//        ['parameters' => []]
//    );
//
//    if ($exists) {
//        $existingValues = $yamlParser->parse(file_get_contents($file));
//        if ($existingValues === null) {
//            $existingValues = [];
//        }
//        if (!is_array($existingValues)) {
//            throw new \InvalidArgumentException(sprintf('The existing "%s" file does not contain an array', 'app/config/parameters.yml'));
//        }
//        $actualValues = array_merge($actualValues, $existingValues);
//    }
//
//    $actualParams = (array) $actualValues['parameters'];
//
//    // Ask to the user for the missing params
//    $isStarted = false;
//    foreach ($expectedParams as $key => $message) {
//        if (array_key_exists($key, $actualParams)) {
//            continue;
//        }
//
//        if (!$isStarted) {
//            $isStarted = true;
//            writeln('<comment>Some parameters are missing. Please provide them.</comment>');
//        }
//
//        $default = Inline::dump($message);
//        $value = ask(sprintf('%s:', $key), $default);
//
//        $actualParams[$key] = Inline::parse($value);
//    }
//
//    $actualValues['parameters'] = $actualParams;
//
//    // Save and upload the updated parameters.yml
//    file_put_contents($file, "# This file is auto-generated before the composer install\n" . Yaml::dump($actualValues, 99));
//    upload(__DIR__.'/'.$tmpDir.'/parameters.yml', '{{release_path}}/app/config');
//});
//
//before('deploy:vendors', 'deploy:build-parameters');

//task('parameters:load', function () {
//    upload('.deploy/parameters.{{env}}.yml', '{{release_path}}/app/config/parameters.yml');
//})->desc('Parameters load');

//task('deploy:vendors', function () {
//    run('cd {{release_path}} && {{env_vars}} {{bin/composer}} {{composer_options}}', ['tty' => true]);
//});

//after('deploy:vendors', 'database:migrate');

// Load fixtures
task('fixtures:load', function () {
    if (askConfirmation('Fixtures load?', false)) {
        run('php {{release_path}}/{{bin_dir}}/console doctrine:database:drop --force --env={{env}}');
        run('php {{release_path}}/{{bin_dir}}/console doctrine:database:create --env={{env}}');
//        run('{{env_vars}} {{bin/php}} {{bin/console}} doctrine:migrations:migrate {{console_options}} --allow-no-migration');
        run('php {{release_path}}/{{bin_dir}}/console doctrine:schema:create --env={{env}}');
        run('php {{release_path}}/{{bin_dir}}/console doctrine:fixtures:load --no-interaction --env={{env}}');
    }
})->desc('Fixtures load');

after('deploy:assetic:dump', 'fixtures:load');