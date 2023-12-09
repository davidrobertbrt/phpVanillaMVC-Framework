# DISCLAIMER

**This framework is made as a hobby project and should not be used in production without proper validation and testing on your side! Under no circumstances I will be held responsible or liable in any way for any claims, damages, losses, expenses, costs or liabilities whatsoever (including, without limitation, any direct or indirect damages for loss of profits, business interruption or loss of information) resulting or arising directly or indirectly from your use of or inability to use this framework or any other forks from it, or from your reliance on the information and material on this repository, even if I have been advised of the possibility of such damages in advance.**

# Custom MVC Framework in Vanilla PHP

This repo contains a custom-built PHP framework that follows the Model-View-Controller (MVC) arhitectural pattern. It provides a simple routing system to each controller based on the request sent from the browser, routing file for each URL and data abstraction layer using PHP Data Objects. View system is based on HTML webpages in which you can include CSS, JavaScript and information from the controller using PHP short tags.

## Table of contents

To be written.

## Demo

### Requirements

- `PHP 8.1` or higher
- `Apache/2.4.52` or higher
- MySQL Database Server `Ver 15.1 Distrib 10.6.12-MariaDB` or higher
- _Optional_: `PHPMyAdmin`

### Installation

1. Make sure that the `Apache2` installation has `.htaccess` functionality is enabled.

2. Make sure that **PHP Short Tags** are enabled in `php.ini` file

3. Create the database required for the demo using the `Weather.sql` file located in `app/config`.

4. Make sure that `DbConfig.php` includes the correct information to access the database (_IP,Name of database, Username to access the database and password_)

5. Clone the repo to the server `httpd` specific folder
- For XAMPP: `.htdocs`
- For LAMP stack installed from the Ubuntu repository: `www`

6. Configure the server to point to the `public` directory

7. Start using the application by appending to the server domain: `/example/index`

## Directory structure

This framework comes with a basic directory structure and a set of core files that are required to get started.

- `app` : Contains the framework code, including 'Controllers', 'Models' and 'Views'
- `config` : Contains the configuration files, example 'DbConfig.php' which stores the information necessary to connect to the database
- `public` : Contains the front controller ('index.php') and all publicly files such as CSS code, JavaScript, images and other assets.

You can also create a `vendor` folder to include any Composer dependencies you might use later.

## Usage

### Implementing new controllers

### Implementing new views

To implement a new view, simply create a new PHP file with the webpage structure, CSS, JavaScript and other assets.

The naming convention for the view files is `{Controller/Model}{Action}`.

After that, simply include, in the action you implemented in your controller, the 'render' method.

If you want to pass data, simply use the second `$data` parameter of the render function. _Strongly recommended to use an array to pass your information (could be also associative), or even better an array of 'Model template objects'_.

- Example of a controller which renders a simple view. No data is passed

```
class ExampleController extends Controller
{
    public function index()
    {
        $this->render('ExampleView');
    }
}
```

Now, the view for the index() action: `ExampleIndex.php`

```
<html>
    <head>
        <title>Example page</title>
    </head>
    <body>
        <h1>Example webpage</h1>
        <p>This webpage is an illustrative example that the MVC arhitecture is working. You may edit this page however you want.</p>
        <a href = "https://github.com/davidrobertbrt/mvc-project-mds/blob/main/README.md">More information...</a>
    </body>
</html>
```

- Example of a controller which renders a view based on the data from a model.

`$weatherList` is an array which stores multiple objects of `Weather` type which is a 'Model template' in our application.

```
class WeatherController extends Controller{
    public function show()
    {
        $weatherModel = new WeatherModel();
        $weatherList = $weatherModel->getAll();
        $this->render('WeatherShow',$weatherList);
    }
}
```

The view which shows all the weather entries from the model: `WeatherShow.php`

```
<html>
    <head>
        <title>Weather page</title>
    </head>
    <body>
        <h1>Weather webpage</h1>
        <p>This is a preview of the weather table from the database</p>
        <table>
            <thead>
                <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Temperature</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($data as $entry) {?>
                <tr>
                <td><?=$entry->getId()?></td>
                <td><?=$entry->getDate()?></td>
                <td><?=$entry->getTemperature()?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </body>
</html>
```

### Implementing new models

The `Model` class is the base for all new models in this framework. It mainly includes CRUD functionality and creates a new connection to the database.

You can use this class to create models which use a template class to organise your models as objects.

Example:
```
<?php
require_once '../app/core/Model.php';
require_once 'Weather.php';

class WeatherModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTableName()
    {
        return 'weather';
    }

    public function getById($id)
    {
        $data = parent::readById($this->getTableName(),$id);

        if(!$data)
            return null;
        
        return Weather::loadByParams($data['id'],$data['date'],$data['temperature']);
    }
    //....
}
```

The `readBy..` functions from the base class `Model` return associative arrays based on how many entries the database table has.

The `create` function return the last ID inserted in the database table. The other functions just return a boolean value based on the success or failure of the CRUD operation you used.

To use a new created model in your controller class make sure to include it using `require_once`.

### Implementing middlewares

To implement a middleware, first create a new middleware by using the interface 'Middleware.php' which is stored in 'app/core'.

Example of a middleware:

```
<?php
class ExampleMiddleware implements Middleware{
    public function __invoke($data){
        echo("Example middleware invoked!");
        return $data;
    }
}
```

