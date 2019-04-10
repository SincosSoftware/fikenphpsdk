# Fiken PHP SDK
A Fiken PHP SDK 


## Installation
Add this your composer.json
```js
"repositories": [
  {
    "type": "git",
    "url": "git@github.com:SincosSoftware/fikenphpsdk.git"
  }
],
```
Then `composer require sincos/fiken-php-sdk`.


## Local development
Add this to your Webshop composer.json, _in front of_ the above repository.
```js
"repositories": [
  {
    "type": "path",
    "url": "../../../fikenphpsdk"
  }
],
```

Make sure `url` points to your clone of Fiken PHP SDK.  

Then you have to make sure you are requiring the correct branch of the local version of the Fiken PHP SDK.

You do this by changing the version requirement on this line:
```
"sincos/fiken-php-sdk": "^1.2"
```

To this:
```
"sincos/fiken-php-sdk": "dev-branch-name"
```

Replace "branch-name" with whatever your branch name is, for instance `master`.