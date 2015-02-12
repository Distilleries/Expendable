#Exependable

##Installation

```
    "distilleries/expendable": "1.*",
    
```

## Add service providers

In you app.php config file add in `providers` table:

```php

    'Netson\L4gettext\L4gettextServiceProvider',
    'Chumper\Datatable\DatatableServiceProvider',
    'Distilleries\DatatableBuilder\DatatableBuilderServiceProvider',
    'Distilleries\FormBuilder\FormBuilderServiceProvider',
    "Ollieread\Multiauth\MultiauthServiceProvider",
    "Ollieread\Multiauth\Reminders\ReminderServiceProvider",
    'Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider',
    'Wpb\StringBladeCompiler\StringBladeCompilerServiceProvider',
    'Distilleries\Expendable\ExpendableServiceProvider',
    'Distilleries\Expendable\MailServiceProvider',
    'mnshankar\CSV\CSVServiceProvider',
    'Maatwebsite\Excel\ExcelServiceProvider',

```

In the `aliases` table:

```php

    'Mail'              => 'Distilleries\Expendable\Facades\Mail',
    'Datatable'         => 'Distilleries\DatatableBuilder\Facades\DatatableBuilder',
    'FormBuilder'       => 'Distilleries\FormBuilder\Facades\FormBuilder',
    'Gravatar'          => 'Thomaswelton\LaravelGravatar\Facades\Gravatar',
    'CSV'               => 'mnshankar\CSV\CSVFacade',
    'Excel'             => 'Maatwebsite\Excel\Facades\Excel',
```
    
**Replace the service old facade Mail by the new one.**
    

##Configurations

```
    php artisan config:publish distilleries/expendable
    
```


Field | Usage
----- | -----
login_uri | Define the login page for the admin login
admin_base_uri | Define the base uri for the admin urls
config_file_assets| file when you have the version number of the application
folder_whiteliste | Table of folders accessible to display the assets
listener | Classes listener a specific event
mail.template | Generic skeleton of the email template
mail.actions | List of action available to send an email
mail.override | If define to yes that send all the email with the email give in the table mail.override.to, mail.override.cc, mail.override.bcc
menu.left | Use the method \Distilleries\Expendable\Config\MenuConfig::menu() to merge the default menu with your menu
state | List of state available



```php

    return [
        'login_uri'          => 'admin/login',
        'admin_base_uri'     => 'admin',
        'config_file_assets' => base_path() . '/package.json',
        'folder_whiteliste'  => [
            'moximanager'
        ],
        'listener'           => [
            '\Distilleries\Expendable\Listeners\UserListener'
        ],
        'mail'               => [
            'template' => 'admin.templates.mails.default',
            "actions"  => [
                'emails.auth.reminder'
            ],

            'override' => [
                'enabled' => false,
                'to'      => [''],
                'cc'      => [''],
                'bcc'     => ['']
            ]
        ],
        'menu'               => \Distilleries\Expendable\Config\MenuConfig::menu([
            'left' => [
                [
                    'icon'    => 'globe',
                    'action'  => 'Admin\CountryController@getIndex',
                    'libelle' => _('Country'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of Country'),
                            'action'  => 'Admin\CountryController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Country'),
                            'action'  => 'Admin\CountryController@getEdit',
                        ]
                    ]
                ],
            ]
        ], 'beginning'),

        'state'              => [
            'Distilleries\Expendable\Contracts\DatatableStateContract' => [
                'color'            => 'bg-green-haze',
                'icon'             => 'th-list',
                'libelle'          => _('Datatable'),
                'extended_libelle' => _('List of %s'),
                'position'         => 0,
                'action'           => 'getIndex'
            ],
            'Distilleries\Expendable\Contracts\FormStateContract'      => [
                'color'            => 'bg-yellow',
                'icon'             => 'pencil',
                'libelle'          => _('Add'),
                'extended_libelle' => _('Detail of %s'),
                'position'         => 2,
                'action'           => 'getEdit'
            ],
            'Distilleries\Expendable\Contracts\ExportStateContract'    => [
                'color'            => 'bg-blue-hoki',
                'icon'             => 'save-file',
                'libelle'          => _('Export'),
                'extended_libelle' => _('Chose date to export %s'),
                'position'         => 1,
                'action'           => 'getExport'
            ]
        ]
    ];
```