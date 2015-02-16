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
@todo

###State
@todo

##Views
@todo

##Assets (CSS and Javascript)
@todo

##Create a new backend module
@todo

##Case studies
@todo