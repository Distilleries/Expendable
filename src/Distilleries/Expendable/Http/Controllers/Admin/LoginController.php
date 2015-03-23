<?php namespace Distilleries\Expendable\Http\Controllers\Admin;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Events\UserEvent;
use Distilleries\Expendable\Formatter\Message;
use Distilleries\Expendable\Http\Controllers\Admin\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use FormBuilder;

class LoginController extends BaseController {

    use ResetsPasswords;

    protected $layout = 'expendable::admin.layout.login';


    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Illuminate\Contracts\Auth\PasswordBroker $passwords
     * @param  \Distilleries\Expendable\Contracts\LayoutManagerContract $layoutManager
     */
    public function __construct(Guard $auth, PasswordBroker $passwords, LayoutManagerContract $layoutManager)
    {
        parent::__construct($layoutManager);

        $this->auth      = $auth;
        $this->passwords = $passwords;

    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    public function getIndex()
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\SignIn', [
            'class' => 'login-form'
        ]);

        $content = view('expendable::admin.login.signin', [
            'form' => $form
        ]);

        $this->layoutManager->add([
            'class_layout' => 'login',
            'content'      => $content,
        ]);

        return $this->layoutManager->render();
    }

    // ------------------------------------------------------------------------------------------------

    public function postIndex(Request $request)
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\SignIn');

        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $credential = $request->only('email', 'password');

        if ($this->auth->attempt($credential, true))
        {
            new UserEvent(UserEvent::LOGIN_EVENT, $this->auth->user());

            $menu = config('expendable.menu');

            return redirect()->to($this->auth->user()->getFirstRedirect($menu['left']));
        } else
        {

            return redirect()->back()->with(Message::WARNING, [trans('expendable::login.credential')]);
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

        $content = view('expendable::admin.login.forgot', [
            'form' => $form
        ]);

        $this->layoutManager->add([
            'class_layout' => 'login',
            'content'      => $content,
        ]);

        return $this->layoutManager->render();

    }

    // ------------------------------------------------------------------------------------------------

    public function postRemind(Request $request)
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\Forgotten');
        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $response = $this->passwords->sendResetLink($request->only('email'));

        switch ($response)
        {
            case PasswordBroker::INVALID_USER:
                return redirect()->back()->with(Message::WARNING, [trans($response)]);

            default:
                return redirect()->back()->with(Message::MESSAGE, [trans($response)]);
        }

    }


    public function getReset($token = null)
    {
        if (is_null($token)) abort(404);


        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\Reset', [
            'class' => 'login-form'
        ], [
            'token'   => $token
        ]);

        $content = view('expendable::admin.login.reset', [
            'form' => $form
        ]);

        $this->layoutManager->add([
            'class_layout' => 'login',
            'content'      => $content,
        ]);

        return $this->layoutManager->render();
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function postReset(Request $request)
    {

        $form = FormBuilder::create('Distilleries\Expendable\Forms\Login\Forgotten');
        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $credentials = $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );

        $response = $this->passwords->reset($credentials, function($user, $password)
        {
            $user->password = bcrypt($password);
            $user->save();
            $this->auth->login($user);
        });


        switch ($response)
        {
            case PasswordBroker::INVALID_PASSWORD:
            case PasswordBroker::INVALID_TOKEN:
            case PasswordBroker::INVALID_USER:
                return redirect()->back()->with('error', trans($response));

            case PasswordBroker::PASSWORD_RESET:
                return redirect()->to(action('\\'.get_class($this).'@getIndex'));
        }

    }

    // ------------------------------------------------------------------------------------------------

    public function getLogout()
    {

        new UserEvent(UserEvent::LOGOUT_EVENT, $this->auth->user());

        $this->auth->logout();

        return redirect()->route('login.index');
    }




    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    protected function initStaticPart()
    {
        $this->layoutManager->initStaticPart();
    }
}