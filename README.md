### Aboult
- This apllaction is meat to permit the navigation and download through http protocol

### Whaning
- This applcation is not secure and is not meant for production

### How to run locally
## Pre requisits
- All actions must be performed in the terminal
- Change the [ip] to localhost or the ip of the computer in the lan
- Change the [server-ip] to the intented port
## Todo
1. Open the public folder
2. Run de command `php -S [ip]:[port]`

### How to run Lan
## Pre requisits
- All actions must be performed in the terminal
- It's necessary to have docker installed and configured
## Execute the application
- Execute the command `docker-compose up`
## Reset the docker container cache
- Execute the command `docker-compose build --no-cache`
## Access container
- Execute the command `docker exec it file-transfer-app-1 /bin/bash`