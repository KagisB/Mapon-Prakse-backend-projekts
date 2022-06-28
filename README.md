# Mapon-Prakse-backend-projekts

Required:
1) Docker installed

To use this, save the repository on your computer.
Then, open powershell and cd to your directory, where you just saved this repo, then run docker-compose up, to create docker containers for this project.

Install/prepare docker:
run docker-compose up (--build)

Database preparation:

1) cd to project directory
2) If phinx.php file isn't in the project, initiate phinx by running "vendor/bin/phinx init"
3) run "vendor/bin/phinx migrate"
4) then run "vendor/bin/phinx seed:run"

Possible issues:
1) Migration/Seeding doesn't work
2) Migration/Seeding seems to work fine, but doesn't actually create table or insert data in the table

Possible fixes:
1) If the migration doesn't properly create table, truncate the phinxlog table in the database, to clear the migration from logs, allowing it to be ran again.

Use application/launch it on a server/docker hub

