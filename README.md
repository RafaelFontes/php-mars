## PHPMars

This is a port from the popular state management library [redux](http://redux.js.org/) but written entirely in PHP. With some extra features to come. 

### Sample usage
```php
$reducer = function ($state, $action) {
    return ($action['type'] == 'intercepted') ? false : true;
};

$middleware = function ($getState, $dispatch) { return function ($next) {
        return function ($action) use ($next) {
            if ($action['type'] == 'dothis') {
                return $next(['type' => 'intercepted']);
            }
            return $next($action);
        };
    };
};

$store = Store::create($reducer, true, Redux::applyMiddleware($middleware));

var_dump($store->getState()); // bool(true)

$store->dispatch(['type'=> 'dothis']);

var_dump($store->getState()); // bool(false)

```
