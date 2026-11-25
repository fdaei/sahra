<?php

declare(strict_types=1);

namespace App\Services\Content;

use DOMDocument;
use DOMElement;
use DOMXPath;

/**
 * UTF-8-safe DOM wrapper around an HTML *fragment* (an article body).
 * The fragment is parsed inside a sentinel root so it round-trips without
 * <html>/<body> wrappers, and Persian text is never turned into entities.
 */
final class HtmlFragment
{
    private const ROOT_ID = '__fragment_root__';

    public readonly DOMDocument $doc;

    public readonly DOMElement $root;

    public readonly DOMXPath $xpath;

    public function __construct(string $html)
    {
        $this->doc = new DOMDocument('1.0', 'UTF-8');

        $previous = libxml_use_internal_errors(true);
        $this->doc->loadHTML(
            '<?xml encoding="UTF-8"?><div id="'.self::ROOT_ID.'">'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET,
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $this->xpath = new DOMXPath($this->doc);
        $root = $this->xpath->query('//*[@id="'.self::ROOT_ID.'"]')->item(0);
        $this->root = $root instanceof DOMElement ? $root : $this->doc->createElement('div');
    }

    public function html(): string
    {
        $out = '';
        foreach ($this->root->childNodes as $child) {
            $out .= $this->doc->saveHTML($child);
        }

        return $out;
    }
}
