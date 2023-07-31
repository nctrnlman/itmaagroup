<?php

namespace App\Helpers;

class CustomHelper
{
    public static function confirmDelete($title, $text = "")
    {
        session()->flash('swal.title', $title);
        session()->flash('swal.text', $text);
    }
}
