<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector\Discovery;

class Script
{
    private $_jobs = [];
    private $_registration;

    /**
     * @param \Bronto\M2\Connector\RegistrationInterface $registration
     */
    public function __construct(\Bronto\M2\Connector\RegistrationInterface $registration)
    {
        $this->_registration = $registration;
    }

    /**
     * Adds job info to launch in the Middleware
     *
     * @param array $job
     * @return $this
     */
    public function addJobInfo(array $job)
    {
        $this->_jobs[] = $job;
        return $this;
    }

    /**
     * Add a scheduled task definition to send to the Middleware
     *
     * @param string $jobName
     * @param array $data
     * @return $this
     */
    public function addScheduledTask($jobName, $data = [])
    {
        return $this->addJobInfo([
            'id' => 'event',
            'extensionId' => 'advanced',
            'scopeId' => $this->_registration->getScopeHash(),
            'data' => array_merge([ 'jobName' => $jobName ], $data)
        ]);
    }

    /**
     * Gets all of the jobs designated as queue flushers
     *
     * @return array
     */
    public function getJobs()
    {
        return $this->_jobs;
    }

    /**
     * Gets the registration associated with this script
     *
     * @return \Bronto\M2\Connector\RegistrationInterface
     */
    public function getRegistration()
    {
        return $this->_registration;
    }
}