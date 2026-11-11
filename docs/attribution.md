# Attribution and licence

*Reference.*

## Upstream

[Simple Icons](https://simpleicons.org/) is made by the Simple Icons collaborators. Source: [github.com/simple-icons/simple-icons](https://github.com/simple-icons/simple-icons). This pack vendors 16.36.0, from the npm package `simple-icons`; the version is recorded in `resources/assets/svg/config.json` under `upstream.current_version` and nowhere else.

## Licence

The icons and this package are owned separately:

- **The icons** are under **CC0 1.0 Universal**, dedicated to the public domain by the Simple Icons collaborators ([`LICENSE.md`](https://github.com/simple-icons/simple-icons/blob/develop/LICENSE.md)). The brands they depict are trademarks of their owners, which CC0 does not touch. Simtabi LLC redistributes them and claims no authorship of them.
- **This package's code** (provider, enum, component, configuration) is © Simtabi LLC, [MIT](../LICENSE).

CC0 places no condition on use or redistribution of the drawings. The upstream text is reproduced in [`ATTRIBUTION.md`](../ATTRIBUTION.md) at the package root, which ships in the dist archive (`docs/` does not), and at `resources/assets/svg/licenses/simple-icons/LICENSE.md`.

## Trademarks

**The artwork is CC0; the marks are not.** Every icon in this pack depicts a brand, and each brand is a trademark of its owner. CC0 waives the copyright in the drawing only: it grants no right to use a mark, and it does not say the owner endorses you or this package. Use a logo only to refer to the brand it names, follow the owner's brand guidelines where they publish any, and do not use one in a way that suggests endorsement or affiliation. Simple Icons asks the same in its [disclaimer](https://github.com/simple-icons/simple-icons/blob/develop/DISCLAIMER.md), and a brand owner may ask for an icon to be removed upstream.

## Icons left out

212 icons whose entry in Simple Icons' data file names a licence other than CC0 are not in this pack. [`ATTRIBUTION.md`](../ATTRIBUTION.md) lists each with its licence.

## Credit

A visible credit is not required by the licence, but is welcome on a "credits" or "about" page:

> Brand icons from [Simple Icons](https://simpleicons.org) (CC0). All brand names and logos are trademarks of their owners.

## Updating from upstream

Asset refreshes run **maintainer-side** via
[`ichava/icon-sets-sync`](https://github.com/ichava/icon-sets-sync), which polls `simple-icons` on npm, refreshes the
SVGs when upstream moves, and opens a pull request. Before it writes anything it compares the upstream licence at
the new version with the hash in `config.json`, and stops if it changed.

End users **don't** refresh locally -- `vendor/` is regenerated on every
`composer install`, so any local change is discarded. Run
`php artisan ichava::ichava-core.check-updates --package=ichava/icon-sets-simple-icons`
to see whether a new upstream version is available.

---

[← Docs index](../README.md#documentation)
