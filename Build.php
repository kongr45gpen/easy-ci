<?php

namespace kongr45gpen\EasyCi;


use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

class Build
{
    /**
     * The configuration values for the build
     * @var array
     */
    private $config;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * Build constructor.
     * @todo Do we accept an array, or a path to the configuration file?
     * @param $configFile Path to the configuration file
     */
    public function __construct($configFile) {
        $this->config = Yaml::parse(file_get_contents($configFile));
    }

    /**
     * Start the build
     * @todo Use our own OutputInterface, along with helper functions
     * @return boolean Whether the build succeeded
     */
    public function start() {
        foreach ($this->config['commands'] as $command) {
            $process = new Process($command);
            $process->run(function($type, $buffer) {
                if ($this->output) {
                    $this->output->write($buffer);
                }
            });

            if (!$process->isSuccessful()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param OutputInterface $output
     * @return Build
     */
    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }
}