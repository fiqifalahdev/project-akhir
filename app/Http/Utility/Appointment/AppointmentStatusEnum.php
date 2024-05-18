<?php

namespace App\Http\Utility\Appointment;

enum AppointmentStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public static function toArray(): array
    {
        return [
            self::PENDING,
            self::ACCEPTED,
            self::REJECTED,
        ];
    }

    public static function getValueArray(): array
    {
        return [
            self::PENDING->value,
            self::ACCEPTED->value,
            self::REJECTED->value
        ];
    }

    public static function toSelectArray(): array
    {
        return [
            ['value' => self::PENDING, 'label' => 'Pending'],
            ['value' => self::ACCEPTED, 'label' => 'Accepted'],
            ['value' => self::REJECTED, 'label' => 'Rejected'],
        ];
    }
}
