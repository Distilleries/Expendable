<?php namespace Distilleries\Expendable\Events;

class UserEvent extends EventDispatcher {

    const LOGIN_EVENT  = 'user.login';
    const LOGOUT_EVENT = 'user.logout';
    const SECURITY_EVENT = 'user.security';

}