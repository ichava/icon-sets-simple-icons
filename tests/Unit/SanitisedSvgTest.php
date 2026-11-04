<?php

declare(strict_types=1);

use Simtabi\Laranail\Ichava\Support\SvgPolicy;

/**
 * Every vendored SVG already satisfies core's sanitiser policy, so core serves
 * it unchanged.
 *
 * `core/resources/security/svg-policy.json` is the one definition of what
 * survives sanitisation, and core's PHP, both TypeScript clients and the sync
 * read it. The pack's files were run through icon-sets-sync's sanitiser when
 * they were vendored (Simple Icons 16.36.0); this pins the result against the
 * policy core resolves here, so an upstream refresh that reintroduces a
 * script, a handler, an external reference or a forbidden tag fails.
 */
function simple_icons_policy_violations(string $file): array
{
    $raw = (string) file_get_contents($file);
    $found = [];

    if (stripos($raw, '<!DOCTYPE') !== false) {
        $found[] = 'doctype';
    }

    if (str_contains($raw, '<!ENTITY')) {
        $found[] = 'entity';
    }

    if (str_contains($raw, '<!--')) {
        $found[] = 'comment';
    }

    $dom = new DOMDocument;

    if (@$dom->loadXML($raw, LIBXML_NONET) === false || $dom->documentElement === null) {
        return ['unparseable'];
    }

    $tags = array_flip(SvgPolicy::allowedTags());
    $forbidden = array_flip(SvgPolicy::forbiddenTags());
    $attributes = array_flip(SvgPolicy::allowedAttributes());
    $references = SvgPolicy::referenceAttributes();
    $fragment = SvgPolicy::fragmentPattern();

    $walk = function (DOMElement $element) use (&$walk, &$found, $tags, $forbidden, $attributes, $references, $fragment): void {
        $name = $element->localName;

        if (isset($forbidden[$name]) || ! isset($tags[$name])) {
            $found[] = "tag {$name}";
        }

        foreach ($element->attributes ?? [] as $attribute) {
            $key = $attribute->nodeName;
            $value = (string) $attribute->nodeValue;

            if (! isset($attributes[$key]) && $key !== 'role' && preg_match('/^aria-[a-z]+$/', $key) !== 1) {
                $found[] = "attribute {$name}@{$key}";
            }

            if (in_array($key, $references, true) && preg_match($fragment, $value) !== 1) {
                $found[] = "reference {$key}";
            }

            if (preg_match('/javascript:|data:|expression\(|behavior:|-moz-binding|url\(\s*[\'"]?[^#\s\'")]/i', $value) === 1) {
                $found[] = "value {$key}";
            }
        }

        foreach ($element->childNodes as $child) {
            if ($child instanceof DOMElement) {
                $walk($child);
            }
        }
    };
    $walk($dom->documentElement);

    if ($dom->documentElement->localName !== 'svg') {
        $found[] = 'root is not svg';
    }

    return array_values(array_unique($found));
}

it('ships only SVGs core sanitises to themselves', function (): void {
    $root = dirname(__DIR__, 2) . '/resources/assets/svg/files';
    $files = [];

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)) as $file) {
        if ($file->isFile() && $file->getExtension() === 'svg') {
            $files[] = $file->getPathname();
        }
    }

    // 3,255 icons. A walk that matches nothing must fail, not pass.
    expect(count($files))->toBeGreaterThanOrEqual(3255);

    $offenders = [];

    foreach ($files as $file) {
        $violations = simple_icons_policy_violations($file);

        if ($violations !== []) {
            $offenders[] = substr($file, strlen($root) + 1) . ' => ' . implode(', ', $violations);
        }
    }

    expect($offenders)->toBe([]);
});

it('detects what the policy strips, and passes a clean icon', function (): void {
    $dir = sys_get_temp_dir() . '/simple_icons-policy-' . bin2hex(random_bytes(4));
    mkdir($dir);

    file_put_contents($dir . '/bad.svg', '<!-- x --><svg xmlns="http://www.w3.org/2000/svg" onload="alert(1)"><script>alert(1)</script><use href="https://example.test/a.svg#x"/><path d="M0 0" data-slot="icon"/></svg>');
    file_put_contents($dir . '/good.svg', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><title>Ok</title><use href="#a"/><path id="a" d="M0 0" fill="currentColor"/></svg>');

    expect(simple_icons_policy_violations($dir . '/bad.svg'))->toContain('comment', 'attribute svg@onload', 'tag script', 'reference href', 'attribute path@data-slot')
        ->and(simple_icons_policy_violations($dir . '/good.svg'))->toBe([]);

    array_map(unlink(...), glob($dir . '/*') ?: []);
    rmdir($dir);
});
