<?php

namespace Sandersao\FileTransfer\System;

class ViewSystem {
    /** @param array<string, string> $varList */
    public function import($templateDir, array $varList = []) {
        foreach ($varList as $varName => $var) {
            $$varName = $var;
        }
        $template = $templateDir;
        $parentPath = realpath(__DIR__. DIRECTORY_SEPARATOR . '..');
        $endDir = str_replace(['.'], [DIRECTORY_SEPARATOR], "$parentPath.View.$template");
        $endDir = "$endDir.php";
        return require $endDir;
    }
}
