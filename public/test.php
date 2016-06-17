<?php

class Foo
{
    public static function test()
    {
        throw new Exception('a');
        return 'a';
    }
}

try{
    $a = Foo::test();
} catch (Exception $e) {
    echo 'b';
}
var_dump($a);