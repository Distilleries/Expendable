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