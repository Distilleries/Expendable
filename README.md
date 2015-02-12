#Exependable

##Installation

```
    "distilleries/expendable": "1.*",
    
```

## Add service providers

In you app.php config file add in `providers` table:

```php

    'Chumper\Datatable\DatatableServiceProvider',
    'Distilleries\DatatableBuilder\DatatableBuilderServiceProvider',
    'Distilleries\FormBuilder\FormBuilderServiceProvider',
    'Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider',
    'Wpb\StringBladeCompiler\StringBladeCompilerServiceProvider',
    'Distilleries\Expendable\ExpendableServiceProvider',
    'Distilleries\Expendable\MailServiceProvider',
    'mnshankar\CSV\CSVServiceProvider',
    'Maatwebsite\Excel\ExcelServiceProvider',

In the `aliases` table:

```php

    'Mail'              => 'Distilleries\Expendable\Facades\Mail',
    'Datatable'         => 'Distilleries\DatatableBuilder\Facades\DatatableBuilder',
    'Gravatar'          => 'Thomaswelton\LaravelGravatar\Facades\Gravatar',
    'FormBuilder'       => 'Distilleries\FormBuilder\Facades\FormBuilder',
```
    
**Replace the service old facade Mail by the new one.**
    

##Configurations

```
    php artisan config:publish distilleries/expendable
    
```