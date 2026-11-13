# Getting started

*How-to guide.* Your first icon from this pack, once [Installation](installation.md) is done.

## Render one

```blade
<x-ichava::icon name="ichava/icon-sets-simple-icons::github" class="w-6 h-6" />
```

The component is core's and is generic: the pack is named in the path, not in the tag. The path is the file name without `.svg`; [Variants](variants.md) explains why there is no variant segment.

## Or from PHP

```blade
{{ ichava('ichava/icon-sets-simple-icons::laravel')->class('w-5 h-5') }}
```

Both spellings of the path resolve to the same icon -- slash and dot are normalised by one
resolver, documented in core's [icon path format](https://github.com/ichava/core/blob/main/docs/tools/icon-path-format.md).

## Finding a name

Names are Simple Icons's own file names. Browse them at [simpleicons.org](https://simpleicons.org/), or list them from the pack:

```bash
ls vendor/ichava/icon-sets-simple-icons/resources/assets/svg/files
```

## If nothing renders

Almost always the seed has not run. Check with:

```bash
php artisan ichava::ichava-core.info icons --package=ichava/icon-sets-simple-icons
```

Zero rows means the seed step of [Installation](installation.md) is outstanding. Core's
[troubleshooting](https://github.com/ichava/core/blob/main/docs/troubleshooting.md) covers the rest.

## See also

- [Variants](variants.md) -- what this pack ships and how to address it
- [Customisation](customization.md) -- colour, size, and this pack's own knobs
- [Use an icon pack](https://github.com/ichava/core/blob/main/docs/recipes/use-an-icon-pack.md) -- the generic guide, for any pack

---

[← Docs index](../README.md#documentation)
