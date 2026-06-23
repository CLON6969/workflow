<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case UNDER_REVIEW = 'under_review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case RETURNED = 'returned';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::UNDER_REVIEW => 'Under Review',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::RETURNED => 'Returned for Changes',
        };
    }

    /**
     * Get badge color for Blade views
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::DRAFT => 'bg-gray-100 text-gray-800',
            self::SUBMITTED => 'bg-blue-100 text-blue-800',
            self::UNDER_REVIEW => 'bg-yellow-100 text-yellow-800',
            self::APPROVED => 'bg-green-100 text-green-800',
            self::REJECTED => 'bg-red-100 text-red-800',
            self::RETURNED => 'bg-orange-100 text-orange-800',
        };
    }

    /**
     * Check if status allows editing by applicant
     */
    public function isEditable(): bool
    {
        return $this === self::DRAFT;
    }
}