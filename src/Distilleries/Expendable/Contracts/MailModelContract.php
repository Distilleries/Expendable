<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 30/01/2015
 * Time: 10:02 AM
 */

namespace Distilleries\Expendable\Contracts;


interface MailModelContract {

    public function initByTemplate($view);

    public function getTemplate($view);

    public function getBcc();

    public function getSubject();

    public function getCc();

    public function getPlain();
} 