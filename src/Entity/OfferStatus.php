<?php

namespace App\Entity;

enum OfferStatus: string
{
    case ACTIVE = 'active';
    case ARCHIVED = 'archived';
    case BLOCKED = 'blocked';
    case SOLD = 'sold';
}

