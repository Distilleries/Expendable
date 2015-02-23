<?php namespace Distilleries\Expendable\Contracts;

interface LayoutManagerContract {

    public function setupLayout($layout);

    public function initStaticPart(\Closure $closure = null);

    public function initInterfaces(array $interfaces, $class);

    public function add(array $items);

    public function render();

    public function getConfig();

    public function getView();

    public function getState();

    public function getFilesystem();
}