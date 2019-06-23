<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Utils\BuildSchema;

$contents = file_get_contents('./graphql/schema/schema.graphql');
$schema = BuildSchema::build($contents);

return $schema;