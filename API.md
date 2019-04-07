# Binder #

```php
    static build(string $modelClass, $val, array $config = []);

    $config = [
        'strategy' => ''
        'relations' => []
    ];
```

# AssertionBuilder #

```php
    function belongsTo(string $class, $val, $key = null);
    
    function belongsToBy(string $targetClass, string $agentClass, $val, $agentKey = null, $targetKey = null);

    function hasAttr(string $attr);

    function attrHasLength(string $attr, $length);

    function attrEquals(string $attr, $val);

    function attrEqualsStrong(string $attr, $val);

    function attrTruthy(string $attr);
    
    function attrFalsy(string $attr);

    function attrGreaterThan(string $attr, $val);

    function attrLessThan(string $attr, $val);

    function attrGreaterEqual(string $attr, $val);
    
    function attrLessEqual(string $attr, $val);

    function attrBetween(string $attr, $val1, $val2);

    function attrBetweenEqual(string $attr, $val1, $val2)
```

# BaseStrategy #

```php
    function fail($message, string $modelName);

    function bind(Model $model);

    function getModel(Model $rawInstance, string $key, array $relations);

    bool exists(Model $model);
```

