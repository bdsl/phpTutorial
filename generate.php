<?php

declare(strict_types=1);

require_once (__DIR__ . '/vendor/autoload.php');

use League\Flysystem\Adapter\Local;

$adapter = new Local(__DIR__.'/');
$fileystem = new \League\Flysystem\Filesystem($adapter);

$fileystem->deleteDir('generated');
$fileystem->createDir('generated');

$twig = new \Twig\Environment(
    new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates'),
    []
);

$files = $fileystem->listContents('/content');
foreach ($files as $file)
{
    $markdown = $fileystem->read($file['path']);
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

$fileystem->copy('css/styles.css', 'generated/css/styles.css');