# Binder #

```php
    static function build(string $modelClass, $param, array $config = []);

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

    function attrGreaterEqual(stirng $attr, $val);
    
    function attrLessEqual(string $attr, $val);

    function attrBetween($attr, $val1, $val2);

    function attrBetweenEqual($attr, $val1, $val2)

```

