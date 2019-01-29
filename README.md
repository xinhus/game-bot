# Game-Bot


To run it using docker-composer(https://docs.docker.com/compose/):
```sh
$ docker-composer up --build
```

Then navigate to http://localhost/ in your browser.


## API
- Endpoint easy: `http://localhost/api/hard/nextMovement`
- Endpoint hard: `http://localhost/api/easy/nextMovement`

DATA:
```json
{
  "map":[
    ["","",""],
    ["","",""],
    ["","",""]
  ],
  "playerUnit":"X"
}
```
