<?php namespace Distilleries\Expendable\Models;

use Distilleries\Expendable\Scopes\Translatable;

class Email extends BaseModel implements \Distilleries\MailerSaver\Contracts\MailModelContract {

    use Translatable;

    protected $fillable = [
        'libelle',
        'body_type',
        'action',
        'cc',
        'bcc',
        'content',
        'status',
    ];

    public function initByTemplate($view)
    {
        return $this->where('action', '=', $view);
    }

    public function getTemplate($view)
    {
        if (!empty($this->action))
        {
            return $this->content;
        }

        return '';
    }

    public function getBcc()
    {
        return !empty($this->bcc) ? explode(',', $this->bcc) : [];
    }

    public function getSubject()
    {
        return $this->libelle;
    }

    public function getCc()
    {
        return !empty($this->cc) ? explode(',', $this->cc) : [];
    }

    public function getPlain()
    {
        return strtolower($this->body_type);
    }
}