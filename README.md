# Url Shortener based om Slim Framework 3

## Prerequisites
1. PHP >= 7.0
2. Composer installed for managing PHP Dependencies
3. Git for accessing GitHub

### Install the Application

#### Step 1: Clone the project
```bash
git clone
```
#### Step 2: Install Dependencies
```bash
compose install
```
#### Step 3: Running Tests
```bash
composer test
```

### Run the Application

#### Step 1: Start PHP Server
```bash
composer start
```

#### Step 2: Navigate to API Description (swagger.json)
```bash
Open on your Browser http://localhost:8080/swagger
```

### Application Design
 The Url Shortener is built using the Slim framework, managing project dependencies with composer and implementing the MVC and Strategy pattern. Dependency Injection (based on Pimple) has been used to manage the
 dependencies and lazy loading.
 
 ### Application Structure
 ```bash
 - config
 --- dependencies [All Services Used are declared here.]
 --- errorHandlers [Overrides the default error handlers to produce custom responses.]
 --- middleware [Used to validate the headers for the incoming request.]
 --- routes [API Routes.]
 --- settings [Keeps all the projects settings.]
 - logs [Applications logs]
 - src
 --- Constants [Holds all the Const Variables used across all the project as a central point of reference] 
 --- Controllers [Default Controller that holds the routes]
 --- Interfaces [Interface Used for the Providers]
 --- Models [Model of the incoming request] 
 --- Providers [The 2 providers currently used Bitly and Rebrandly] 
 --- Services [Contains the Shortening Service and the Validator Service Used]
 - tests [Application Tests with PHPUnit] 
 ```
 
### Licence
This package is released under the MIT License.
