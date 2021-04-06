<?php

namespace Platform\MemberOrganize\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class PurPoseMultiField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'plugins/member-organize::multi-fields.purpose-multi';
    }
}