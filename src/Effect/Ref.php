<?php

$_new = function($val) { return function() use($val) { return (object)['value' => $val]; }; };
$newWithSelf = function($f) {
    return function() use ($f) {
        $ref = (object)['value' => null];
        $ref->value = $f($ref);
        return $ref;
    };
};
$read = function($ref) { return function() use($ref) { return $ref->value; }; };
$modifyImpl = function($f, $ref) use (&$modifyImpl) {
    return function() use($f, $ref) { $t = $f($ref->value); $ref->value = $t->state; return $t->value; };
};
$write = function($val, $ref) use (&$write) {
    return function() use($val, $ref) { $ref->value = $val; return null; };
};

$exports['_new'] = $_new;
$exports['newWithSelf'] = $newWithSelf;
$exports['read'] = $read;
$exports['modifyImpl'] = $modifyImpl;
$exports['write'] = $write;
return $exports;
