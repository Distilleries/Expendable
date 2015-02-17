#Expendable

Expendable is a cms base on laravel 4.*.
This package give you some implementation do add a content management system of your application.
You can override everything. This Cms give view few tools to develop your content management easily and properly.

If you want install a fresh install of laravel 4 with Expendable package configured and gulp, bower structure go in (https://github.com/Distilleries/Xyz)[https://github.com/Distilleries/Xyz].

## Table of contents
1. [Require](#require)
1. [Installation](#installation)
1. [Configurations](#configurations)
1. [Menu](#menu)
1. [State](#state)
    1. [Datatable](#1-datatable)
    1. [Export](#2-export)
    1. [Import](#3-import)
    1. [Form](#4-form)
    1. [Form](#4-form)
1. [Component](#component)
    1. [AdminBaseComponent](#adminbasecomponent)
    1. [AdminModelBaseController](#adminmodelbasecontroller)
    1. [AdminBaseController](#adminbasecontroller)
1. [Model](#model)
1. [Global scope](#global-scope)
    1. [Status](#status)
1. [Permissions](#permissions)
1. [Views](#views)
1. [Assets (CSS and Javascript)](#assets-css-and-javascript)
    1. [Sass](#sass)
    1. [Images](#images)
    1. [Javascript](#javascript)
    1. [Gulp](#gulp)
1. [Create a new backend module](#create-a-new-backend-module)
1. [Case studies](#case-studies)
    1. [Generate your migration](#1-generate-your-migration)
    1. [Generate your model](#2-generate-your-model)
    1. [Generate you component](#3-generate-you-component)
    1. [Add your controller in the routes file](#4-add-your-controller-in-the-routes-file)
    1. [Add to the menu](#5-add-to-the-menu)

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

To display the menu of state I provide a class for the interface `Distilleries\Expendable\Contracts\StateDisplayerContract`.
 
```php
 	$this->app->singleton('Distilleries\Expendable\Contracts\StateDisplayerContract', function ($app)
    {
        return new StateDisplayer($app['view'],$app['config']);
    });
```

This class check the interface use on your controller and with the config `exependable::state` display the logo and the name of the state.
If you want change the state display, just provide a new class for the contract `Distilleries\Expendable\Contracts\StateDisplayerContract`.


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

The form state give you a part to add or edit an element and a part to view the element without edit.


To use it you have to implement the interface `Distilleries\Expendable\Contracts\FormStateContract`.

```php
    public function getEdit($id);
    public function postEdit();
    public function getView($id);
```

* `getEdit` it's to display the form to edit or add new item.
* `postEdit` proceed the save or update.
* `getView` Display the form in not editable.

You can use the trait :

```php
use \Distilleries\Expendable\States\FormStateTrait;
```

On this trait you have a generic implementation to display form, save and display view.
This trait need to use two attributes of your controller:

1. `model`, it's and instance of `Eloquant` (come from laravel).
1. `form`, it's and instance of `Form` (come from [FormBuilder](https://github.com/Distilleries/FormBuilder)).

Inject them on your constructor:

```php
     public function __construct(\Address $model, AddressForm $form)
    {
        $this->form      = $form;
        $this->model     = $model;
    }
```

##Component
A component is just a composition of controller, form, datatable, model.
To create a new component you can go in `/admin/component/edit` and fill the form, or use the command line:

```ssh
php artisan expendable:component.make app/controllers/Admin/TestController
```
You can check the options with the help.

In the backend you have all this options:

Field | Description
----- | -----------
Name | The name use to generate the controllers and other classes (ex: Address, AddressController, AddressForm, AddressDatatable).
State | The state you want use on your controller
Model | The model inject on your controller
Path repository | Fill it if you want put your class on specific folder (ex: Project, that generate the classes on the folder app/Project).
Columns | List of columns display on the datatable
Fields | The field you want in your form (name:type ex: id:hidden, libelle:text...)

To know all the types of fields you can [have look the documentation](https://github.com/Distilleries/FormBuilder#list-of-fields).

![component](http://distilleri.es/markdown/expendable/_images/component.png)


###AdminBaseComponent
By default if you check all the state that generate a controller inheritance from `Distilleries\Expendable\Controllers\AdminBaseComponent`.
This controller implement all the states interfaces.


```php
use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Controllers\AdminBaseComponent;
use Scolicare\Datatables\CityDatatable;
use Scolicare\Forms\CityForm;


class CityController extends AdminBaseComponent {

    public function __construct(\City $model, StateDisplayerContract $stateProvider, CityDatatable $datatable, CityForm $form)
    {
        parent::__construct($model, $stateProvider);
        $this->datatable = $datatable;
        $this->form      = $form;
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

}
```

###AdminModelBaseController
If you don't want use all the state and you use a model just extend `Distilleries\Expendable\Controllers\AdminModelBaseController`.

Example:

```php
    namespace Distilleries\Expendable\Controllers\Admin;
    
    
    use Distilleries\Expendable\Contracts\FormStateContract;
    use Distilleries\Expendable\Contracts\StateDisplayerContract;
    use Distilleries\Expendable\Controllers\AdminModelBaseController;
    use Distilleries\Expendable\Forms\Permission\PermissionForm;
    use Distilleries\Expendable\States\FormStateTrait;
    
    class PermissionController extends AdminModelBaseController implements FormStateContract {
    
        use FormStateTrait;
    
    
        public function __construct(Permission $model, StateDisplayerContract $stateProvider, PermissionForm $form)
        {
            parent::__construct($model, $stateProvider);
            $this->form = $form;
        }
    
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
    
    
    }
```

###AdminBaseController
If you don't want use all the state and you don't use a model just extend `Distilleries\Expendable\Controllers\AdminBaseController`.
You just have to inject the `StateDisplayerContract`

Example:

```php
    namespace Distilleries\Expendable\Controllers\Admin;
    
    use Distilleries\Expendable\Contracts\StateDisplayerContract;
    use Distilleries\Expendable\Controllers\AdminModelBaseController;
    
    
    class PermissionController extends AdminBaseController{
  
        public function __construct(StateDisplayerContract $stateProvider)
        {
            parent::__construct($stateProvider);
        }
    
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------------------
    
    
    }
```

##Model
By default you can extend `\Distilleries\Expendable\Models\BaseModel`, this one extend `\Eloquent`.
On it you have some method you can use:

```php
    public function getFillable();
    public static function getChoice();
    public function scopeSearch($query, $searchQuery);
    public function getAllColumnsNames();
    public function scopeBetweenCreate($query, $start, $end);
    public function scopeBetweenupdate($query, $start, $end);
```

Method | Detail
------ | ------
getFillable | Return the table of fillable field
getChoice   | Return a table with in key the id and the value the libelle
scopeSearch | Query scope to search in all columns
getAllColumnsNames | Get all the columns of your table
scopeBetweenCreate | Query scope to get all the element between to date by the field created_at
scopeBetweenupdate | Query scope to get all the element between to date by the field created_at

##Global scope
I provide some global scope usable on the model.


###Status
If you want display an element only if your are connected use this scope.
The model check if the user is not connected and if the status equal online (1).


To use it add the trait on your model `use \Distilleries\Expendable\Models\StatusTrait;`

##Permissions
The system of permission is base on the public method of all your controller.
To generate the list of all services use the `Synchronize all services` (`/admin/service/synchronize`).
That use all the controller and get the public actions.

If you go on `Associate Permission` you have the list of controller with all methods:

![services](http://distilleri.es/markdown/expendable/_images/services.png)

On this page you can allow a role to the method. 
If the role is not allowed the application dispatch an error:

```php
App::abort(403, Lang::get('expendable::errors.unthorized'));
```
That is done in `auth.anthorized` filter. You can override the permission in role to allow automatically all the services.
It's use for the developer to develop the application easily.

You can use `UserUtils` to check the permission and display an element or not.
To display the remove  button on the datatable the user need `putDestroy` action allowed.

```php
\Distilleries\Expendable\Helpers\UserUtils::hasAccess('Admin\RoleController@putDestroy'))
```

##Views

To override the view publish them with command line: 

```ssh
php artisan view:publish distilleries/expendable
```

##Assets (CSS and Javascript)
All the assets are one the folder `assets`.

###Sass
To use the sass file just add bootstrap and  `application.admin.scss` on your admin file scss.
If you check the repo [Xyz](https://github.com/Distilleries/Xyz/tree/master/app/assets) you have a folder assets.
I use the same structure.

```scss
@import "../../../../bower_components/bootstrap-sass/assets/stylesheets/_bootstrap-sprockets";
@import "../../../../bower_components/bootstrap-sass/assets/stylesheets/_bootstrap";

@font-face {
  font-family: 'Glyphicons Halflings';
  src: url("../fonts/glyphicons-halflings-regular.eot");
  src: url("../fonts/glyphicons-halflings-regular.eot?#iefix") format("embedded-opentype"), url("../fonts/glyphicons-halflings-regular.woff") format("woff"), url("../fonts/glyphicons-halflings-regular.ttf") format("truetype"), url("../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular") format("svg");
}

@font-face {
  font-family: 'FontAwesome';
  src: url("../fonts/fontawesome-webfont.eot");
  src: url("../fonts/fontawesome-webfont.eot?#iefix") format("embedded-opentype"), url("../fonts/fontawesome-webfont.woff") format("woff"), url("../fonts/fontawesome-webfont.ttf") format("truetype"), url("../fonts/fontawesome-webfont.svg#glyphicons_halflingsregular") format("svg");
}

@import "../../../../vendor/distilleries/expendable/assets/admin/sass/application.admin";
@import "../../../../vendor/distilleries/expendable/assets/admin/sass/admin/layout/themes/grey";
```

###Images
The images are copy by the gulp file.

###Javascript
The javascript is compiled by the gulp file.


###Gulp

* Copy the gulp.js from this link [https://github.com/Distilleries/Xyz/blob/master/gulpfile.js](https://github.com/Distilleries/Xyz/blob/master/gulpfile.js).
* Copy the config file `build.config.js` from this link [https://github.com/Distilleries/Xyz/blob/master/build.config.js](https://github.com/Distilleries/Xyz/blob/master/build.config.js).
* Copy the file package.json from this link [https://github.com/Distilleries/Xyz/blob/master/package.json](https://github.com/Distilleries/Xyz/blob/master/package.json).
* Copy the file bower.json from this link [https://github.com/Distilleries/Xyz/blob/master/bower.json](https://github.com/Distilleries/Xyz/blob/master/bower.json).

First thing run the command npm:

```ssh
npm install
```

When everything is installed you can run gulp:

```ssh
gulp
```

Task | Description
---- | -----------
bower | To load your bower dependencies
css | To generate the sass and compile with the css files
fonts | Copy the fonts the assets folder
tinymce | Copy the skin of tinymce
styles | Call css and after in asynchrone fonts and tinymce tasks
scripts | Compile the javascript files 
images | Cp[y and optimize the pictures
clean | Remove the asset folder generated
watch | Watcher to compile the css, javascript, sass, images when you change something
patch | Generate a tag like x.x.1 and increment the version of your composer.json, bower.json, package.json 
feature | Generate a tag like x.1.x and increment the version of your composer.json, bower.json, package.json 
release | Generate a tag like 1.x.x and increment the version of your composer.json, bower.json, package.json 
default | Start the tasks clean, bower and after styles, scripts, images in asynchrone. 


##Create a new backend module

1. Generate your migration.
2. Generate your model.
3. Generate you component.
4. Add your controller in the routes file.


##Case studies
Try to create a blog post component. I use a fresh install of [Xyz](https://github.com/Distilleries/Xyz)

###1 Generate your migration

```ssh
php artisan generate:migration create_posts_table --fields="libelle:string, content:text, status:t inyInteger"
```


```ssh
php artisan migrate
```


###2 Generate your model

```php
<?php

class Post extends \Distilleries\Expendable\Models\BaseModel {

	use \Distilleries\Expendable\Models\StatusTrait;
	
	protected $fillable = [
		'id',
		'libelle',
		'content',
		'status',
	];
}
```

###3 Generate you component
I use the backend generator `/admin/component/edit`.


![studies](http://distilleri.es/markdown/expendable/_images/studies.png)



Datatable:

```php
<?php namespace Xyz\Datatables;

use Distilleries\DatatableBuilder\EloquentDatatable;

class PostDatatable extends EloquentDatatable
{
    public function build()
    {
        $this
            ->add('id',null,_('Id'))
            ->add('libelle',null,_('Libelle'));

        $this->addDefaultAction();

    }
}
```

Form:

This file is generated:

```php
<?php namespace Xyz\Forms;

use Distilleries\FormBuilder\FormValidator;

class PostForm extends FormValidator
{
    public static $rules        = [];
    public static $rules_update = null;

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('libelle', 'text')
            ->add('content', 'tinymce')
            ->add('status', 'choice');

         $this->addDefaultActions();
    }
}
```

You have to update it for give a value for the choice and give the rules for the validation:

```php
<?php namespace Xyz\Forms;

use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\FormBuilder\FormValidator;

class PostForm extends FormValidator
{
    public static $rules = [
        'libelle' => 'required',
        'status'  => 'required|integer'
    ];
    public static $rules_update = null;

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('libelle', 'text',[
                'validation'  => 'required',
                'label'       => _('Title')
            ])
            ->add('content', 'tinymce')
            ->add('status', 'choice', [
                'choices'     => StaticLabel::status(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Status')
            ]);


        $this->addDefaultActions();
    }
}
```

Controller:

```php
<?php namespace Admin;

use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Controllers\AdminBaseComponent;


class PostController extends AdminBaseComponent {

    public function __construct(\Post $model, StateDisplayerContract $stateProvider, \Xyz\Datatables\PostDatatable $datatable, \Xyz\Forms\PostForm $form)
    {
        parent::__construct($model, $stateProvider);
        $this->datatable = $datatable;
        $this->form      = $form;
    }



    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


}
```


###4 Add your controller in the routes file
I add ` Route::controller('post', 'Admin\PostController');` on the route file:

```php
    <?php
    
    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It's a breeze. Simply tell Laravel the URIs it should respond to
    | and give it the Closure to execute when that URI is requested.
    |
    */
    
    
    Route::group(array('before' => 'admin.auth'), function ()
    {
    
        Route::group(array('before' => 'auth.anthorized', 'prefix' => Config::get('expendable::admin_base_uri')), function ()
        {
            Route::controller('post', 'Admin\PostController');
            Route::controller('country', 'Admin\CountryController');
        });
    });

```


###5 Add to the menu
If you are not generate the config do it right now:

```ssh
php artisan config:publish distilleries/expendable
```

On `app/config/packages/distilleries/expendable/config.php` id add the Post entry:

```php
        'menu'               => \Distilleries\Expendable\Config\MenuConfig::menu([
            'left' => [
                [
                    'icon'    => 'pushpin',
                    'action'  => 'Admin\PostController@getIndex',
                    'libelle' => _('Post'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of Post'),
                            'action'  => 'Admin\PostController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Post'),
                            'action'  => 'Admin\PostController@getEdit',
                        ]
                    ]
                ],
            ]
        ], 'beginning'),
```