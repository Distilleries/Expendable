<?php

class OrderedControllerTest extends ExpendableTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__ . '/../../../data/migrations'),
        ]);

        \Ordered::create([
            'label' => 'foo',
            'order' => 1,
        ]);
        \Ordered::create([
            'label' => 'bar',
            'order' => 2,
        ]);
        \Ordered::create([
            'label' => 'baz',
            'order' => 3,
        ]);

        \Distilleries\Expendable\Models\Role::create([
            'libelle' => 'admin',
            'initials' => '@a',
            'overide_permission' => true,
        ]);

        \Distilleries\Expendable\Models\Service::create([
            'action' => 'test',
        ]);

        $faker = \Faker\Factory::create();
        $email = $faker->email;
        $user = \Distilleries\Expendable\Models\User::create([
            'email' => $email,
            'password' => \Hash::make('test'),
            'status' => true,
            'role_id' => 1,
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id' => 1,
            'service_id' => 1,
        ]);

        $this->be($user);
    }

    public function testGetOrder()
    {
        \Route::get('/admin/ordered/order', '\OrderedController@getOrder');
        \Route::post('/admin/ordered/order', '\OrderedController@postOrder');

        $response = $this->call('GET', action('\OrderedController@getOrder'));

        $this->assertResponseOk();
        $this->assertContains(trans('expendable::datatable.order'), $response->getContent());
    }
}

class OrderedController extends \Distilleries\Expendable\Http\Controllers\Admin\Base\ModelBaseController implements \Distilleries\Expendable\Contracts\OrderStateContract
{
    use \Distilleries\Expendable\States\OrderStateTrait;
    
    protected $model;

    public function __construct(Ordered $model, \Distilleries\Expendable\Contracts\LayoutManagerContract $layoutManager)
    {
        parent::__construct($model, $layoutManager);

        $this->model = $model;
    }
}

class Ordered extends \Distilleries\Expendable\Models\BaseModel implements \Distilleries\Expendable\Contracts\OrderContract
{
    public $table = 'ordered';

    protected $fillable = [
        'label',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function orderLabel()
    {
        return $this->label;
    }

    public function orderFieldName()
    {
        return 'order';
    }
}
