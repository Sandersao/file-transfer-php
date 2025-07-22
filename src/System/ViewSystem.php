<?php

namespace Sandersao\FileTransfer\System;

use Sandersao\FileTransfer\IO\Exception\InternalException;

class ViewSystem {
    /** @param array<string, string> $varList */
    public function import($templateDir, array $varList = []) {
        $template = $templateDir;
        $parentPath = realpath(__DIR__. DIRECTORY_SEPARATOR . '..');
        $endDir = str_replace(['.'], [DIRECTORY_SEPARATOR], "$parentPath.View.$template");
        $endDir = "$endDir.php";

        if(!is_file($endDir)){
            throw new InternalException("Problem finding template $templateDir");
        }

        foreach ($varList as $varName => $var) {
            $$varName = $var;
        }

        return require $endDir;
    }
}
