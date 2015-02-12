<?php

namespace Distilleries\Expendable\Controllers\Admin;

use Distilleries\Expendable\Controllers\AdminBaseController;
use Distilleries\Expendable\Controllers\AdminModelBaseController;
use Distilleries\Expendable\Events\UserEvent;
use Distilleries\Expendable\Formatter\Message;
use \View, \FormBuilder, \Password, \Input, \Redirect, \Auth, \Lang, \App, \File, \Config, \Hash;

class LoginController extends AdminModelBaseController {


    protected $layout = 'expendable::admin.layout.login';


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    public function getIndex()
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\SignIn', [
            'class' => 'login-form'
        ]);

        $content = View::make('expendable::admin.login.signin', [
            'form' => $form
        ]);

        $this->addToLayout('login', 'class_layout');
        $this->addToLayout($content, 'content');
    }

    // ------------------------------------------------------------------------------------------------

    public function postIndex()
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\SignIn');

        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $credential = Input::only('email', 'password');

        if (Auth::administrator()->attempt($credential, true))
        {
            new UserEvent(UserEvent::LOGIN_EVENT, Auth::administrator()->get());

            $menu = Config::get('expendable::menu');
            return Redirect::to(Auth::administrator()->get()->getFirstRedirect($menu['left']));
        } else
        {

            return Redirect::back()->with(Message::WARNING, [Lang::get('expendable::login.credential')]);
        }


    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getRemind()
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\Forgotten', [
            'class' => 'login-form'
        ]);

        $content = View::make('expendable::admin.login.forgot', [
            'form' => $form
        ]);

        $this->addToLayout('login', 'class_layout');
        $this->addToLayout($content, 'content');
    }

    // ------------------------------------------------------------------------------------------------

    public function postRemind()
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\Forgotten');
        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        switch ($response = Password::administrator()->remind(Input::only('email')))
        {
            case Password::INVALID_USER:
                return Redirect::back()->with(Message::WARNING, [Lang::get($response)]);

            case Password::REMINDER_SENT:
                return Redirect::back()->with(Message::MESSAGE, [Lang::get($response)]);
        }

    }


    public function getReset($account=null,$token = null)
    {
        if (is_null($token) or is_null($account)) App::abort(404);


        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\Reset', [
            'class' => 'login-form'
        ],[
            'token' => $token,
            'account' => $account
        ]);

        $content = View::make('expendable::admin.login.reset', [
            'form' => $form
        ]);

        $this->addToLayout('login', 'class_layout');
        $this->addToLayout($content, 'content');
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\Forgotten');
        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $credentials = Input::only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );

        $response = Password::{Input::get('account')}()->reset($credentials, function ($user, $password)
        {
            $user->password = Hash::make($password);
            $user->save();
        });

        switch ($response)
        {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
                return Redirect::back()->with('error', Lang::get($response));

            case Password::PASSWORD_RESET:
                return Redirect::to(action(get_class($this).'@getIndex'));
        }
    }

    // ------------------------------------------------------------------------------------------------

    public function getLogout()
    {

        new UserEvent(UserEvent::LOGOUT_EVENT, Auth::administrator()->get());

        Auth::administrator()->logout();

        return Redirect::route('login.index');
    }




    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    protected function initStaticPart()
    {
        if (!is_null($this->layout))
        {

            $asstets = json_decode(File::get(Config::get('expendable::config_file_assets')));


            $header = View::make('expendable::admin.part.header')->with([
                'version' => $asstets->version,
                'title'   => ''
            ]);
            $footer = View::make('expendable::admin.part.footer')->with([
                'version' => $asstets->version,
                'title'   => ''
            ]);

            $this->addToLayout($header, 'header');
            $this->addToLayout($footer, 'footer');
        }
    }

}