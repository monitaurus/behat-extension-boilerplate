<?php

namespace LogsExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use LogsExtension\Context\LogsContext;

class LogsInitializer implements ContextInitializer
{
    public function __construct(
        private string $filepath,
        private bool $enable
    ) {
    }

    public function initializeContext(Context $context)
    {
        if (!$context instanceof LogsContext) {
            return;
        }

        $context->initializeConfig($this->enable, $this->filepath);
    }
}
