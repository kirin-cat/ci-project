<?php

namespace Kirin\CI\Controller;

/**
 * @property \Doctrine $doctrine
 */
class AbstractController extends \CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->library('doctrine');
    }
}
