# asset-json-reader

Reads asset locations from a json file outputted by webpack. Works well with [asset-webpack-plugin](https://www.npmjs.com/package/assets-webpack-plugin) or [webpack-manifest-plugin](https://www.npmjs.com/package/webpack-manifest-plugin), which stores the hashed filenames in a json file. With this package you can easily get the hashed filenames

## Install

```sh
composer require kapoko/asset-json-reader:dev-main
```

## Usage

Output by the [asset-webpack-plugin](https://www.npmjs.com/package/assets-webpack-plugin) may look something like this (`dist/assets.json`):

```json
{
    "one": {
        "js": "/js/one_2bb80372ebe8047a68d4.bundle.js"
    },
    "two": {
        "js": "/js/two_2bb80372ebe8047a68d4.bundle.js"
    }
}
```

Usage is:

```php
use Kapoko\AssetJsonReader\AssetJsonReader;

$assets = new AssetJsonReader($pathToJson);

$assets->get('one.js')); // Returns '/js/one_2bb80372ebe8047a68d4.bundle.js'
$assets->get('two.js')); // Returns '/js/two_2bb80372ebe8047a68d4.bundle.js'
```

If the manifest doesn't exists it returns the given string, which might be handy in development mode when the files aren't hashed.
