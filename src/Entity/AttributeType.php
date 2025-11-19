<?php

namespace App\Entity;

enum AttributeType: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case SELECT = 'select';
}

