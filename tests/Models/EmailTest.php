<?php

class EmailTest extends ExpendableTestCase {


    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../../vendor/distilleries/mailersaver/src/database/migrations'),
        ]);

    }

    protected function addContent()
    {

        $faker = Faker\Factory::create();
        $data  = [
            'libelle'   => $faker->realText(20),
            'body_type' => \Distilleries\Expendable\Helpers\StaticLabel::BODY_TYPE_HTML,
            'action'    => uniqid(),
            'cc'        => $faker->email,
            'bcc'       => $faker->email,
            'content'   => $faker->text(),
            'status'    => \Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE,
        ];


        $result = \Distilleries\Expendable\Models\Email::create($data);

        \Distilleries\Expendable\Models\Translation::create([
            'id_element' => $result->id,
            'model'      => $result->getTable(),
            'id_source'  => 0,
            'iso'        => app()->getLocale(),
        ]);


        $result = \Distilleries\Expendable\Models\Email::find($result->id);

        return [$data, $result];
    }

    public function testInitByTemplate()
    {
        list($data, $model) = $this->addContent();

        $email = new \Distilleries\Expendable\Models\Email;
        $email = $email->initByTemplate($data['action'])->get()->last();
        $this->assertEquals($model, $email);

    }

    public function testGetTemplate()
    {
        list($data, $model) = $this->addContent();

        $email   = new \Distilleries\Expendable\Models\Email;
        $email   = $email->initByTemplate($data['action'])->get()->last();
        $content = $email->getTemplate('');
        $this->assertEquals($data['content'], $content);

    }

    public function testGetTemplateEmpty()
    {
        list($data, $model) = $this->addContent();

        $email   = new \Distilleries\Expendable\Models\Email;
        $content = $email->getTemplate('');
        $this->assertEquals('', $content);
    }


    public function testGetBcc()
    {
        list($data, $model) = $this->addContent();

        $email   = new \Distilleries\Expendable\Models\Email;
        $email   = $email->initByTemplate($data['action'])->get()->last();
        $content = $email->getBcc();
        $this->assertTrue(in_array($data['bcc'],$content));

    }


    public function testGetBccEmpty()
    {
        $email   = new \Distilleries\Expendable\Models\Email;
        $content = $email->getBcc();
        $this->assertTrue(is_array($content));
        $this->assertTrue(empty($content));
    }

    public function testGetSubject()
    {
        list($data, $model) = $this->addContent();

        $email   = new \Distilleries\Expendable\Models\Email;
        $email   = $email->initByTemplate($data['action'])->get()->last();
        $content = $email->getSubject();
        $this->assertEquals($data['libelle'],$content);

    }

    public function testGetSubjectEmpty()
    {
        $email   = new \Distilleries\Expendable\Models\Email;
        $content = $email->getSubject();
        $this->assertTrue(empty($content));
    }

    public function testGetCc()
    {
        list($data, $model) = $this->addContent();

        $email   = new \Distilleries\Expendable\Models\Email;
        $email   = $email->initByTemplate($data['action'])->get()->last();
        $content = $email->getCc();
        $this->assertTrue(in_array($data['cc'],$content));

    }

    public function testGetCcEmpty()
    {
        $email   = new \Distilleries\Expendable\Models\Email;
        $content = $email->getCc();
        $this->assertTrue(is_array($content));
        $this->assertTrue(empty($content));
    }

    public function testGetPlain()
    {
        list($data, $model) = $this->addContent();

        $email   = new \Distilleries\Expendable\Models\Email;
        $email   = $email->initByTemplate($data['action'])->get()->last();
        $content = $email->getPlain();
        $this->assertEquals($data['body_type'],$content);

    }

    public function testGetPlainEmpty()
    {
        $email   = new \Distilleries\Expendable\Models\Email;
        $content = $email->getPlain();
        $this->assertTrue(empty($content));
    }
}