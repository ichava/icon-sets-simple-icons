<?php

declare(strict_types=1);

namespace Simtabi\Laranail\Ichava\IconSetsSimpleIcons\Enums;

use Simtabi\Laranail\Ichava\Traits\HasIconSetVariants;
use Simtabi\Laranail\Ichava\Contracts\IconSetVariantInterface;
use Simtabi\Laranail\Ichava\IconSetsSimpleIcons\Constants\IconsConstants;

/**
 * Type-safe variant selection for Simple Icons. The pack ships one style, flat under `files/`.
 */
enum Variant: string implements IconSetVariantInterface
{
    use HasIconSetVariants;

    case DEFAULT = 'default';

    /**
     * The pack is flat: its icons sit directly under `files/`, so the one
     * variant has no subfolder. The scaffolder's `getSvgPath($this->value)` would
     * name a `files/default/` directory that does not exist.
     */
    public function getPath(): string
    {
        return IconsConstants::getSvgPath();
    }

    private static function getDefaultValue(): string
    {
        return IconsConstants::getDefaultVariant() ?? self::DEFAULT->value;
    }

    private static function getClassPrefix(): string
    {
        return IconsConstants::getPrefix();
    }
}
