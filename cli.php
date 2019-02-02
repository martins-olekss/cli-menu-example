<?php

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;

require_once(__DIR__ . '/vendor/autoload.php');
require_once 'Database.php';

$inputCallable = function (CliMenu $menu) {
    $result = $menu->askText()
        ->setPlaceholderText('Enter message')
        ->ask();
    $db = new Database();
    $db->createMessage($result->fetch());
    $db->close();
};

$showCallable = function (CliMenu $menu) {
    (new Database())->showMessages()->close();
};

$dropCallable = function (CliMenu $menu) {
    $db = new Database();
    $db->drop();
    $db->close();
};

$createCallable = function (CliMenu $menu) {
    $db = new Database();
    $db->create();
    $db->close();
};

$truncateCallable = function (CliMenu $menu) {
    $db = new Database();
    $db->truncate();
    $db->close();
};

$lastMessageCallable = function (CliMenu $menu) {
    $db = new Database();
    $db->showLastMessage();
    $db->close();
};

$menu = (new CliMenuBuilder)
    ->setForegroundColour('238')
    ->setBackgroundColour('195')
    ->setTitle('Basic CLI Menu')
    ->setItemExtra('!!!')
    ->addItem('Enter message', $inputCallable)
    ->addItem('Show last 10 messages', $showCallable)
    ->addItem('Show last message', $lastMessageCallable)
    ->addItem('Truncate table', $truncateCallable, true)
    ->addItem('Drop table', $dropCallable, true)
    ->addItem('Create table', $createCallable, true)
    ->addLineBreak('-')
    ->build();

$menu->open();
