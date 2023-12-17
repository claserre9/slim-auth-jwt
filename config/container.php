<?php

use App\EntityManagerFactory;

use Doctrine\ORM\EntityManagerInterface;


$definitions = [
    EntityManagerInterface::class=> DI\factory([EntityManagerFactory::class, 'create']),
];



return $definitions;