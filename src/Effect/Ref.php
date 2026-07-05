<?php

$Effect_Ref__new = function($val) { return function() use(&$val) { return (object)['value' => $val]; }; };
$Effect_Ref_read = function($ref) { return function() use(&$ref) { return $ref->value; }; };
$Effect_Ref_modifyImpl = function($f, $ref = null) {
    if (func_num_args() < 2) {
        $__args = func_get_args();
        return function(...$more) use ($__args) {
            global $Effect_Ref_modifyImpl;
            return $Effect_Ref_modifyImpl(...array_merge($__args, $more));
        };
    }
    return function() use(&$f, &$ref) { $t = $f($ref->value); $ref->value = $t->state; return $t->value; };
};
$Effect_Ref_write = function($val, $ref = null) {
    if (func_num_args() < 2) {
        $__args = func_get_args();
        return function(...$more) use ($__args) {
            global $Effect_Ref_write;
            return $Effect_Ref_write(...array_merge($__args, $more));
        };
    }
    return function() use(&$val, &$ref) { $ref->value = $val; return null; };
};