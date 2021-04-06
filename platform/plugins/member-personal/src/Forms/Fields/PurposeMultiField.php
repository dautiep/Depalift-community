<?php

namespace Platform\MemberPersonal\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class PurPoseMultiField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'plugins/member-personal::multi-fields.purpose-multi';
    }
}