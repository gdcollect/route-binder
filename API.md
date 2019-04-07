**Note**: Every method listed in this API is accessed inside an assertion chain. You don't manually initialize any of those classes.

# Binder #
| returns | name |
| --- | --- |
| AssertionBuilder | ```static build(string $modelClass, $val, array $config)```  |



```php
    $config = [
        'strategy' => 'Leonc\RouteBinder\Strategy\BaseStrategy'
        'relations' => []
    ];
```

# AssertionBuilder #
| returns | name |
| --- | --- |
| bool | ```belongsTo(string $class, $val, $key = null)``` |
| bool | ```hasAttr(string $attr)``` |
| bool | ```attrHasLength(string $attr, $length)``` |
| bool | ```attrEquals(string $attr, $val)``` |
| bool | ```attrEqualsStrong(string $attr, $val)``` |
| bool | ```attrTruthy(string $attr)``` |
| bool | ```attrFalsy(string $attr)``` |
| bool | ```attrGreaterThan(string $attr, $val)``` |
| bool | ```attrLessThan(string $attr, $val)``` |
| bool | ```attrGreaterEqual(string $attr, $val)``` |
| bool | ```attrLessEqual(string $attr, $val)``` |
| bool | ```attrBetween(string $attr, $val1, $val2)``` |
| bool | ```attrBetweenEqual(string $attr, $val1, $val2)``` |

# BaseStrategy #
| returns | name |
| --- | --- |
| HttpResponseException | ```fail($message, string $modelName)```  |
| Model | ```bind(Model $model)```  |
| Model | ```getModel(Model $rawInstance, string $key, array $relations)```  |
| bool | ```exists(Model $model)```  |


# AssertionInvoker #
| returns | name |
| --- | --- |
| $this | failMessage($message = null)  |
| $this | persistFailMessage($message)  |
| $this | strategy($class = null)  |
| $this | persistStrategy(string $class)  |
| Model | bind() |


