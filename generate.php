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

$layoutTwig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates'));
$contentTwig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/content'));

/** @var list<array{path: string, basename: string}> $files */
$files = $fileystem->listContents('/content');

$processedFiles = [];
$pagcounter = 0;
foreach ($files as $file)
{
    $pagcounter++;
    $markdown = $contentTwig->load($file['basename'])->renderBlock('body');

    $processedFile = $file;
    /** @var string $htmlContent */
    $htmlContent = (new Parsedown())->text($markdown);
    $processedFile['htmlContent'] = $htmlContent;
    $processedFile['title'] = $contentTwig->load($file['basename'])->renderBlock('title');
    $processedFile['pageNumber'] = $pagcounter;

    $processedFiles[] = $processedFile;
}

foreach ($processedFiles as $index => $file)
{
    $fileystem->write(
        'generated/' . str_replace('.md', '.html', $file['basename']),
        $layoutTwig->render('layout.html.twig',
            [
                'pages' => $processedFiles,
                'body' => $file['htmlContent'],
                'pageNumber' => $file['pageNumber'],
                'title' => $file['title'],
                'previousPage' => $processedFiles[$index-1] ?? null,
                'nextPage' => $processedFiles[$index+1] ?? null,
            ])
    );
}

$fileystem->write('generated/CNAME', "a-moderately-short-php-tutorial.com\n");

$fileystem->copy('generated/01-introduction.html', 'generated/index.html');

$fileystem->copy('css/styles.css', 'generated/css/styles.css');