The routing class automatically calls the middleware. $data represents the Response / Request based on what you need. For example if a user is not logged in, you can send a Response using the `Response` class. Simply create a new Request and pass it through `$data`. **Make sure that you always return `$data` because you might lose the request / response.**

To use the middlewares created in your application, define them in the `Middlewares.php` file based on the routes you defined in `routes.php`.

### Using the Cookie utility class

To create, get and delete cookies from the user, use the utiliy `Cookie` class provided.

### Sending a response

To send a response, simply create a new response object with the content (message) you want to send and also the HTTP status code.

Example of a response sent in the `Router.php` class

```
            if (!file_exists($middlewareFilename)) 
            {
                $response = new Response("Middleware not found: $middlewareFilename",500);
                $response->send();
                exit();
            }
```

## Overview of the functionality

The sub-folder `core` of the `app` folder include the main functionality of the framework.

This section will describe each file, one by one.

### `Request.php`

This module parses the request URL and returns an associative array containing the controller, action, HTTP method, and request data (GET and POST). The URL is split into an array using the forward slash '/' as a delimiter. The first and second elements of this array are assigned to the `$controller` and `$action` variables respectively. The HTTP method is obtained from the `$_SERVER['REQUEST_METHOD']` superglobal variable. The request data is stored in the $requestData array, with GET parameters stored in the 'GET' key and POST parameters stored in the 'POST' key. The GET parameters are obtained by taking all elements of the URL array after the first two. The POST parameters are obtained from the `$_POST` superglobal variable if the HTTP method is POST.

By using the `init.php` file, the request is then passed to the `Router` by using the function `route(..)`.

### `Router.php`

Router module for the MVC framework which is responsable for handling requests made by the user. The request is received parsed from `Request.php`.
Mainly, it creates the instance of the appropriate controller and executes the action invoked by the browser using the `route(..)` function.

Router is singleton based, mainly because it allows to maintain its state across multiple requests. Also, the singleton pattern allows us to better organize and manage the application's routing logic, which enables consistent routing and requesting logic throughout the framework.

We can also see that the router checks if a controller, and his action exist, which is why it is important the name of each controller class and the filename in which it is stored to be exactly the same.

```
    if(!file_exists($controllerFileName))
    {
        // controller file was not found
        $response = new Response("Controller not found.",500);
        $response->send();
        exit();
    }

```

```
    if(!method_exists($controller,$actionName))
    {
        // action was not found
        $response = new Response("Action not found.",500);
        $response->send();
        exit();
    }
```

These code snippets can be modified to use a ErrorController for showing webpages for each specific error,including the wrong URL.

```
    if($route === null)
    {
        // route not found
        http_response_code(404);
        die("Page not found.");
    }
```

### `Model.php`

As explained in the sub-section "Implementing new models" this class can be used with inheritence to create new models in our application to quickly add CRUD functionality to each one.
I have used PDO as it is a consistent API for accessing various databases, including MySQL. It allows for writing database-independent code, making it easier to swtich between various database management systems if needed. It also protects from SQL injection attacks with the use of prepared statements.

Most of the queries on the database are constructed as SQL instructions using string manipulation. For example to construct the `update` function, we use a template SQL query and then using the data provided, we construct the query specific to each use-case.

```
$set = implode(' = ?, ',array_keys($data)) . ' = ? ';
```

This line creates an SQL `SET` clause, which sets the columns in `$data` to their corresponding values. The `array_keys()` function is used to get the column names as an array, which are then joined into a string with `implode()`. The resulting string is a comma-separated list of column names with `= ?` placeholders. The final `= ?` is concatenated to handle the last column, which doesn't need a comma.

```
$values = array_values($data);
$values[] = $id;
```

These lines create an array of values to be used with the UPDATE statement. The array_values() function is used to get the values of the $data array as an array, which are then appended with $id to make up the final set of values to update.

Finally, we use the `prepare()` function of PHP Data Objects to pass the SQL statement.

```
$stmt = $this->db->prepare("UPDATE {$table} SET {$set} WHERE id = ?");
```

### `Controller.php`

This class just imports the necessary PHP file for the specific view which the programmer wants to use. Before, I would actually use also another function called `model(...)` to import the model, but that isn't necessary, because it is simpler to use `require_once` in the specific Controller of each model/view combination.

## Reflection

This was a project that I built for my university course on "Software and Design". The goal of the project was to discuss a framework that we had learned. As I was interested in the functionality of popular frameworks like Laravel, I decided to first learn how it works by building a smaller version that follows the same pattern. Initially, I had a first prototype for a project in "Developing web applications", but as I couldn't finish it in time, I redesigned it.

When working on the project, I encountered a significant challenge with the data abstraction layer. Initially, I had wanted to build an Object-Relational Mapping (ORM) system, but I later discovered that I could use PHP Data Objects for data abstraction. After conducting several days of research, I developed a solution that involved creating a base class for each model that had basic Create, Read, Update, and Delete (CRUD) functionality, and then using specific models that extended this base class.

However, I realized that each model might have unique functions for working with the data it contains, such as converting temperature values from Celsius to Fahrenheit in a weather application. To address this issue, I created template classes for each model in the application to facilitate processing of the model's attributes. These templates could be customized to include specific functions relevant to each model.

Ultimately, anyone can use this project for inspiration to build much more functionality specific to the MVC pattern and to build small-scale websites quickly and easily. In the next iteration, I plan to add a read-through cache using tables in the database as a storage format, as well as logger functionality to facilitate debugging and maintenance of the framework.
