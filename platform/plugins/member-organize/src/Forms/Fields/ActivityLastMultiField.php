<?php

namespace Platform\MemberOrganize\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class ActivityLastMultiField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'plugins/member-organize::multi-fields.activity-last-multi';
    }
}