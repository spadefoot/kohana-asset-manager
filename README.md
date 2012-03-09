#Kohana Asset Manager

###Quick Start

#####Create the class

`$this->AssetManager = new AssetManager();`

#####Add a library

This will pull from the config file.

`$this->AssetManager->set_library(Asset::JQUERY);`

#####Add an asset

    $this->AssetManager->set_asset(array(
        'type' => 'text/css',
        'media' => 'screen, projection',
        'uri' => '/lib/css/layout.css'
    ));

#####Render the HTML
`$this->AssetManager->render();`

