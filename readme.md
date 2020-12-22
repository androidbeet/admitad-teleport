Usage example #1
```
use Classes\TeleportClass;

$teleport = (new TeleportClass())
    ->setUrl('https://ad.admitad.com/tpt/1e8d114494b7e165239416525dc3e8/')
    ->setCountryCode('ru');

return $teleport->open();
```

Usage example #2
```
use Classes\TeleportClass;

$url = 'https://ad.admitad.com/g/1e8d114494b7e165239416525dc3e8/';

$teleport = new TeleportClass($url, 'ru');

return $teleport->open();
```