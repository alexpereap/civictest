## Test CivicPlus app

To run this application you should have docker and node js (18+) installed in your machine.

1. Run the backend server
```sh
cd .docker
docker compose up --build
```
2. Configure your right env variables by creating a `backend.env` file from `.docker/php8-apache/env-files/backend.env.example`

3. Run the frontend
```sh
cd frontend
npm install
npm start
```
4. A browser window will open automatically, and you can test the application!
