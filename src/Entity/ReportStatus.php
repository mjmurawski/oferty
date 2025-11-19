<?php

namespace App\Entity;

enum ReportStatus: string
{
    case OPEN = 'open';
    case IN_REVIEW = 'in_review';
    case CLOSED = 'closed';
}

