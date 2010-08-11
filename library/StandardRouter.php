<?php
class StandardRouter
{
	protected
		$uriHandler,
		$_requested_array,
		$_controller,
		$_action,
		$_params = array();
	public static
		$uriSaved = array();
	
	public static function route()
	{
		self::getRequestRoute();
	}
	
	public function getRequestRoute()
	{
		// Provide a way to find out the URI
		$uriHandler = new UriHandler();
		
		// Let's check our configuration for what type of parsing we use
		$_config = IniConfig::getInstance();
		// Let's parse our config file
		$_config->parseIniFile('routes.ini', false);
		if((string)$_config->get('routes.standardRouting') == 'TRUE')
		{
			if((string)$_config->get('routes.standardRoutingType') == 'REQUEST_URI')
			{			
				$uriString = preg_replace("|/(.*)|", "\\1", 
					str_replace("\\", "/", $uriHandler->requestUri()));	
				
				// Prepare an array with the URI
				
				$_requested_array = explode('/', $uriString);
				$_config->set('uriSegment', $_requested_array);
				
				// Prepare an array with the pattern
				$routes_pattern = explode('/', $_config->get('routes.urlMap'));
				
				foreach($routes_pattern as $keyRoutePattern => $routePatternValue)
				{
					// Let's check where the controller position is.
					if(preg_match('/controller/', $routePatternValue))
					{
						// Let's setup the controller
						if(isset($_requested_array[$keyRoutePattern]))
							$_controller = $_requested_array[$keyRoutePattern];
							unset($_requested_array[$keyRoutePattern]);
					}
					
					// Let's check where the action position is.
					if(preg_match('/action/', $routePatternValue))
						if(isset($_requested_array[$keyRoutePattern]))
							$_action = $_requested_array[$keyRoutePattern];
							unset($_requested_array[$keyRoutePattern]);
				}
				
				// Let's check if our array is empty or not.
				if(!empty($_requested_array))
					$_params = $_requested_array;
				else
					unset($_requested_array);
					
				// Let's setup your controller if empty.	
				if(empty($_controller))
					$_controller = $_config->get('routes.controllerDefault');
				$_config->set('uriParsed.controller', $_controller);
				// Let's setup your action if empty
				if(empty($_action))
					$_action = $_config->get('routes.actionDefault');				
				$_config->set('uriParsed.action', $_action);
				// Let's deploy our dispatch
				if(!isset($_params))
					self::dispatchRoute($_controller, $_action);
				else
				{
					$_config->set('uriParsed.params', $_params);
					self::dispatchRoute($_controller, $_action, $_params);
				}	
			}
			else
			if((string)$_config->get('routes.standardRoutingType') == 'QUERY_STRING')
			{
				if($uriHandler->queryString())
				{
					// Let's get our QUERY_STRING
					$queryString = $_SERVER['QUERY_STRING'];
					// Let's prepare to parse it
					$queryString = explode('&', $queryString);
					// Let's get our routes pattern
					$routes_pattern = explode('/', $_config->get('routes.urlMap'));
					// Let's parse and see what we get.
					foreach($routes_pattern as $keyRoutePattern => $routePatternValue)
					{
						// Let's check where the controller position is.
						if(preg_match('/controller/', $routePatternValue))
						{
							// Let's setup the controller
							if(isset($queryString[$keyRoutePattern]))
							{
								$_controller = $queryString[$keyRoutePattern];
								unset($queryString[$keyRoutePattern]);
								$_controller = preg_replace('/c=/', '', $_controller);
							}
						}
						// Let's check where the action position is.
						if(preg_match('/action/', $routePatternValue))
						{
							// Let's setup the action
							if(isset($queryString[$keyRoutePattern]))
							{
								$_action = $queryString[$keyRoutePattern];
								unset($queryString[$keyRoutePattern]);
								$_action = preg_replace('/a=/', '', $_action);
							}
						}
					}
					// Let's setup your controller if empty.	
					if(empty($_controller))
						$_controller = $_config->get('routes.controllerDefault');
					// Let's setup your action if empty
					if(empty($_action))
						$_action = $_config->get('routes.actionDefault');
					// Let's deploy our dispatch
					self::dispatchRoute($_controller, $_action);
				}
			}
		}
	}
	
	protected function dispatchRoute($_controller, $_action, $_params = NULL)
	{
		// Let's make the controller the way it's intendet to.
		$_controller = ucwords($_controller . 'Controller');
		
		// Let's create an instance of Controller.
		$_controller = new $_controller();
		
		if(method_exists($_controller, $_action))
			if(!empty($_params))
				call_user_func_array(array($_controller, $_action), $_params);
			else
				call_user_func(array($_controller, $_action));
		else
			throw new Exception('Unable to call Controller Action ' . 
                                    $_action);
	}
}
