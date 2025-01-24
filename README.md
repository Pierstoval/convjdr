
## Development requirements 

* [Symfony CLI](https://github.com/symfony-cli/symfony-cli)
* Docker Compose
* Make

## Install

Run this command:

```bash
git clone git@github.com:Pierstoval/convjdr.git
cd convjdr
make install
```

Open the https://127.0.0.1:8000 page.

Two users are available at first:

* User: `admin`, password: `admin`, with full access to the backoffice
* User: `visitor`, password: `visitor`, with limited access: this user can only access entities for which they are _"creator"_ (there's a `Creators` field in `src/Entity`, check it out).

If the backoffice itself is not self-explanatory, feel free to [submit an issue](https://github.com/pierstoval/convjdr/issues/new), the goal is to make the project easy to use.

## Licence

The project is under AGPL-3.0 licence.<br>
TL;DR: If you use and customize this project, you must re-publish all the changes in public with the exact same licence, commercial or not. Shorter version: create a fork on Github, push your custom work there (simplest solution).
