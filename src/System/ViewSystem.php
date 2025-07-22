<?php

namespace Sandersao\FileTransfer\System;

use Sandersao\FileTransfer\IO\Exception\InternalException;

class ViewSystem {
    /**
     * @param string $template
     * @param array<string, string> $varList
     */
    public function import($template, array $varList = []): void {
        $parentPath = realpath(__DIR__. DIRECTORY_SEPARATOR . '..');
        $endDir = str_replace(['.'], [DIRECTORY_SEPARATOR], "$parentPath.View.$template");
        $endDir = "$endDir.php";

        if(!is_file($endDir)){
            throw new InternalException("Problem finding template $template");
        }

        foreach ($varList as $varName => $var) {
            $$varName = $var;
        }

        require $endDir;
    }
}
