# Bitbucket actions -> Chat notifications 

## Installation
Dependencies:
docker, docker-compose

Start docker with:
```
docker-compose up -d
docker-compose exec php composer install
```
### Config your webhooks after copying dist file
```
cp config/webhooks.php.dist config/webhooks.php
```

## Run tests
```
docker-compose exec php vender/bin/phpunit
```

## Usage
```
TODO
```


## Code style
Run ECS with:
```
docker-compose exec php vendor/bin/ecs check --fix
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to follow code style and update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)






