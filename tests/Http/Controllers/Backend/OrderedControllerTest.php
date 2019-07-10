<?php

class OrderedControllerTest extends ExpendableTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database'=>'testbench',
            '--path'=>[realpath(__DIR__ . '/../../../data/migrations')],
            '--realpath'=>true
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
        $response = $this->call('GET', action('\OrderedController@getOrder'));

        $this->assertResponseOk();
        $this->assertContains(trans('expendable::datatable.order'), $response->getContent());
        $this->assertContains('foo', $response->getContent());
        $this->assertContains('bar', $response->getContent());
        $this->assertContains('baz', $response->getContent());
    }

    public function testPostOrder()
    {
        $orderField = (new \Ordered)->orderFieldName();
        $before = \Ordered::orderBy($orderField, 'asc')->get();

        \Route::post('/admin/ordered/order', '\OrderedController@postOrder');
        $this->call('POST', action('\OrderedController@postOrder'), ['ids' => [2, 1, 3]]);

        $after = \Ordered::orderBy($orderField, 'asc')->get();

        $this->assertResponseOk();
        $this->assertNotEquals($before, $after);
        $this->assertEquals(2, \Ordered::find(1)->{$orderField});
        $this->assertEquals(1, \Ordered::find(2)->{$orderField});
        $this->assertEquals(3, \Ordered::find(3)->{$orderField});
    }
}

class OrderedController extends \Distilleries\Expendable\Http\Controllers\Backend\Base\ModelBaseController implements \Distilleries\Expendable\Contracts\OrderStateContract
{
    use \Distilleries\Expendable\States\OrderStateTrait;

    public function __construct(Ordered $model, \Distilleries\Expendable\Contracts\LayoutManagerContract $layoutManager)
    {
        parent::__construct($model, $layoutManager);
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
