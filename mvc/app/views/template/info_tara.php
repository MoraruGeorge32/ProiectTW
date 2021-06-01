<?php
function tara_detalii($tara)
{
libxml_clear_errors();
    libxml_use_internal_errors(true);
    $path = "https://ro.wikipedia.org/wiki/" . $tara;
    $domTree = new DOMDocument();
    $domTree->loadHTMLFile($path);
    $finder = new DOMXPath($domTree);
    $classname = 'mw-parser-output';
    $containere = $finder->query("//div[@class='" . $classname . "']");
    $articol = $containere->item(0);
    foreach ($articol->childNodes as $child)
        if ($child->nodeName == 'p' && strlen($child->textContent) > 1) {
            return $child->nodeValue;
        }
}

