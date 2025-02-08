<?php

namespace App\Services\FormBuilder;

class FormComponentBuilder
{
    public static function make($key): FormComponent
    {
        return new FormComponent($key);
    }
}
