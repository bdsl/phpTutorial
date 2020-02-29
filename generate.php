#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use League\Flysystem\Adapter\Local;

$adapter = new Local(__DIR__.'/');
$fileystem = new \League\Flysystem\Filesystem($adapter);

$fileystem->deleteDir('generated');
$fileystem->createDir('generated');
$fileystem->write('generated/.nojekyll', ''); // stops Github running Jekyll site generator

$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates'));

/** @var list<array{path: string, basename: string}> $files */
$files = $fileystem->listContents('/content');

foreach ($files as $file)
{
    $markdown = $fileystem->read($file['path']);

    /** @var string $htmlContent */
    $htmlContent = (new Parsedown())->text($markdown);
    $fileystem->write(
        'generated/' . str_replace('.md', '.html', $file['basename']),
        $twig->load('layout.html.twig')->render(
            [
                'pages' => $files,
                'body' => $htmlContent,
            ])
    );
}

$fileystem->copy('generated/01-introduction.html', 'generated/index.html');

$fileystem->copy('css/styles.css', 'generated/css/styles.css');