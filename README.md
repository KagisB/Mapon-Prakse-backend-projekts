# Mapon-Prakse-backend-projekts

Required:
1) Docker installed

To use this, save the repository on your computer.
Then, open powershell and cd to your directory, where you just saved this repo, then run docker-compose up, to create docker containers for this project.

Install/prepare docker:
run docker-compose up (--build)

then, once the docker containers have been created, run

docker exec --workdir /Mapon-Prakse-backend-projekts php_container_name composer install

to install dependencies from composer. Now, if everything has been installed correctly and no errors appear, can move on to the next part.
Database preparation:

1) Open the php container command line, either through docker desktop or through powershell
2) Once php CLI is opened,cd to project directory(which should be /Mapon-Prakse-backend-projekts)
3) If phinx.php file isn't in the project, initiate phinx by running "vendor/bin/phinx init"
4) run "vendor/bin/phinx migrate"
5) then run "vendor/bin/phinx seed:run"

Possible issues:
1) Migration/Seeding doesn't work
2) Migration/Seeding seems to work fine, but doesn't actually create table or insert data in the table

Possible fixes:
1) If the migration doesn't properly create table, truncate the phinxlog table in the database server, to clear the migration from logs, allowing it to be ran again.

Use application/launch it on a server/docker hub

