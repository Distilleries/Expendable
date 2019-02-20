<?php namespace Distilleries\Expendable\Http\Controllers\Backend;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Events\UserEvent;
use Distilleries\Expendable\Formatter\Message;
use Distilleries\Expendable\Helpers\UserUtils;
use Distilleries\Expendable\Http\Controllers\Backend\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ResetsPasswords;
use FormBuilder;
use Illuminate\Support\Facades\Password;


class LoginController extends BaseController
{

    use ResetsPasswords;

    protected $layout = 'expendable::admin.layout.login';


    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Distilleries\Expendable\Contracts\LayoutManagerContract $layoutManager
     */
    public function __construct(Guard $auth, LayoutManagerContract $layoutManager)
    {
        parent::__construct($layoutManager);

        $this->auth = $auth;

    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getLoginRedirect()
    {
        return redirect()->action('\\'.self::class.'@getIndex');
    }

    public function getIndex()
    {

        $form = FormBuilder::create('Distilleries\Expendable\Http\Forms\Login\SignIn', [
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

        $form = FormBuilder::create('Distilleries\Expendable\Http\Forms\Login\SignIn');

        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $credential     = $request->only('email', 'password');
        $userCredential = app('Distilleries\Expendable\Contracts\LockableContract')->where('email', $credential['email'])->get()->last();

        if (UserUtils::securityCheckLockEnabled() && !empty($userCredential) && $userCredential->isLocked())
        {
            return redirect()->back()->with(Message::WARNING, [trans('expendable::login.locked')]);
        }

        if ($this->auth->attempt($credential, config('expendable.remember_me')))
        {
            $user = $this->auth->user();
            new UserEvent(UserEvent::LOGIN_EVENT, $user);

            $menu = config('expendable.menu');


            if (method_exists($user, 'getFirstRedirect'))
            {
                return redirect()->to($this->auth->user()->getFirstRedirect($menu['left']));
            }

            return redirect()->to('/');

        } else
        {

            if (UserUtils::securityCheckLockEnabled())
            {
                new UserEvent(UserEvent::SECURITY_EVENT, $credential['email']);
            }


            return redirect()->back()->with(Message::WARNING, [trans('expendable::login.credential')]);
        }

    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getRemind()
    {

        $form = FormBuilder::create('Distilleries\Expendable\Http\Forms\Login\Forgotten', [
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

        $form = FormBuilder::create('Distilleries\Expendable\Http\Forms\Login\Forgotten');
        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $this->validate($request, ['email' => 'required|email']);
        
        $response = $this->broker()->sendResetLink($request->only('email'));

        switch ($response)
        {
            case \Password::RESET_LINK_SENT:
                return redirect()->back()->with(Message::MESSAGE, [trans($response)]);
            default:
                return redirect()->back()->with(Message::WARNING, [trans($response)]);
        }

    }


    public function getReset($token = null)
    {
        if (is_null($token))
        {
            abort(404);
        }


        $form = FormBuilder::create('Distilleries\Expendable\Http\Forms\Login\Reset', [
            'class' => 'login-form'
        ], [
            'token' => $token
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

        $form = FormBuilder::create('Distilleries\Expendable\Http\Forms\Login\Forgotten');
        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $response = $this->broker()->reset(
            $this->credentials($request), function($user, $password) {
            $this->resetPassword($user, $password);
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? redirect()->to(action('\\'.get_class($this).'@getIndex'))
            : redirect()->back()->with('error', trans($response));

    }

    // ------------------------------------------------------------------------------------------------

    public function getLogout()
    {

        new UserEvent(UserEvent::LOGOUT_EVENT, $this->auth->user());

        $this->auth->logout();

        return redirect()->route('login');
    }




    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    protected function initStaticPart()
    {
        $this->layoutManager->initStaticPart();
    }

}