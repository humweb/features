<?php

namespace Humweb\Features\Strategy;

/**
 * User agent strategy.
 */
class UserAgentStrategy extends AbstractStrategy
{

    /**
     * {@inheritdoc}
     */
    public function handle($args = [])
    {
        $userAgent = $this->getUserAgent();

        foreach ($args['patterns'] as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Returns current user agent.
     *
     * @return string
     */
    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }
}
