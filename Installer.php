<?php

Installer::install();

class Installer
{
    public static function install()
    {
        self::copy('vendor/kirin-cat/ci-project/src/DB/Doctrine.php', 'application/libraries/Doctrine.php');
        self::copy('vendor/kirin-cat/ci-project/src/DB/cli-config.php', 'cli-config.php');
    }

    private static function copy($src, $dst)
    {
        $success = copy($src, $dst);
        if ($success) {
            echo 'copied: ' . $dst . PHP_EOL;
        }
    }

    private static function recursiveCopy($src, $dst)
    {
        @mkdir($dst, 0755);

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                @mkdir($dst . '/' . $iterator->getSubPathName());
            } else {
                $success = copy($file, $dst . '/' . $iterator->getSubPathName());
                if ($success) {
                    echo 'copied: ' . $dst . '/' . $iterator->getSubPathName() . PHP_EOL;
                }
            }
        }
    }
}
