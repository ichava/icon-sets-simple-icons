# ichava/icon-sets-simple-icons

[![Packagist](https://img.shields.io/packagist/v/ichava/icon-sets-simple-icons)](https://packagist.org/packages/ichava/icon-sets-simple-icons)
[![Tests](https://github.com/ichava/icon-sets-simple-icons/actions/workflows/tests.yml/badge.svg)](https://github.com/ichava/icon-sets-simple-icons/actions/workflows/tests.yml)
[![Static analysis](https://github.com/ichava/icon-sets-simple-icons/actions/workflows/code-quality.yml/badge.svg)](https://github.com/ichava/icon-sets-simple-icons/actions/workflows/code-quality.yml)
[![License MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

> Simple Icons for the Ichava Laravel icon ecosystem: 3,258 SVGs, flat, vendored from `simple-icons` 16.36.0. Brand marks are their owners' trademarks.

Requires [`ichava/core`](https://github.com/ichava/core) `^0.1` on PHP `^8.4.1 || ^8.5` and Laravel `^13`.

## Install

This pack requires [`ichava/core`](https://github.com/ichava/core) and nothing else. Nothing in the Ichava family is on Packagist yet, so the **application's** `composer.json` first names the repositories: core's [installation guide](https://github.com/ichava/core/blob/main/docs/installation.md#1-point-composer-at-the-repositories) holds the one block that lists them, core's dependencies included, and this pack's line in it is `https://github.com/ichava/icon-sets-simple-icons`.

Then require the pack:

```bash
composer require ichava/icon-sets-simple-icons
```

The service provider is discovered automatically. Core's [installation guide](https://github.com/ichava/core/blob/main/docs/installation.md) covers core's own setup.

## Quick start guide and usage

### Getting started

Seed the pack once after installing it, and again after upgrading it:

```bash
php artisan ichava::ichava-core.database seed --package=ichava/icon-sets-simple-icons
```

The seed is not optional: until it runs the registry holds no rows for this pack and every lookup returns nothing. No configuration is needed; the defaults are merged without publishing anything.

### Usage

Icons are addressed as `ichava/icon-sets-simple-icons::<name>`. In Blade, through core's component:

```blade
<x-ichava::icon name="ichava/icon-sets-simple-icons::github" class="w-6 h-6" />
```

Or from PHP, through core's helper:

```blade
{{ ichava('ichava/icon-sets-simple-icons::laravel')->class('w-5 h-5') }}
```

See [Getting started](docs/getting-started.md) for the full walkthrough, and the [Documentation](#documentation) index below for everything else.

## <a name="documentation"></a>Documentation

The full documentation lives in this repository, under `docs/`, and is indexed below.

### This pack

- [Installation](docs/installation.md) — requirements, the repositories block, seeding
- [Getting started](docs/getting-started.md) — your first icon from this pack
- [Configuration](docs/configuration.md) — why there is no config file, and the kind keys in `config.json`
- [Architecture](docs/architecture.md) — what it ships, what it delegates, and why
- [Release](docs/release.md) — how a version is cut, and how the icons are refreshed
- [Variants](docs/variants.md) — the one flat style, and how icons are named
- [Customisation](docs/customization.md) — sizing, colour and accessibility
- [Attribution](docs/attribution.md) — upstream project, licence terms, trademarks and where the vendored version is recorded

### Shared across every pack

- [Use an icon pack](https://github.com/ichava/core/blob/main/docs/recipes/use-an-icon-pack.md) — addressing icons, in Blade and in PHP
- [Seed pack icons](https://github.com/ichava/core/blob/main/docs/recipes/seed-pack-icons.md) — the seeding pipeline and its options
- [Check pack updates](https://github.com/ichava/core/blob/main/docs/recipes/check-pack-updates.md) — the update checker and what its statuses mean
- [Serve icons from a CDN](https://github.com/ichava/core/blob/main/docs/recipes/serve-icons-from-a-cdn.md) — reading this pack's CDN templates out of `config.json`

Its upstream is `simple-icons`; run core's [check pack updates](https://github.com/ichava/core/blob/main/docs/recipes/check-pack-updates.md) recipe to see whether a newer release exists.

## Contributing & security

See [CONTRIBUTING.md](CONTRIBUTING.md). Report vulnerabilities privately through [security policy](https://github.com/ichava/icon-sets-simple-icons/security/policy) — never in a public issue.

## License

The package code is MIT, © Simtabi LLC. See [LICENSE](LICENSE).

The icons are [Simple Icons](https://simpleicons.org/), dedicated to the public domain under CC0 1.0. The brands they depict are trademarks of their owners, and CC0 grants no right to use a mark. Simtabi LLC claims no authorship of them. Their notice is in [ATTRIBUTION.md](ATTRIBUTION.md), which ships with the package, with the trademark notice and the list of icons left out.
