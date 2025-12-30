<?php

namespace App\Forms;

use Merlion\Components\Form\Field;

class CustomCheckboxField extends Field
{
    protected string $view = 'merlion::components.form.custom_checkbox';

    public function options(array $options): static
    {
        $this->with('options', $options);
        return $this;
    }

    public function checked(bool $checked = true): static
    {
        $this->with('checked', $checked);
        return $this;
    }
}