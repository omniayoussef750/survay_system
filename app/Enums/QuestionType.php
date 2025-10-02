<?php

namespace App\Enums;

    /**
     * Create a new class instance.
     */
    enum QuestionType: string
{
    case TEXT = 'text';
    case MULTIPLE_CHOICE = 'multiple_choice';
    case SLIDER = 'slider';
    case CHECKBOX = 'checkbox';
    case RANKING = 'ranking';
    case DROPDOWN = 'dropdown';

    // Human-readable labels
    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Text',
            self::MULTIPLE_CHOICE => 'Multiple Choice',
            self::SLIDER => 'Slider',
            self::CHECKBOX => 'Checkboxes',
            self::RANKING => 'Ranking',
            self::DROPDOWN => 'Dropdown',
        };
    }

    // Helpers
    public function isText(): bool
    {
        return $this === self::TEXT;
    }

    public function isSlider(): bool
    {
        return $this === self::SLIDER;
    }

    public function isMultipleChoice(): bool
    {
        return $this === self::MULTIPLE_CHOICE;
    }

    public function isCheckbox(): bool
    {
        return $this === self::CHECKBOX;
    }
    public function isRanking(): bool
    {
        return $this === self::RANKING;
    }
    public function isDropdown(): bool
    {
        return $this === self::DROPDOWN;
    }

    // Static helpers
    public static function options(): array
    {
        return [
            self::TEXT->value => self::TEXT->label(),
            self::SLIDER->value => self::SLIDER->label(),
            self::MULTIPLE_CHOICE->value => self::MULTIPLE_CHOICE->label(),
            self::CHECKBOX->value => self::CHECKBOX->label(),
            self::RANKING->value => self::RANKING->label(),
            self::DROPDOWN->value => self::DROPDOWN->label(),
        ];
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

