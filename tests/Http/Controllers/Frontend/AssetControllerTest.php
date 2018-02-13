<?php

class AssetControllerTest extends ExpendableTestCase
{

    protected $controller = 'Frontend\AssetController';


    public function testAssetNotFound()
    {
        $this->disableExceptionHandling();

        try {
            $response = $this->call('GET', 'storage/moximanager/' . rand());
            $this->assertEquals(404, $response->getStatusCode());

        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            $this->assertTrue(true);
        }

    }

    public function testAssetNotAllowed()
    {
        $this->disableExceptionHandling();

        \File::makeDirectory(storage_path('other'), 0755, false, true);
        copy(realpath(__DIR__ . '/../../../data/5601729.gif'), storage_path('other/5601729.gif'));

        try {
            $response = $this->call('GET', 'storage/other/5601729.gif');
            $this->assertEquals(404, $response->getStatusCode());

        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            $this->assertTrue(true);
        }

    }

    public function testAssetFound()
    {
        \File::makeDirectory(storage_path('moximanager'), 0755, false, true);

        copy(realpath(__DIR__ . '/../../../data/exports/2015-03-17 2015-03-19.csv'), storage_path('moximanager/2015-03-172015-03-19.csv'));
        $response = $this->call('GET', 'storage/moximanager/2015-03-172015-03-19.csv');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAssetImageFound()
    {
        \File::makeDirectory(storage_path('moximanager'), 0755, false, true);

        copy(realpath(__DIR__ . '/../../../data/5601729.gif'), storage_path('moximanager/5601729.gif'));
        $response = $this->call('GET', 'storage/moximanager/5601729.gif');
        $this->assertEquals(200, $response->getStatusCode());
    }
}