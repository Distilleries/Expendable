<?php

namespace Distilleries\Expendable\Console\Traits;

trait CanProgress
{
    /**
     * @var string
     */
    protected static $BAR_FORMAT = ' %current%/%max% [%bar%] %percent:3s%% (%elapsed:6s%/%estimated:-6s%) | %message%';

    /**
     * @var \Symfony\Component\Console\Helper\ProgressBar
     */
    protected $progressBar;

    /**
     * Init a progress bar
     *
     * @param  int $total
     * @return void
     */
    public function initProgressBar($total)
    {
        $this->progressBar = $this->output->createProgressBar($total);
        $this->progressBar->setFormat(self::$BAR_FORMAT);
        $this->progressBar->setBarCharacter('<fg=red>=</>');
        $this->progressBar->setProgressCharacter("\xF0\x9F\x8D\xBA");
        $this->progressBar->setEmptyBarCharacter('-');
        $this->progressBar->setMessage('');
    }

    /**
     * Set the progress bar messages
     *
     * @param  string $message
     * @return void
     */
    public function setProgressBarMessage($message)
    {
        if (! is_null($this->progressBar))
            $this->progressBar->setMessage($message);
    }

    /**
     * Increment the progress bar by one
     *
     * @return  void
     */
    public function incrementProgressBar()
    {
        if (! is_null($this->progressBar))
            $this->progressBar->advance();
    }

    /**
     * Stop de the progress bar
     *
     * @param   string  $message
     * @return  void
     */
    public function stopProgressBar($message)
    {
        if (! is_null($this->progressBar))
        {
            $this->progressBar->setMessage($message);
            $this->progressBar->finish();
            $this->info('');
        }
    }
}
