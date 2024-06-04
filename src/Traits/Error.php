<?php

declare(strict_types=1);

namespace KenCore\Traits;

trait Error
{
    protected $error = '';

    public function getError(): string
    {
        return $this->error;
    }

    public function setError($error): void
    {
        $this->error = $error;
    }

    /**
     * 是否存在错误
     * @return bool
     */
    public function hasError()
    {
        return !empty($this->error);
    }
}
