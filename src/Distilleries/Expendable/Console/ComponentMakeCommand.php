<?php namespace Distilleries\Expendable\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Distilleries\Expendable\Console\Lib\Generators\ComponentGenerator;

class ComponentMakeCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'component:make';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    protected $states;
    protected $model;
    protected $form;
    protected $datatable;
    protected $template;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a controller for a backend component builder class.';

    /**
     * @var FormGenerator
     */
    protected $formGenerator;

    public function __construct(Filesystem $files, ComponentGenerator $formGenerator)
    {
        parent::__construct();

        $this->files         = $files;
        $this->formGenerator = $formGenerator;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $path = $this->getNameInput();
        $this->initOptions();

        if ($this->files->exists($path))
        {
            return $this->error('Form already exists!');
        }


        $this->makeDirectory($path);

        $this->files->put($path . '.php', $this->buildClass($path));

        $this->info('Form created successfully.');
        $this->call('dump-autoload');
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path)))
        {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Build the controller class with the given name.
     *
     * @param  string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Full path for Form class.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('states', null, InputOption::VALUE_OPTIONAL, 'States use on the controller', ''),
            array('template', null, InputOption::VALUE_OPTIONAL, 'Template use to generate the controller', ''),
            array('model', null, InputOption::VALUE_OPTIONAL, 'Model use', ''),
            array('datatable', null, InputOption::VALUE_OPTIONAL, 'Datatable use', ''),
            array('form', null, InputOption::VALUE_OPTIONAL, 'Form Use', ''),

        );
    }

    protected function initOptions()
    {
        $states = $this->option('states');
        if (!empty($states))
        {
            $this->states = explode(',', $states);
        }

        $this->template  = $this->option('template');
        $this->model     = $this->option('model');
        $this->datatable = $this->option('datatable');
        $this->form      = $this->option('form');

    }


    protected function getTemplate()
    {

        if (empty($this->template))
        {
            $defaultComponent = 0;
            foreach ($this->states as $state)
            {
                if (strpos($state, 'DatatableStateContract') !== false or (strpos($state, 'FormStateContract') !== false))
                {
                    $defaultComponent ++;

                }
            }

            if ($defaultComponent == 2)
            {
                $template = 'controller-base-component-class-template';
            } else if (!empty($this->model))
            {
                $template = 'controller-base-model-class-template';
            } else
            {
                $template = 'controller-base-class-template';
            }

            return $template;
        }

        return $this->template;

    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $formGenerator = $this->formGenerator;

        $stub = str_replace(
            '{{class}}',
            $formGenerator->getClassInfo($name)->className,
            $stub
        );

        $stub = str_replace(
            '{{model}}',
            $formGenerator->getClassModel($this->model),
            $stub
        );

        $stub = str_replace(
            '{{datatable}}',
            $this->datatable,
            $stub
        );


        $stub = str_replace(
            '{{trait}}',
            $formGenerator->getTrait($this->states),
            $stub
        );

        $stub = str_replace(
            '{{implement}}',
            $formGenerator->getImplementation($this->states),
            $stub
        );

        $stub = str_replace(
            '{{form}}',
            $this->form,
            $stub
        );

        return $stub;
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            '{{namespace}}',
            $this->formGenerator->getClassInfo($name)->namespace,
            $stub
        );

        return $this;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return $this->argument('name');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/Lib/stubs/' . $this->getTemplate() . '.stub';
    }
}
