<?php

register_page_template([
    'default' => 'Default',
    'homepage' => 'Home Page',
    'register_member' => 'Register Member',
    'faq'             =>    'FAQ',
    'contact'         =>    'Contact',
    'member_personal' => 'Member Personal'
]);

register_sidebar([
    'id'          => 'second_sidebar',
    'name'        => 'Second sidebar',
    'description' => 'This is a sample sidebar for main theme',
]);

theme_option()->setSection([ // Set section with some fields
    'title' => __('Footer'),
    'desc' => 'null',
    'id' => 'opt-text-subsection-footer',
    'subsection' => true,
    'icon' => 'fa fa-info',
    'fields' => [
        [
            'id' => 'footer_description',
            'type' => 'textarea',
            'label' => __('Footer description'),
            'attributes' => [
                'name' => 'footer_description',
                'value' => null,
                'options' => [
                    'class' => 'form-control'
                ]
            ],
        ],
    ],
])->setSection([ // Set section with some fields
    'title' => __('Header'),
    'desc' => 'null',
    'id' => 'opt-text-subsection-header',
    'subsection' => true,
    'icon' => 'fa fa-heading',
    'fields' => [
        [
            'id' => 'header_logo',
            'type' => 'mediaImage',
            'label' => __('Header Logo'),
            'attributes' => [
                'name' => 'header_logo',
                'value' => null,
                
            ],
        ],
        [
            'id' => 'header_banner',
            'type' => 'mediaImage',
            'label' => __('Header Banner'),
            'attributes' => [
                'name' => 'header_banner',
                'value' => null,
            ],
        ],
    ],
])->setSection([ // Set section with some fields
    'title' => __('Copyright'),
    'desc' => 'null',
    'id' => 'opt-text-subsection-copyright',
    'subsection' => true,
    'icon' => 'fa fa-registered',
    'fields' => [
        [
            'id' => 'copyright_description',
            'type' => 'textarea',
            'label' => __('Copyright description'),
            'attributes' => [
                'name' => 'copyright_description',
                'value' => null,
                'options' => [
                    'class' => 'form-control'
                ]
            ],
        ],
    ],
]);

RvMedia::addSize('featured', 400, 250)
    ->addSize('medium', 800, 600)
    ->addSize('og', 1200, 630)
    ->addSize('full_hd', 1920, 1080)
    ->addSize('other', 225, 150)
    ->addSize('event_feature', 330, 198)
    ->addSize('news_focus', 477, 330)
    ->addSize('image_new', 178, 135)
    ->addSize('image_events_home', 350, 262)
    ->addSize('images_events_home_child', 95, 71)
    ->addSize('image_component', 255, 190)
    ->addSize('image_member', 353, 200)
    ->addSize('image_member_home', 326, 195)
    ->addSize('image_member_slide', 161, 91)
    ->addSize('logo', 253, 124)
    ->addSize('banner', 777, 150)
    ->addSize('mini-logo', 100, 49)
    ->addSize('library_image', 730, 507);

theme_option()
    ->setField([
        'id' => 'default_image',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'mediaImage',
        'label' => __('Default Image'),
        'attributes' => [
            'name' => 'default_image',
            'value' => null,
        ],
    ])
    ->setField([
        'id'         => 'copyright',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Copyright'),
        'attributes' => [
            'name'    => 'copyright',
            'value'   => '© 2020 Laravel Technologies. All right reserved.',
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => __('Change copyright'),
                'data-counter' => 250,
            ]
        ],
        'helper' => __('Copyright on footer of site'),
    ])
    ->setField([
        'id'         => 'primary_color',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'customColor',
        'label'      => __('Primary color'),
        'attributes' => [
            'name'    => 'primary_color',
            'value'   => '#19396a',

        ],
    ])
    ->setField([
        'id'         => 'mail_contact',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Mail contact'),
        'attributes' => [
            'name'    => 'mail_contact',
            'value'   => '',
            'options' => [
                'class' => 'form-control'
            ]

        ],
    ]);


add_action('init', function () {
    config(['filesystems.disks.public.root' => public_path('storage')]);
}, 124);
