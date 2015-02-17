#Expendable

Expendable is a cms base on laravel 4.*.
This package give you some implementation do add a content management system of your application.
You can override everything. This Cms give view few tools to develop your content management easily and properly.

If you want install a fresh install of laravel 4 with Expendable package configured and gulp, bower structure go in (https://github.com/Distilleries/Xyz)[https://github.com/Distilleries/Xyz].

## Table of contents

## Require
To use this project you have to install:

1. Php 5.5 or more
2. Active the gettext extension
3. Active mpcrypt
4. Composer (https://getcomposer.org/download/)[https://getcomposer.org/download/]
5. Sass (`gem install sass`)
6. NodeJs version 0.10.33
7. gulp in general (npm install gulp -g)

##Installation

Add on your composer.json

``` json
    "require": {
        "distilleries/expendable": "1.*",
    }
```

run `composer update`.

Add Service provider to `config/app.php`:

``` php
    'providers' => [
        // ...
       'Netson\L4gettext\L4gettextServiceProvider',
       'Chumper\Datatable\DatatableServiceProvider',
       "Ollieread\Multiauth\MultiauthServiceProvider",
       "Ollieread\Multiauth\Reminders\ReminderServiceProvider",
       'Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider',
       'Wpb\StringBladeCompiler\StringBladeCompilerServiceProvider',
       'mnshankar\CSV\CSVServiceProvider',
       'Maatwebsite\Excel\ExcelServiceProvider',
       'Distilleries\DatatableBuilder\DatatableBuilderServiceProvider',
       'Distilleries\FormBuilder\FormBuilderServiceProvider',
       'Distilleries\Expendable\ExpendableServiceProvider',
       'Distilleries\MailerSaver\MailerSaverServiceProvider',
    ]
```

And Facade (also in `config/app.php`) replace the laravel facade `Mail`
   

``` php
    'aliases' => [
        // ...
       'Mail'              => 'Distilleries\MailerSaver\Facades\Mail',
       'Datatable'         => 'Distilleries\DatatableBuilder\Facades\DatatableBuilder',
       'FormBuilder'       => 'Distilleries\FormBuilder\Facades\FormBuilder',
       'Gravatar'          => 'Thomaswelton\LaravelGravatar\Facades\Gravatar',
       'CSV'               => 'mnshankar\CSV\CSVFacade',
       'Excel'             => 'Maatwebsite\Excel\Facades\Excel',
    ]
```

**Replace the service old facade Mail by the new one.**
    

##Configurations

```ssh
php artisan config:publish distilleries/expendable
```

```php
    return [
          'login_uri'           => 'admin/login',
          'admin_base_uri'      => 'admin',
          'config_file_assets'  => base_path() . '/package.json',
          'folder_whitelist'   => [
              'moximanager'
          ],
          'listener'            => [
              '\Distilleries\Expendable\Listeners\UserListener'
          ],
          'mail'                => [
              "actions"  => [
                  'emails.auth.reminder'
              ]
          ],
          'menu'                => \Distilleries\Expendable\Config\MenuConfig::menu([], 'beginning'),
          'menu_left_collapsed' => false,
          'state'               => [
              'Distilleries\Expendable\Contracts\DatatableStateContract' => [
                  'color'            => 'bg-green-haze',
                  'icon'             => 'th-list',
                  'libelle'          => _('Datatable'),
                  'extended_libelle' => _('List of %s'),
                  'position'         => 0,
                  'action'           => 'getIndex'
              ],
              'Distilleries\Expendable\Contracts\ExportStateContract'    => [
                  'color'            => 'bg-blue-hoki',
                  'icon'             => 'save-file',
                  'libelle'          => _('Export'),
                  'extended_libelle' => _('Chose date to export %s'),
                  'position'         => 1,
                  'action'           => 'getExport'
              ],
              'Distilleries\Expendable\Contracts\ImportStateContract'    => [
                  'color'            => 'bg-red-sunglo',
                  'icon'             => 'open-file',
                  'libelle'          => _('Import'),
                  'extended_libelle' => _('Upload a file to import %s'),
                  'position'         => 2,
                  'action'           => 'getImport'
              ],
              'Distilleries\Expendable\Contracts\FormStateContract'      => [
                  'color'            => 'bg-yellow',
                  'icon'             => 'pencil',
                  'libelle'          => _('Add'),
                  'extended_libelle' => _('Detail of %s'),
                  'position'         => 3,
                  'action'           => 'getEdit'
              ],
          ]
      ];
```

Field | Usage
----- | -----
login_uri | Uri to access of the login page by default `admin/login`.
admin_base_uri | base of the admin uri `admin` by default.
config_file_assets| File loaded to get the version number of the application. This version number is use to add it of the generated css and javascript to force the reload when you deploy your application.
folder_whitelist | Table of folders accessible to display the assets.
listener | Table of class autoloaded to listen a custom event.
mail.actions | List of action available to send an email. This list is display in email module backend.
menu | Use the method \Distilleries\Expendable\Config\MenuConfig::menu() to merge the default menu with your menu. In the table you can define left key or tasks to display in menu left or in the menu task.
menu_left_collapsed | Set to tru to keep close the menu left. By default it set to false and the menu is open.
state | List of state available, with the color, the logo and the name.


###Menu
I use a function to easily merge the default component with the component of the application.

By default you can find on the menu left:

1.  Email
    1. List of email
    2. Add email
2.  User
    1. List of user
    2. Add user
3.  Role
    1. List of role
    2. Add role
4.  Permission
    1. Associate permission
    2. List of service
    3. Add service
    4. Synchronize all services
5.  Language
    1. List of language
    2. Add language

By default you can find on the menu task:

1.  Generate a new component
2.  Synchronize all services


To add a new item it's easy

```php
        'menu'               => \Distilleries\Expendable\Config\MenuConfig::menu([
                'left' => [
                    [
                        'icon'    => 'send',
                        'action'  => 'Admin\ContactController@getIndex',
                        'libelle' => _('Contact'),
                        'submenu' => [
                            [
                                'icon'    => 'th-list',
                                'libelle' => _('List of Contact'),
                                'action'  => 'Admin\ContactController@getIndex',
                            ],
                            [
                                'icon'    => 'pencil',
                                'libelle' => _('Add Contact'),
                                'action'  => 'Admin\ContactController@getEdit',
                            ]
                        ]
                    ],
                ],
    
                'tasks' => [
                    [
                        'icon'    => 'console',
                        'action'  => 'Admin\TestController@getIndex',
                        'libelle' => _('Test'),
    
                    ],
                ]
            ], 'beginning'),
```

Option | Description
------ | -----------
icon | Name of the icon class [http://getbootstrap.com/components/#glyphicons](http://getbootstrap.com/components/#glyphicons)
action | Action call when you click ( use action helper to generate the url)
libelle | Translation of your menu item
submenu | If you want add sub-item you can add an array with the same options


The method `\Distilleries\Expendable\Config\MenuConfig::menu` tak two parameters

1. An array with the content of the meny `['left'=>[],'tasks'=>[]]` 
2. The second one is a string `beginning` or `end` to define the direction of the merge.

Example of menu left:

![menu_left](http://distilleri.es/markdown/expendable/_images/menu_left.png)

Example of menu task:

![tasks](http://distilleri.es/markdown/expendable/_images/tasks.png)


###State
A state is a part of your controller where you define a list of actions.
By default I implemented four states:

1. Datatable
2. Export
3. Import
4. Form


####1. Datatable

![datatable](http://distilleri.es/markdown/expendable/_images/states.png)

A datatable state it's use to display a list of content with filter if you need it.
To use it you have to implement the interface `Distilleries\Expendable\Contracts\DatatableStateContract`.

```php
  public function getIndexDatatable();
  public function getDatatable();
```

* `getIndexDatatable` it's form initilize the datatable.
* `getDatatable` it's for get the data in json.

You can use the trait :

```php
use \Distilleries\Expendable\States\DatatableStateTrait;
```

On this trait you have a generic implementation to display the datatable and the data.
This trait need to use two attributes of your controller:

1. `$datatable`, it's an instance of `EloquentDatatable` (come from [DatatableBuilder](https://github.com/Distilleries/DatatableBuilder)).
2. `model`, it's and instance of `Eloquant` (come from laravel).

Inject them on your constructor:

```php
    public function __construct(\Address $model, AddressDatatable $datatable)
    {
        $this->datatable  = $datatable;
        $this->model      = $model;
    }
```
    

####2. Export

![export](http://distilleri.es/markdown/expendable/_images/export.png)

An export state it's to export the data from your model between two dates.
To use it you have to implement the interface `Distilleries\Expendable\Contracts\ExportStateContract`.

```php
     public function getExport();
     public function postExport();
```

* `getExport` it's to display the form to select the dates and the type of export.
* `postExport` proceed the export and return the file.

You can use the trait :

```php
use \Distilleries\Expendable\States\ExportStateTrait;
```

On this trait you have a generic implementation to export your data.
This trait need to use on attribute of your controller:

1. `model`, it's and instance of `Eloquant` (come from laravel).

Inject them on your constructor:

```php
    public function __construct(\Address $model)
    {
        $this->model      = $model;
    }
```

You can change the class provide to export the data. Just add those methods on your service provider and change the class instantiated.

```php
    $this->app->singleton('Distilleries\Expendable\Contracts\CsvExporterContract', function ($app)
    {
        return new CsvExporter;
    });
    $this->app->singleton('Distilleries\Expendable\Contracts\ExcelExporterContract', function ($app)
    {
        return new ExcelExporter;
    });
    $this->app->singleton('Distilleries\Expendable\Contracts\PdfExporterContract', function ($app)
    {
        return new PdfExporter;
    });
```


####3. Import

![import](http://distilleri.es/markdown/expendable/_images/import.png)

An import state it's to import the data from a file to your model.
To use it you have to implement the interface `Distilleries\Expendable\Contracts\ImportStateContract`.

```php
     public function getImport();
     public function postImport();
```

* `getImport` it's to display the form give the file.
* `postImport` proceed the import and return back.

You can use the trait :

```php
use \Distilleries\Expendable\States\ImportStateTrait;
```

On this trait you have a generic implementation to export your data.
This trait need to use on attribute of your controller:

1. `model`, it's and instance of `Eloquant` (come from laravel).

Inject them on your constructor:

```php
    public function __construct(\Address $model)
    {
        $this->model      = $model;
    }
```


You can change the class provide to import the data. Just add those methods on your service provider and change the class instantiated.

```php
    $this->app->singleton('CsvImporterContract', function ($app)
    {
        return new CsvImporter;
    });
    
    $this->app->singleton('XlsImporterContract', function ($app)
    {
        return new XlsImporter;
    });
    
    $this->app->singleton('XlsxImporterContract', function ($app)
    {
        return new XlsImporter;
    });
```

####4. Form


![form](http://distilleri.es/markdown/expendable/_images/form.png)


##Permissions


##Views
@todo

##Assets (CSS and Javascript)
@todo

##Create a new backend module
@todo

##Case studies
@todo