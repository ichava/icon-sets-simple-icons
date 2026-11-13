<?php

declare(strict_types=1);

/**
 * Simple Icons is CC0, but its data file names another licence for some icons
 * (Apache-2.0, CC-BY-SA, GPL, CC-BY-NC, custom terms and more), and its
 * disclaimer says the repository licence does not cover those. They are left
 * out of this pack and listed in config.json `upstream.excluded`, so a refresh
 * that copies the whole upstream `icons/` directory brings one back and fails
 * here. Measured at 16.36.0: 224 icons carry licence data, 12 of them CC0-1.0,
 * so 212 are excluded and 3,255 of 3,467 ship.
 */
function simple_icons_config(): array
{
    return json_decode(
        (string) file_get_contents(dirname(__DIR__, 2) . '/resources/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );
}

it('lists every excluded icon with the licence that kept it out', function (): void {
    $excluded = simple_icons_config()['upstream']['excluded'] ?? [];

    expect($excluded)->toHaveCount(212);

    foreach ($excluded as $row) {
        expect($row['slug'] ?? '')->not->toBe('')
            ->and($row['licence'] ?? 'CC0-1.0')->not->toBe('CC0-1.0');
    }
});

it('ships none of the excluded icons', function (): void {
    $files = dirname(__DIR__, 2) . '/resources/assets/svg/files';
    $present = [];

    foreach (simple_icons_config()['upstream']['excluded'] ?? [] as $row) {
        if (is_file("{$files}/{$row['slug']}.svg")) {
            $present[] = $row['slug'];
        }
    }

    expect($present)->toBe([]);
});
