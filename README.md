SuperMetrics Social Media Post Analyzing Assignment
==========================

# Use case
This is an example assignment work for Supermetrics.
Assignment is to fetch and collect results of social media posts like average number of
posts by a month or a week, or the longest post and post counts by user.
No external standalone libraries are necessary.

# Prerequisites
* Git
* PHP 7.4
* Composer

# Install
* Install Git, PHP and composer to your local.
* You can also use standalone composer.phar from https://getcomposer.org/download/

* Clone the repository to your local
```shell
$ git clone https://github.com/toijaakko/supermetrics-social-media-post-analyzer.git
```
* Change directory to
```shell
$ cd supermetrics-social-media-post-analyzer
```
* Install autoloader for php files with composer 
```shell
$ composer install --no-dev
```
* Remove `--no-dev` from the previous install command if you want libraries for development
 
# Setup
* Create your own dotenv file for the Client
```shell
$ cp src/Client/etc/.env.example src/Client/etc/.env
```
* Edit your credentials for the Client with your favorite text editor (nano used in this example)
```shell
$ nano src/Client/etc/.evn
```

# Usage
To run the analyzer run the following command
```shell
$ php src/SuperMetrics/run-analyzer.php
```
The script generates a result of analysis of the social media posts which can be found in the result.json in the project root after execution.

# Process description
The project files are in to two different folders, Client and PostAnalyzer. Supermetric's API credential set to the Client's configuration interface. After that the client is able to fetch authentication token and social media posts from the API using that token.

The PostAnalyzer then has a PostCollection interface where the posts fetched by the client can be passed. The post collection contains a post stat collector pool where different kind of statistic analyzers can be added. It already contains three different stat collectors that store the character lengths and post counts of different users. Each time adding or removing post to and from the collection, the stat collectors in the pool process the data in the post.  Lastly there is a PostStatResultParser interface that can be used to finalize the different result outputs from the post stat collectors, which can be then outputted in JSON format etc.

# Development scripts
* Run analyzer
```shell
$ composer run-analyzer
```
* Run php code style check
```shell
$ composer lint
```
* Run php code style fixer
```shell
$ composer lint:fix
```
* Run PHP unit tests and static analysis
```shell
$ composer test
```
* Run PHP unit tests
```shell
$ composer test:unit
```
* Run static analysis
```shell
$ composer test:static-analysis
```
# Author
Jaakko Toivanen (jaakko.toivanen@live.fi)
