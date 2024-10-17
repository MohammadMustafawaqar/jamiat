<?php

namespace App\Enums;

enum ThesisStatus: int
{
    case Waiting = 0;
    case Accepted = 1;
    case Rejected = 2;

    public function label(): string
    {
        return match($this) {
            self::Waiting => '<span class="me-1 badge bg-secondary">انتظار</span>',
            self::Accepted => '<span class="me-1 badge bg-success">قبول</span>',
            self::Rejected => '<span class="me-1 badge bg-danger">رد</span>',
        };
    }
}
