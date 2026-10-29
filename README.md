Cybersecurity Playground 

A small PHP + MariaDB web app demonstrating vulnerabilities and their fixes, running in Docker on an Ubuntu Server VM, accessed from a Windows 10 client over an isolated virtual network.

Project structure

docker-compose.yml
Dockerfile
db/init.sql — creates the users and pets tables on first start
www/vulnerable/ — Phase 1, intentionally insecure (conn.php, login.php, logout.php, pets.php, register.php)
www/secure/ — Phase 2, hardened (same five files)

How it works
Users register an account, log in, and register their pets (species, name, characteristics), which are stored per account and listed back to them.

vulnerable/ builds SQL queries by concatenating user input directly into the query string. Used to demonstrate authentication bypass, error-based injection, UNION-based data exfiltration, second-order injection, and (with multi_query()) privilege/impact escalation via stacked queries.

secure/ uses prepared statements (mysqli with bind_param) for every query, hashes passwords with password_hash()/password_verify(), and escapes output with htmlspecialchars(). Used to confirm the same attacks fail here.

Running it
cd ~/cybersecurity
docker compose up -d --build

To switch which version is served, point the web service’s volume at either ./www/vulnerable or ./www/secure in docker-compose.yml, then:
docker compose down
docker compose up -d --build

Checking the database
docker compose exec db mariadb -u user -ppass petReg
Then: SHOW TABLES; / SELECT * FROM users; / SELECT * FROM pets;
