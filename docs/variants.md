# Variants

*Reference.* How this pack's icons are laid out and addressed.

`ichava/icon-sets-simple-icons` ships **3,255 icons in one style**, flat under `resources/assets/svg/files/`. There is no
variant directory, so an icon's path is its name: `ichava/icon-sets-simple-icons::<name>`.

Every icon is one brand glyph on a 24×24 grid, one colour, with a `<title>` naming the brand and `role="img"`. They are declared as the `brands` category in `config.json` for the browser's grouping; the files are not in a `brands/` folder, so the path is the brand's slug alone. Upstream publishes each brand's own colour in `data/simple-icons.json`; this pack ships the glyphs only, and they fill in the inherited colour.

212 upstream icons are not here, because Simple Icons' data names another licence for them; see [Attribution](attribution.md).

## Examples

```blade
<x-ichava::icon name="ichava/icon-sets-simple-icons::github" class="w-6 h-6" />
<x-ichava::icon name="ichava/icon-sets-simple-icons::laravel" class="w-6 h-6" />
```

## Variant enum (PHP)

The `Variant` enum has one case, so code written against the ecosystem's variant contract works here too:

```php
use Simtabi\Laranail\Ichava\IconSetsSimpleIcons\Enums\Variant;

Variant::DEFAULT->value;       // 'default'
Variant::default();            // Variant::DEFAULT
Variant::DEFAULT->getPath();   // .../resources/assets/svg/files
```

`getPath()` returns the `files/` root itself: the scaffolder's version named a `files/default/` directory, which a
flat pack does not have. The enum implements `IconSetVariantInterface` from core.

## See also

- [Customisation](customization.md)
- [Icon path format](https://github.com/ichava/core/blob/main/docs/tools/icon-path-format.md)

---

[← Docs index](../README.md#documentation)
