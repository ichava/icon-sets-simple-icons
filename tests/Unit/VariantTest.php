<?php

declare(strict_types=1);

use Simtabi\Laranail\Ichava\IconSetsSimpleIcons\Enums\Variant;

/**
 * Pure-enum behaviour tests. Anything that touches config.json (default(),
 * isDefault(), getClass(), getPath()) lives in the Feature suite where the
 * Laravel container is bootstrapped.
 */
it(description: 'exposes the one flat case value', closure: function () {
    expect(Variant::DEFAULT->getValue())->toBe('default');
});

it(description: 'returns every case from values', closure: function () {
    expect(Variant::values())->toBe(['default']);
});

it(description: 'resolves known values and rejects unknown ones', closure: function () {
    expect(Variant::tryFromValue('default'))->toBe(Variant::DEFAULT)
        ->and(Variant::tryFromValue('not-a-real-variant'))->toBeNull();
});
