<?php

namespace Platform\MemberOrganize\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class ActivityMultiField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'plugins/member-organize::multi-fields.activity-multi';
    }
}