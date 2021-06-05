<?php
require __DIR__ . '/../vendor/autoload.php';

use Test\Enums\Language;
use Test\Enums\Users;
use Test\Enums\HTTPMethod;

echo '<h2>Language list</h2>';

Language::forEach(function ($name, $instance) {
    echo "<p>{$name}: {$instance->getName()}</p>";
});

/** @var Language $french */
$french = Language::FR();

if (!$french->equals(Language::DE())) {
    echo '<p>French is not DE !</p>';
}

if (!$french->equals(Language::FR())) {
    echo '<p>French is FR !</p>';
}

echo '<p>' . Language::valueOf('EN')->getName() . '</p>';

echo '<p>----------------------------</p>';

echo '<h2>Users list</h2>';

Users::forEach(function ($name, $instance) {
    echo "<p><strong>{$name}</strong>: {$instance->getFirstName()} {$instance->getLastName()}, {$instance->getAge()} year old [". ($instance->isVip() ? 'VIP' : 'NO VIP') . "]</p>";
});

echo '<h2>HTTP Method</h2>';

HTTPMethod::forEach(function ($name, $instance) {
    echo "<p>{$name}</p>";
});