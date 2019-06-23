<?php

$authResolvers = require('./graphql/resolvers/auth.php');
$userResolvers = require('./graphql/resolvers/users.php');

$Resolvers = array_merge(
    $authResolvers,
    $userResolvers
);

return $Resolvers;