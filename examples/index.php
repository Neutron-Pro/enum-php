<?php
require __DIR__ . '/../vendor/autoload.php';

use Test\Enums\Language;
use Test\Enums\Users;
use Test\Enums\HTTPMethod;

echo '<style>body { background-color: #232121; color: #d5d5d5;} h2 {color: #d57e0a} strong { color: #1cb848} .divider {border-top: 1px solid white; margin: 2rem 0}</style>';

echo '<h2>Language list</h2>';

echo '<p><strong>Default Language: </strong> '. Language::_DEFAULT()->getName() .'</p>';

Language::forEach(function ($name, $instance) {
    echo "<p><strong>{$name}</strong>: {$instance->getName()}</p>";
});

$french = Language::FR();

if (!$french->equals(Language::DE())) {
    echo '<p>French is not <strong>DE</strong> !</p>';
}

if (!$french->equals(Language::FR())) {
    echo '<p>French is FR !</p>';
}

echo '<p>' . Language::valueOf('EN')->getName() . '</p>';

echo '<div class="divider"></div>';

echo '<h2>Users list</h2>';

echo '<p><strong>Default User:</strong> ' . Users::valueOf('_DEFAULT') . '</p>';

Users::forEach(function ($name, $instance) {
    echo "<p><strong>{$name}</strong>: {$instance->getFirstName()} {$instance->getLastName()}, {$instance->getAge()} year old [". ($instance->isVip() ? 'VIP' : 'NO VIP') . "]</p>";
});

echo '<div class="divider"></div>';

echo '<h2>HTTP Method</h2>';

echo '<p><strong>Default Method:</strong> ' . HTTPMethod::valueOf('_DEFAULT') . '</p>';

HTTPMethod::forEach(function ($name, $instance) {
    echo "<p><strong>{$name}</strong></p>";
});
