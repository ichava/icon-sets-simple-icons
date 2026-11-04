<?php

declare(strict_types=1);

use Simtabi\Laranail\Ichava\Services\IconRegistry;
use Simtabi\Laranail\Ichava\IconSetsSimpleIcons\Enums\Variant;
use Simtabi\Laranail\Ichava\IconSetsSimpleIcons\Constants\IconsConstants;
use Simtabi\Laranail\Ichava\IconSetsSimpleIcons\Providers\IconsServiceProvider;

it(description: 'boots the provider without error', closure: function () {
    $providers = array_keys($this->app->getLoadedProviders());

    expect($providers)->toContain(IconsServiceProvider::class);
});

it(description: 'resolves constants from config json', closure: function () {
    expect(IconsConstants::getVendorPackage())->toBe('ichava/icon-sets-simple-icons')
        ->and(IconsConstants::getTitle())->toBe('Simple Icons')
        ->and(IconsConstants::getPrefix())->toBe('si')
        ->and(IconsConstants::getDefaultVariant())->toBeNull();
});

it(description: 'uses the config prefix in enum class helpers', closure: function () {
    expect(Variant::DEFAULT->getClass())->toBe('si-default');
});

it(description: 'treats the one flat variant as the default, at the files root', closure: function () {
    expect(Variant::default())->toBe(Variant::DEFAULT)
        ->and(Variant::DEFAULT->isDefault())->toBeTrue()
        ->and(Variant::DEFAULT->getPath())->toBe(IconsConstants::getSvgPath())
        ->and(is_dir(Variant::DEFAULT->getPath()))->toBeTrue();
});

it(description: 'ships every icon flat under files/', closure: function () {
    $files = dirname(__DIR__, 2) . '/resources/assets/svg/files';

    expect(glob($files . '/*', GLOB_ONLYDIR) ?: [])->toBe([], 'a flat pack has no folders under files/')
        ->and(count(glob($files . '/*.svg') ?: []))->toBe(3255);
});

it(description: 'picks up the package in the icon registry', closure: function () {
    $registry = $this->app->make(IconRegistry::class);

    expect($registry->isRegistered('ichava/icon-sets-simple-icons'))->toBeTrue(
        'IconRegistry should have ichava/icon-sets-simple-icons registered after boot.',
    );
});
