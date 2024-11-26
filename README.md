# Test CivicPlus app

## Running the app locally

To run this application you should have docker and node js (18+) installed on your machine.

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

## Overall description of the solution
The PHP backend provides a series of endpoints that communicate with the civic plus API, gathering the events information or creating new ones, the results of the requests from these endpoints are displayed in the React front end, so essentially the php backend acts as a communication bridge, between the frontend and the civic plus API.

## Functionality details

- The backend of this application is built using RAW PHP, without using any frameworks, or any composer libraries (that may be the same used by frameworks) show casing the use of RAW php skills to develop the whole application.
- The frontend is built in React using the bootstrap CSS library.
- Additionally, an Apache server and a Redis server are used to serve the backend, and are configured in a docker container, for ease of use.

## Design patterns
- This project follows the SOLID principles, implementing a separation of concerns by using a structured and organized folder structure, making use of single responsibility object oriented classes.
- It also implements helper classes and methods to avoid repeating code and instead encourage the reusability of these components (DRY principle).

### Request and Reponse cycle
- Request cycle: Frontend APP ==> consumes endpoints from the PHP backend => the PHP backend authenticates against the civicplus api and gets data from its endpoints using CURL
- Response cycle: Civicplus api responds to PHP backend => PHP backend responds to frontend => frontend displays the results
