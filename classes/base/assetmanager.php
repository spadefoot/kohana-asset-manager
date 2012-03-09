<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This class manages assets.
 *
 * @author iFrogz Developers <developers@ifrogz.com>
 * @version 2011-09-12
 * @copyright (c) 2011, iFrogz (a subsidiary of ZAGG, Inc.)
 * @package cache-ext
 * @category Asset
 */
class Base_AssetManager extends Kohana_Object {

	/**
	 * This variable stores an array of assets.
	 *
	 * @access protected
	 * @var array
	 */
	protected $assets = NULL;

	/**
	 * This constructor creates an instance of this class.
	 *
	 * @access public
	 */
	public function __construct() {
		$this->assets = array();
	}

	/**
	 * This will return the total number of assets by the given name
	 *
	 * @access protected
	 * @param String $name
	 * @return int
	 */
	protected function get_total_assets_by_name($name) {
		$i = 0;
		foreach ($this->assets as $asset) {
			if (Arr::get($asset, 'name') == $name) {
				$i++;
			}
		}

		return $i;
	}

	/**
	 * Returns the first asset found with the given name
	 *
	 * @access protected
	 * @param String $name
	 * @return mixed
	 */
	protected function get_asset_by_name($name) {
		foreach ($this->assets as $asset) {
			if (Arr::get($asset, 'name') == $name) {
				return $asset;
			}
		}

		return FALSE;
	}

	/**
	 * Return all assets found with the given name
	 *
	 * @access protected
	 * @param String $name
	 * @return array
	 */
	protected function get_assets_by_name($name) {
		$arr = array();
		foreach ($this->assets as $asset) {
			if (Arr::get($asset, 'name') == $name) {
				$arr[] = $asset;
			}
		}

		return $arr;
	}

	/**
	 * This function will return the assets that belong to a specific group
	 *
	 * @access protected
	 * @param String $group
	 * @return array
	 */
	protected function get_group_assets($group) {
		if (is_null($group)) {
			return array_values($this->assets);
		}

		$buffer = array();
		foreach($this->assets as $asset) {
			if ($asset['group'] == $group) {
				$buffer[] = $asset;
			}
		}

		return $buffer;
	}

	/**
	 * This function will remove all assets with the given name
	 *
	 * @access protected
	 * @param String $name
	 * @return void
	 */
	protected function remove_assets_by_name($name) {
		foreach ($this->assets as $key => $asset) {
			if (Arr::get($asset, 'name') == $name) {
				unset($this->assets[$key]);
			}
		}
	}

	/**
	 * This function sets the specified asset.
	 *
	 * @access public
	 * @param Array $asset							the asset to be set
	 */
	public function set_asset(Array $asset) {
		$uri = $asset['uri'];

		// Don't add already existing assets with the same name
		if (isset($asset['name'])) {
			if ($this->get_total_assets_by_name($asset['name']) > 0) {
				// Compare weights
				$existing_asset = $this->get_asset_by_name($asset['name']);
				$existing_weight = Arr::get($existing_asset, 'weight', PHP_INT_MAX);
				if (Arr::get($asset, 'weight', PHP_INT_MAX) < $existing_weight) {
					// Keep this one and remove old one
					$this->remove_assets_by_name($asset['name']);
				} else {
					// Keep existing asset and ignore this one
					return;
				}
			} else {
				$this->names[$asset['name']] = Arr::get($asset, 'weight', PHP_INT_MAX);
			}
		}
		
		if ($asset['type'] == 'text/css' && isset($this->assets[$uri]['media'])) {
			$a = array_map('strtolower', preg_split('/[,\s]+/', $this->assets[$uri]['media']));
			$b = array_map('strtolower', preg_split('/[,\s]+/', $asset['media']));
			$media = array_unique(array_merge($a, $b));
			if (in_array('all', $media)) {
				$media = array('all');
			}
			$this->assets[$uri]['media'] = implode(', ', $media);
		} else {
			// Check for duplicate URI
			if (isset($this->assets[$uri])) {
				// Replace URI with the lowest weight
				if (isset($this->assets[$uri]['weight'])) {
					if (Arr::get($asset, 'weight', PHP_INT_MAX) < $this->assets[$uri]['weight']) {
						$this->assets[$uri] = $asset;
					}
				} else {
					// If no weight was set, then just replace it
					$this->assets[$uri] = $asset;
					$this->assets[$uri]['weight'] = Arr::get($asset, 'weight', PHP_INT_MAX);
					$this->assets[$uri]['group'] = Arr::get($asset, 'group', 'default');
				}
			} else {
				$this->assets[$uri] = $asset;
				$this->assets[$uri]['weight'] = Arr::get($asset, 'weight', PHP_INT_MAX);
				$this->assets[$uri]['group'] = Arr::get($asset, 'group', 'default');
			}
		}
	}

	/**
	 * This function sets the specified assets.
	 *
	 * @access public
	 * @param array $assets							the assets to be set
	 */
	public function set_assets(Array $assets) {
		foreach ($assets as $asset) {
			$this->set_asset($asset);
		}
	}

