<?php

namespace Sandersao\FileTransfer\System;

use Sandersao\FileTransfer\IO\Exception\InternalException;

class ViewSystem {
    /**
     * @param string $template
     * @param array<string, string> $varList
     */
    public function import($template, array $varList = []): string {
        ob_start();
        $templatePath = $this->makeTemplatePath($template);

        if(!is_file($templatePath)){
            throw new InternalException("Problem finding template $template");
        }

        foreach ($varList as $varName => $var) {
            $$varName = $var;
        }

        require $templatePath;

        $content = ob_get_clean();

        return $this->makeHtmlBody($content);
    }

    private function makeHtmlBody(string $content): string {
        ob_start();
        $template = 'base.base';
        $templatePath = $this->makeTemplatePath('base.base');
        if(!is_file($templatePath)){
            throw new InternalException("Impossível encontrar o template base '$template'");
        }
        require $templatePath;
        return ob_get_clean();
    }

    private function makeTemplatePath($template) {
        $parentPath = realpath(__DIR__. DIRECTORY_SEPARATOR . '..');
        $endDir = str_replace(['.'], [DIRECTORY_SEPARATOR], "$parentPath.View.$template");
        return "$endDir.php";
    }
}
