<?php

class Controller {
	private $name;
	private $action;

	// Which components must be loaded 
	protected $components = array();

	// Which models must be loaded
	protected $uses = array();

	// Which helpers must be loaded
	protected $helpers = array();

	// Holds the variables that are being passed to the view
	private $variables = array();

	private $view;
	
	public function __construct() {
		// Set controller name
		$this->name = str_replace('Controller', '', get_class($this));

		// Initialize
		$this->initializeComponents();

		$this->initializeModels();

		return $this;
	}

	/**
	 * Loads all components given in $this->components
	 */
	protected function initializeComponents() {
		foreach($this->components as $component) {
			$componentClassName = $component . 'Component';

			require_once 'library/Controller/Component.php';
			require_once 'library/Controller/Component/' . $componentClassName . '.php';

			// Set variable for component
			$this->$component = new $componentClassName();
		}
	}

	/**
	 * Loads all models given in $this->uses
	 */
	protected function initializeModels() {
		foreach($this->uses as $modelName) {
			require_once 'library/Model/Model.php';
			require_once 'application/Model/BaseModel.php';
			require_once 'application/Model/' . $modelName . '.php';

			// Set variable for model
			$this->$modelName = new $modelName();
		}
	}

	/**
	 * Sets the current acion
	 */
	public function setAction($actionName) {
		if(!method_exists($this, $actionName)) {
			exit('Action `' . $actionName . '` does not exist');
		}

		$this->action = $actionName;

		return $this;
	}
	
	/**
	 * Executes the currently selected action
	 */
	public function execute() {
		// Execute beforeAction() just before the action is executed
		$this->beforeAction();

		// Execute the action
		$this->{$this->action}();
		
		return $this;
	}

	/**
	 * Redirect
	 */
	public function redirect($path) {
		if(is_array($path)) {
			if(isset($path['controller'])) {
				$url .= CR . $path['controller'] . '/';

				if(isset($path['action'])) {
					$url .= $path['action'] . '/';

					if(isset($path['parameters'])) {
						foreach($path['parameters'] as $parameter) {
							$url .= $parameter . '/';
						}
					}
				}
			}
		} else {
			$url = $path;
		}

		// Redirect
		header('Location: ' . $url);
	}

	/**
	 * To be extended by (base) controller.
	 * Will be executed just before action is executed.
	 */
	protected function beforeAction() {}

	/**
	 * To be extended by (base) controller.
	 * Will be executed just before the view renders.
	 */
	protected function beforeRender() {}

	/**
	 * Sets a variable that will be available in the view
	 */
	public function set($variableName, $value) {
		$this->variables[$variableName] = $value;

		return $this;
	}
	
	/**
	 * Create a new view and render it
	 */
	public function render($templateName = null) {
		// Include classes
		require_once 'library/View/View.php';
		require_once 'application/View/BaseView.php';

		// Use action name as default template name
		if(is_null($templateName)) {
			$templateName = $this->action;
		}

		// Create the instance
		$this->view = new View($this->name, $templateName);

		// Add helpers to view
		foreach($this->helpers as $key => $helper) {
			$helperName = $helper;

			$helperClassName = $helperName . 'Helper';

			// Include files
			//require_once 'library/View/Helper/Helper.php';
			require_once 'library/View/Helper/' . $helperClassName . '.php';

			// Create instance
			$this->view->$helperName = new $helperClassName();
		}
		
		// Execute beforeRender() just before the view is rendered
		$this->beforeRender();

		// Render the view
		$this->view->render($this->variables);
		
		return $this;
	}
}