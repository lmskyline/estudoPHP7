<?php
// using Application\Entity\Customer to insert/update

define('DB_CONFIG_FILE', '/../data/config/db.config.php');

// setup class autoloading
require __DIR__ . '/../../Application/Autoload/Loader.php';

// add current directory to the path
Application\Autoload\Loader::init(__DIR__ . '/../..');

// classes to use
use Application\Entity\Customer;
use Application\Database\Connection;
use Application\Database\CustomerService;

// get service instance
$service = new customerservice(new Connection(include __DIR__ . DB_CONFIG_FILE));

// sample data
$data = [
    'id'                => '',
    'profile_id'        => '',
    'name'              => 'Doug Bierer',
    'balance'           => 326.33,
    'email'             => 'doug' . rand(0,999) . '@unlikelysource.com',
    'password'          => 'password',
    'status'            => 1,
    'security_question' => 'Who\'s on first?',
    'confirm_code'      => 12345,
    'level'             => 'ADV'
];

// create new Customer
$cust = Customer::arrayToEntity($data, new Customer());

// perform INSERT
echo "\nCustomer ID BEFONE Insert: {$cust->getId()}\n";
$cust = $service->save($cust);
echo "Customer Balance AFTER Update: {$cust->getBalance()}\n";
var_dump($cust);

// perform UPDATE
echo "Customer Balance BEFORE Update: {$cust->getBalance()}\n";
$cust->setBalance(999.99);
$service->save($cust);
echo "Customer Balance AFTER Update: {$cust->getBalance()}\n";
var_dump($cust);