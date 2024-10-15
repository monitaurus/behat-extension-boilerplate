<?php

namespace LogsExtension\Context;

use Behat\Behat\Context\Context as BehatContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

class LogsContext implements BehatContext
{
    private bool $enable = false;
    private string $filepath;

    public function initializeConfig(bool $enable, string $filepath)
    {
        $this->enable = $enable;
		$this->filepath = $filepath;
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        if ($this->enable === false) {
            return;
        }

        file_put_contents(
            $this->filepath,
            'START: ' . $scope->getScenario()->getTitle() . ' - ' . time() . PHP_EOL,
            FILE_APPEND
        );
    }
    
    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
        if ($this->enable === false) {
            return;
        }

        file_put_contents(
            $this->filepath,
            'END: ' . $scope->getScenario()->getTitle() . ' - ' . time() . PHP_EOL,
            FILE_APPEND
        );
    }
}
