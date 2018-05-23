<?php

class BaseController extends Controller {
	protected $components = array('Session', 'Auth');

	protected $helpers = array('Session');
}