## Description
A Laraval Api wrapper base package for fast build custom api wrapper

Package contain Abstract classes, which you need extended and some helper functions.
Structure your package files so:
```
project
│   Client extends Fenix007\Wrapper\Client
│   Methods
|   YourApiWrapperProvider
│
└───Api
│      YourTestMethodApi
│   
└───config
|       yourconfig.php override apiwrapper.php config
|
└───HttpClient
|       HttpClient with getSecurityParamsToUri function
|
└───Mappers
|       YourMapper extends Fenix007\Wrapper\Mappers\AbstractMapper
|
└───Models
        YourModdel extends Fenix007\Wrapper\Models\AbstractModel
```

Your package provider return `Client` class which allow fast access to `Api/classes` functionality
All Api Methods you can describe in Methods class, like this:
```php
<?php

namespace Siqwell\Eagle;

class Methods
{
    const TRANSLATIONS_GET_LIST = ['method' => 'GET', 'path' => '/streaming/translations.json'];
    const TRANSLATION_GET_INFO = ['method' => 'GET', 'path' => '/streaming/translations/{id}.json'];
}

```

In Api class you can do like this:
```php
<?php
class RecordApi extends Fenix007\Wrapper\Api\AbstractApi
{
    /**
     * @param $id
     * @throws \Exception
     * @return \Siqwell\Eagle\Models\Record
     * ID – идентификатор записи
     */
    public function find($id) : ?Record
    {
        $parameters = [
            'id' => $id
        ];
        
        $result = $this->get(
            Request::createFromMethod(Methods::RECORD_GET_INFO, $parameters),
            RecordMapper::class
        );
        
        return $result;
    }
}
```

So, in project you can use **YourFacade::Record->find(1)**, which return `RecordModel`

Fot phpunit tests add folder in `test/.../Api` directory create TestCase class extended from `\Fenix007\Wrapper\Tests\Api\TestCase`
where you have to define $rootDir and $resourceDir folder, like:

```php
<?php
namespace Siqwell\Eagle\Tests\Api;

class TestCase extends \Fenix007\Wrapper\Tests\Api\TestCase
{
    const DYNAMIC_FIELDS = [
        'current_screenshot',
        'current_screenshot_small',
        'screenshot',
        'screenshot_small',
        'view_count',
        'updated_at'
    ];

    protected $rootDir = ROOT_DIR;
    protected $resourceDir = RESOURCES_DIR;
}
```

Extend API test classes in `test/.../Api` directory from this TestCase
For dummy json response use `test/.../Resources` directory and use directory structure like uri request
If you want to test from Resources dummy folder you need to pass test `HttpClient` in setUp method with `createFakeHttpClient` function:
```php
<?php
    protected function setUp()
    {
        parent::setUp();

        //TODO: change on real API
        $this->translationApi = new TranslationApi($this->createFakeHttpClient());
    }
```
