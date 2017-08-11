## PHPMars

This is a port from the popular state management library [redux](http://redux.js.org/) but written entirely in PHP. With some extra features to come. 

### Sample usage
```php
$reducer = function ($state, $action) {
    if (! is_array($action)) {
        $type = get_class($action);
        $action = (array)$action;
        $action['type'] = $type;
    }
    return ($action['type'] == 'middleware2') ? false : true;
};

$middleware = function ($getState, $dispatch) { return function ($next) {
        return function ($action) use ($next) {
            if ($action['type'] != 'middleware') {
                return $next(['type' => 'middleware2']);
            }
            return $next($action);
        };
    };
};

$store = Store::create($reducer, true, Redux::applyMiddleware($middleware));
$store->dispatch(['type'=> 'middleware']);

var_dump($store->getState()); // bool(false)

```
