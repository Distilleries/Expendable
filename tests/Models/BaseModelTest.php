<?php

class BaseModelTest extends ExpendableTestCase {


    protected function addContent()
    {
        $data  = [
            'libelle'     => 'English',
            'iso'         => 'en',
            'not_visible' => false,
            'is_default'  => false,
            'status'      => true

        ];

        $result = \Distilleries\Expendable\Models\Language::create($data);
        $result = \Distilleries\Expendable\Models\Language::find($result->id);

        return [$data, $result];
    }

    public function testGetChoice()
    {
        list($data, $model) = $this->addContent();

        $choice = $model->getChoice();

        $this->assertTrue(is_array($choice));
        $this->assertTrue(in_array($data['libelle'], $choice));
        $this->assertArrayHasKey($model->id, $choice);

    }

    public function testGetAllColumnsNames()
    {
        list($data, $model) = $this->addContent();

        $columns = $model->getAllColumnsNames();

        foreach ($data as $field => $value) {
            $this->assertContains($field, $columns);
        }
    }

    public function testScopeBetweenCreateWithResult()
    {
        list($data, $model) = $this->addContent();
        $start  = date('Y-m-d', time() - 86400);
        $end  = date('Y-m-d', time() + 86400);
        $choice = \Distilleries\Expendable\Models\Language::betweenCreate($start, $end)->get()->last();

        $this->assertTrue($choice->created_at >= $start && $choice->created_at <= $end);
    }

    public function testScopeBetweenCreateWithNoResult()
    {
        list($data, $model) = $this->addContent();
        $start  = date('Y-m-d', time() - 172800);
        $end  = date('Y-m-d', time() - 86400);
        $choice = \Distilleries\Expendable\Models\Language::betweenCreate($start, $end)->get()->last();

        $this->assertTrue(empty($choice));
    }


    public function testScopeBetweenUpdateWithResult()
    {
        list($data, $model) = $this->addContent();
        $start  = date('Y-m-d', time() - 86400);
        $end  = date('Y-m-d', time() + 86400);
        $choice = \Distilleries\Expendable\Models\Language::betweenUpdate($start, $end)->get()->last();

        $this->assertTrue($choice->updated_at >= $start && $choice->updated_at <= $end);
    }

    public function testScopeBetweenUpdateWithNoResult()
    {
        list($data, $model) = $this->addContent();

        $start  = date('Y-m-d', time() - 172800);
        $end  = date('Y-m-d', time() - 86400);
        $choice = \Distilleries\Expendable\Models\Language::betweenUpdate($start, $end)->get()->last();

        $this->assertTrue(empty($choice));
    }

    public function testScopeSearchWithResult()
    {
        list($data, $model) = $this->addContent();

        $result = \Distilleries\Expendable\Models\Language::search($data['libelle'])->get()->last();

        $this->assertTrue(!empty($result));
        $this->assertEquals($data['libelle'],$result->libelle);
    }


    public function testScopeSearchWithNoResult()
    {
        list($data, $model) = $this->addContent();

        $result = \Distilleries\Expendable\Models\Language::search(uniqid().uniqid().uniqid())->get()->last();
        
        $this->assertTrue(empty($result));
    }
}