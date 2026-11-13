<?php

declare(strict_types=1);

use Simtabi\Laranail\Ichava\IconSetsSimpleIcons\Enums\Variant;

/**
 * Pins the canonical `resources/` shape shared by every Ichava icon pack.
 *
 * The variant assertion is the load-bearing one. bundled-icons shipped a
 * verbatim copy of metronic-icons' translation file -- wrong product, and
 * metronic's four categories against its own ten -- and nothing caught it,
 * because no pack registers translations and so nothing ever read the file.
 * Comparing keys against a real enum is what makes a copied file fail.
 */
function simple_icons_resources(): string
{
    return dirname(__DIR__, 2) . '/resources';
}

/** @return array<string, mixed> */
function simple_icons_lang(): array
{
    return require simple_icons_resources() . '/lang/en/icons.php';
}

it(description: 'ships every path of the canonical resource shape', closure: function () {
    foreach ([
        'assets/svg/config.json',
        'assets/svg/files',
        'lang/en/icons.php',
        'views/components',
    ] as $path) {
        expect(file_exists(simple_icons_resources() . '/' . $path))->toBeTrue("missing resources/{$path}");
    }
});

it(description: 'does not name the translation group after the locale', closure: function () {
    // lang/en/en.php produced `<namespace>::en.name`, with the locale doubled.
    expect(file_exists(simple_icons_resources() . '/lang/en/en.php'))->toBeFalse();
});

it(description: 'does not duplicate config.json metadata in english', closure: function () {
    // These drifted while nothing read them: the lang file claimed "Over 5,000
    // pixel-perfect SVG icons for web projects", config.json "Over 5,200
    // pixel-perfect icons for web apps" in icon-sets-tabler. config.json is the
    // one IconRegistry reads, so it is the only one that may carry them.
    expect(simple_icons_lang())->not->toHaveKey('name')
        ->and(simple_icons_lang())->not->toHaveKey('description');
});

it(description: 'matches its variant keys to the Variant enum exactly', closure: function () {
    $expected = array_column(Variant::cases(), 'value');
    sort($expected);

    foreach (['variants', 'variant_descriptions'] as $group) {
        $actual = array_keys(simple_icons_lang()[$group]);
        sort($actual);

        expect($actual)->toBe(
            $expected,
            "resources/lang/en/icons.php [{$group}] does not match the Variant enum. "
            . 'A mismatch here usually means the file was copied from another pack.',
        );
    }
});

it(description: 'declares itself as this package in config.json', closure: function () {
    $config = json_decode(
        (string) file_get_contents(simple_icons_resources() . '/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    expect($config['package']['name'])->toBe('ichava/icon-sets-simple-icons');
});

it(description: 'points metadata.repository at this package, not its upstream', closure: function () {
    $config = json_decode(
        (string) file_get_contents(simple_icons_resources() . '/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    // Settled 2026-09-21. `metadata.repository` is THIS package's repository.
    //
    // It had drifted to naming the upstream in two packs and was blank in a
    // third, so the field meant three different things across five packs. The
    // stub already defines it as ours for every new pack; `icon-sets.json` pins
    // ours and hands it to `latestTag()`, which only resolves against our tags;
    // and the browser API groups it with package_name, vendor, version and
    // license -- package metadata, not provenance.
    //
    // Upstream identity is not homeless: the `upstream` block carries source,
    // version, version_check_url, licence, CDN and update command in full, and
    // `metadata.homepage` points at the upstream's own site where one exists.
    expect($config['metadata']['repository'])->toBe('https://github.com/ichava/icon-sets-simple-icons');
});

it(description: 'points metadata.homepage at the upstream project, never at this package', closure: function () {
    $config = json_decode(
        (string) file_get_contents(simple_icons_resources() . '/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    // Settled 2026-09-22, enforcing what the repository guard above already
    // states: `metadata.homepage` is the UPSTREAM project's own site.
    //
    // This pack already held the right value; the guard exists because two
    // others did not, and nothing would have caught it. `metadata.homepage`
    // reaches a consumer -- `IconRegistry` reads it into the pack descriptor
    // and the browser API allows it through `publicMetadata()` beside
    // `repository` -- but no frontend renders it, so a wrong value is
    // invisible until someone reads the JSON.
    //
    // Simple Icons publishes its icons at https://simpleicons.org/, distinct from the
    // repository the sync fetches from. Both are upstream facts; this field is
    // the human-facing one.
    $homepage = $config['metadata']['homepage'] ?? null;

    expect($homepage)->toBe('https://simpleicons.org/')
        ->and($homepage)->not->toBe($config['metadata']['repository']);

    // The general rule, asserted separately so it survives an upstream rename:
    // whatever this holds, it is never one of OUR URLs.
    expect($homepage)->not->toContain('github.com/ichava/');
});
