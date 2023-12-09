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

## Reflection

This was a project that I built for my university course on "Software and Design". The goal of the project was to discuss a framework that we had learned. As I was interested in the functionality of popular frameworks like Laravel, I decided to first learn how it works by building a smaller version that follows the same pattern. Initially, I had a first prototype for a project in "Developing web applications", but as I couldn't finish it in time, I redesigned it.

When working on the project, I encountered a significant challenge with the data abstraction layer. Initially, I had wanted to build an Object-Relational Mapping (ORM) system, but I later discovered that I could use PHP Data Objects for data abstraction. After conducting several days of research, I developed a solution that involved creating a base class for each model that had basic Create, Read, Update, and Delete (CRUD) functionality, and then using specific models that extended this base class.

However, I realized that each model might have unique functions for working with the data it contains, such as converting temperature values from Celsius to Fahrenheit in a weather application. To address this issue, I created template classes for each model in the application to facilitate processing of the model's attributes. These templates could be customized to include specific functions relevant to each model.

Ultimately, anyone can use this project for inspiration to build much more functionality specific to the MVC pattern and to build small-scale websites quickly and easily. In the next iteration, I plan to add a read-through cache using tables in the database as a storage format, as well as logger functionality to facilitate debugging and maintenance of the framework.
