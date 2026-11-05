# Changelog

All notable changes to `ichava/icon-sets-simple-icons` follow [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Changed

- **This pack requires `ichava/core` and nothing else.** `composer.json` `require` is now `php` and `ichava/core`; `illuminate/support` and `laranail/package-tools` were dropped from it and still arrive through core. The provider extends core's `IconPackServiceProvider` and declares its constants class and component class, so `src/` imports no `laranail/*` namespace; it registers the same name, path, Blade component and icon directory as before. The composer `type` is `ichava-icon-set`, which core's pack discovery reads. The README and `docs/installation.md` no longer restate the `laranail/*` repositories: they link to core's installation guide, the one place that lists them, and no longer say the pack is on Packagist, which no Ichava package is yet. `tests/Unit/CoreOnlyDependencyTest.php` fails if any of it comes back.
- **The upstream sync runs icon-sets-sync `06b17d7`** (icon-sets-sync#88), up from `5fa93a6`, which adds this pack's recipe, the `split-variants` and `exclude` transforms, and the `licence_sha256` pin on the upstream licence text. The `uses:` pin and `toolkit-ref` move together; the reusable workflow's inputs did not change between the two commits, so the caller's `with:` block is untouched.

## [0.1.0] - TBD

First release of `ichava/icon-sets-simple-icons`.

### Added

- **Simple Icons 16.36.0**, from the npm package `simple-icons`: 3,255 SVGs flat under `resources/assets/svg/files/`, addressed as `ichava/icon-sets-simple-icons::<name>`. Every file was run through icon-sets-sync's sanitiser and satisfies core's SVG policy unchanged; `tests/Unit/SanitisedSvgTest.php` and `tests/Unit/NoStrayTextNodesTest.php` fail otherwise.
- **The upstream licence is recorded and pinned.** `config.json` names it under `license` (`spdx` `CC0-1.0`, the file, its SHA-256, and the version and date it was checked), the text ships at `resources/assets/svg/licenses/simple-icons/LICENSE.md` and in `ATTRIBUTION.md`, and `tests/Unit/AttributionTest.php` fails if the copy no longer matches the recorded hash or was checked at a different version than the one vendored.
- **212 icons are left out on licence grounds.** Simple Icons is CC0, but its data file names another licence for 224 icons (12 of them CC0-1.0, which ship). The 212 others are listed with their licence in `config.json` `upstream.excluded` and in `ATTRIBUTION.md`, and `tests/Unit/ExcludedIconsTest.php` fails if one is shipped.
- **A trademark notice**: the artwork is CC0, the marks are their owners'. It is in `ATTRIBUTION.md`, `docs/attribution.md` and the README.
- **`package.kind` is `icon`**, with no category, item or rule kind; `tests/Feature/SvgKindTest.php` pins it against `config.json` and against core's resolver.
- **The sibling guards**: `SiblingConstraintsTest`, `NoPersonalContactTest`, `DocsShapeTest`, `ResourceShapeTest`, `ReleaseVersionTest`, `PhpstanLevelTest`, `WorkflowPermissionsTest` and `SyncWorkflowCallerTest`, as in `icon-sets-tabler`.
- **`sync-upstream.yml`** is a caller of icon-sets-sync's reusable `sync-pack.yml`, pinned to commit `5fa93a6`, with `contents: read` and `issues: write` only.
