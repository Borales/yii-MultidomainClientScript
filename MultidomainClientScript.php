<?php
/**
 * @author Borales <bordun.alexandr@gmail.com>
 *
 * @property string $assetsBaseUrl Use it (Yii::app()->clientScript->assetsBaseUrl) instead of Yii::app()->request->baseUrl
 */
class MultidomainClientScript extends CClientScript {

    /**
     * @var bool Whether the multidomain assets are enabled
     */
    public $enableMultidomainAssets = true;

    /**
     * @var string Subdomain name
     */
    public $assetsSubdomain = "assets";

    /**
     * @var bool Whether to use multiple assets subdomains
     */
    public $indexedAssetsSubdomain = false;

    /**
     * @param string $subDomainIndex
     * @return string
     */
    public function getAssetsBaseUrl($subDomainIndex="") {
        $baseUrl = Yii::app()->request->baseUrl;
        if($this->enableMultidomainAssets===false)
            return $baseUrl;

        $schema = Yii::app()->request->isSecureConnection?"https://":"http://";
        $subDomainIndex = $this->indexedAssetsSubdomain?$subDomainIndex:"";
        $baseUrl = $schema.$this->assetsSubdomain.$subDomainIndex.'.'.Yii::app()->request->serverName.$baseUrl;
        return $baseUrl;
    }

    /**
     * Renders the registered scripts.
     * This method is called in {@link CController::render} when it finishes
     * rendering content. CClientScript thus gets a chance to insert script tags
     * at <code>head</code> and <code>body</code> sections in the HTML output.
     * @param string $output the existing output that needs to be inserted with script tags
     */
    public function render(&$output)
    {
        if($this->enableStaticAssets && $this->hasScripts) {
            $this->renderCoreScripts();
            $this->coreScripts=null;
            $this->processAssetsUrl();
        }

        parent::render($output);
    }

    protected function processAssetsUrl() {
        foreach($this->cssFiles as $file=>$media) {
            if(strpos($file, '/') === 0) {
                unset($this->cssFiles[$file]);
                $this->cssFiles[$this->assetsBaseUrl.$file] = $media;
            }
        }

        foreach($this->scriptFiles as $pos=>$scripts) {
            foreach($scripts as $scriptName=>$script) {
                if(strpos($script, '/') === 0) {
                    $this->scriptFiles[$pos][$scriptName] = $this->getAssetsBaseUrl($pos).$script;
                }
            }
        }
    }
}
