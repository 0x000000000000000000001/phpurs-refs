<?php

$_new = function($val) use (&$_new) { return function() use(&$val) { return (object)['value' => $val]; }; };
$read = function($ref) use (&$read) { return function() use(&$ref) { return $ref->value; }; };
$modifyImpl = function($f, $ref = null) use (&$modifyImpl) {
    if (\func_num_args() < 2) {
        $__args = \func_get_args();
        return function(...$more) use ($__args, &$modifyImpl) {

            return $modifyImpl(...\array_merge($__args, $more));
        };
    }
    return function() use(&$f, &$ref) { $t = $f($ref->value); $ref->value = $t->state; return $t->value; };
};
$write = function($val, $ref = null) use (&$write) {
    if (\func_num_args() < 2) {
        $__args = \func_get_args();
        return function(...$more) use ($__args, &$write) {

            return $write(...\array_merge($__args, $more));
        };
    }
    return function() use(&$val, &$ref) { $ref->value = $val; return null; };
};

$exports['_new'] = $_new;
$exports['read'] = $read;
$exports['modifyImpl'] = $modifyImpl;
$exports['write'] = $write;
return $exports;
