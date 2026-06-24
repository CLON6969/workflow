<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case DRAFT = 'draft';
    case UNDER_REVIEW = 'under_review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case RETURNED_FOR_CHANGES = 'returned_for_changes';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::UNDER_REVIEW => 'Under Review',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::RETURNED_FOR_CHANGES => 'Returned for Changes',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-gray-100 text-gray-800',
            self::UNDER_REVIEW => 'bg-yellow-100 text-yellow-800',
            self::APPROVED => 'bg-green-100 text-green-800',
            self::REJECTED => 'bg-red-100 text-red-800',
            self::RETURNED_FOR_CHANGES => 'bg-orange-100 text-orange-800',
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::APPROVED,
            self::REJECTED,
        ]);
    }
}