	/**
	 * This function sets the specified library.
	 *
	 * @access public
	 * @param string $library                   the name of the library
	 * @param string $version                   the version number
	 * @param array $properties                 the properties array
	 * @throws Kohana_InvalidProperty_Exception indicates that the configuration group
	 *                                          could not be found
	 */
	public function set_library($library, $version = 'default', $properties = array()) {
		$lib = "asset.{$library}.{$version}";
		if (($assets = Kohana::$config->load($lib)) === NULL) {
			throw new Kohana_InvalidProperty_Exception('Message: Cannot load configuration. Reason: Configuration group :lib is undefined.', array(':lib' => $lib));
		}
		foreach ($assets as $asset) {
			if (isset($properties['weight'])) {
				$asset['weight'] = $properties['weight'];
			}
			if (isset($properties['group'])) {
				$asset['group'] = $properties['group'];
			}
			$this->set_asset($asset);
		}
	}

	/**
	 * This function will set the weight for a whole group
	 *
	 * @param $group String
	 * @param $weight Integer
	 * @return void
	 */
	public function set_group_weight($group, $weight) {
		foreach ($this->assets as $key => $asset) {
			if ($asset['group'] == $group) {
				$this->assets[$key]['weight'] = $weight;
			}
		}
	}
	
	/**
	 * This function renders the HTML tags for the assets.
	 *
	 * @access public
	 * @param string $group                         The group of assets
	 * @return string                               the HTML tags for the assets
	 */
	public function render($group = NULL) {
		$buffer = '';

		// Get the assets to render
		$assets = $this->get_group_assets($group);

		//echo Debug::vars($group, $assets); exit;

		// Sort the assets
		Arr::merge_sort($assets, array($this, 'sort_weight'));

		//echo Debug::vars($assets); exit;

		foreach ($assets as $asset) {

			// Get the uri
			$uri = NULL;
			if (isset($asset['uri'])) {
				$uri = $this->get_uri($asset['uri']);
			}

			switch ($asset['type']) {
				case 'text/css':
					if (isset($asset['when'])) {
						$buffer .= "<!--[if {$asset['when']}]>" . PHP_EOL;
					}
					$buffer .= '<link rel="stylesheet" type="text/css" media="' . $asset['media'] . '" href="' . $uri . '" />' . PHP_EOL;
					if (isset($asset['when'])) {
						$buffer .= '<![endif]-->' . PHP_EOL;
					}
					break;
				case 'application/ecmascript':
				case 'application/javascript':
				case 'application/x-ecmascript':
				case 'application/x-javascript':
				case 'text/ecmascript':
				case 'text/javascript':
				case 'text/javascript1.0':
				case 'text/javascript1.1':
				case 'text/javascript1.2':
				case 'text/javascript1.3':
				case 'text/javascript1.4':
				case 'text/javascript1.5':
				case 'text/jscript':
				case 'text/livescript':
				case 'text/x-ecmascript':
				case 'text/x-javascript':
					$buffer .= '<script language="JavaScript" type="text/javascript" src="' . $uri . '"></script>' . PHP_EOL;
					if (isset($asset['init'])) {
						$buffer .= '<script language="JavaScript" type="text/javascript">' . PHP_EOL;
						$buffer .= $asset['init'] . PHP_EOL;
						$buffer .= '</script>' . PHP_EOL;
					}
					break;
				case 'text/html':
					$buffer .= $asset['data'];
					break;
				case 'application/php':
				case 'application/x-php':
				case 'application/x-httpd-php':
				case 'application/x-httpd-php-source':
				case 'text/php':
				case 'text/x-php':
					ob_start();
					include($uri);
					$buffer .= ob_get_clean();
					break;
				case 'application/rss+xml':
					$buffer .= '<link href="' . $uri . '" title="' . $asset['title'] . '" type="application/rss+xml" rel="alternate">' . PHP_EOL;
					break;
			}
		}
		return $buffer;
	}

	/**
	 * This function generates the appropriate HTML tag for the specified library.
	 *
	 * @access public
	 * @static
	 * @param string $library                   the name of the library
	 * @param string $version                   the version number
	 * @return string                           the HTML tag for the specified library
	 */
	public static function load($library, $version = 'default') {
		$AssetManager = new AssetManager();
		$AssetManager->set_library($library, $version);
		return $AssetManager->render();
	}

	/**
	 * The callback function for sorting the assets
	 *
	 * @param $a
	 * @param $b
	 * @return int
	 */
	public function sort_weight($a, $b) {
		if ($a['weight'] == $b['weight']) {
			return 0;
		}

		if ($a['weight'] < $b['weight']) {
			return -1;
		} else {
			return 1;
		}
	}

	protected function get_uri($uri) {
		// Check for a needed secure uri
		if (Request::current()->secure()) {
			if (stristr($uri, 'http://')) {
				$uri = str_ireplace('http://', 'https://', $uri);
			}
		}

		return $uri;
	}

}
?>