<?php

declare(strict_types=1);

/**
 * The icons are not Simtabi LLC's, and the package has to say so wherever it goes.
 *
 * `LICENSE` covers the package code only and stays the plain MIT text, so GitHub
 * and Packagist keep detecting it as MIT: a third-party notice appended to it made
 * the detector answer NOASSERTION in the sibling packs. The upstream notice lives in
 * `ATTRIBUTION.md` at the root, because `docs/` is export-ignored and never reaches
 * a consumer's vendor directory.
 */
function simple_icons_attribution_root(): string
{
    return dirname(__DIR__, 2);
}

/** Strings ATTRIBUTION.md must carry verbatim: the upstream notice and its licence. */
function simple_icons_attribution_required(): array
{
    return [
        '# CC0 1.0 Universal',
        'Affirmer hereby overtly, fully, permanently, irrevocably and unconditionally waives',
        'https://github.com/simple-icons/simple-icons',
        'the marks are not',
    ];
}

it(description: 'ships ATTRIBUTION.md at the package root', closure: function () {
    expect(is_file(simple_icons_attribution_root() . '/ATTRIBUTION.md'))->toBeTrue();
});

it(description: 'never export-ignores ATTRIBUTION.md, so the notice reaches every install', closure: function () {
    $lines = file(simple_icons_attribution_root() . '/.gitattributes', FILE_IGNORE_NEW_LINES) ?: [];
    expect(count($lines))->toBeGreaterThan(0);
    foreach ($lines as $line) {
        if (str_contains($line, 'export-ignore')) {
            $pattern = ltrim(trim(strtok($line, " \t")), '/');
            $this->assertFalse(fnmatch($pattern, 'ATTRIBUTION.md'), "'{$line}' would drop ATTRIBUTION.md from the dist archive");
        }
    }
});

it(description: 'carries the upstream notice and licence verbatim', closure: function () {
    $text = (string) file_get_contents(simple_icons_attribution_root() . '/ATTRIBUTION.md');
    $required = simple_icons_attribution_required();
    expect($required)->not->toBeEmpty();
    foreach ($required as $needle) {
        $this->assertStringContainsString($needle, $text, "ATTRIBUTION.md does not carry: {$needle}");
    }
    $this->assertStringContainsString('claims no authorship', $text, 'ATTRIBUTION.md must say Simtabi LLC did not author the icons');
});

it(description: 'ships the upstream licence verbatim beside the assets, at the recorded hash', closure: function () {
    $config = json_decode((string) file_get_contents(simple_icons_attribution_root() . '/resources/assets/svg/config.json'), true, flags: JSON_THROW_ON_ERROR);
    $licence = $config['license'] ?? [];
    $path = simple_icons_attribution_root() . '/' . ($licence['file'] ?? '');

    expect($licence['spdx'] ?? null)->toBe('CC0-1.0')
        ->and($config['package']['license'] ?? null)->toBe('CC0-1.0')
        ->and(is_file($path))->toBeTrue('the upstream licence file is missing')
        ->and(hash_file('sha256', $path))->toBe($licence['sha256'] ?? '', 'the licence copy differs from the hash recorded at ' . ($licence['checked_version'] ?? '?'))
        ->and($licence['checked_version'] ?? null)->toBe($config['upstream']['current_version'] ?? null, 'the licence was checked at a different version than the one vendored');
});

it(description: 'keeps LICENSE to the package code, held by Simtabi LLC', closure: function () {
    $license = (string) file_get_contents(simple_icons_attribution_root() . '/LICENSE');
    expect(preg_match_all('/^Copyright /m', $license))->toBe(1);
    $this->assertStringContainsString('Copyright (c) Simtabi LLC', $license);
    $this->assertStringNotContainsString('NOTICE', $license, 'third-party notices belong in ATTRIBUTION.md; appended to LICENSE they break licence detection');
});

it(description: 'points the README licence section at ATTRIBUTION.md', closure: function () {
    $readme = (string) file_get_contents(simple_icons_attribution_root() . '/README.md');
    expect(preg_match('/^## License\n(.*?)(?=^## |\z)/ms', $readme, $m))->toBe(1);
    $this->assertStringContainsString('(ATTRIBUTION.md)', $m[1]);
    $this->assertStringContainsString('claims no authorship', $m[1]);
});
