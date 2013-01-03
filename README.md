Multidomain ClientScript (assets)
=================================
Extending default Yii [CClientScript](https://github.com/yiisoft/yii/blob/master/framework/web/CClientScript.php) class to use multiple subdomains for assets (scripts and stylesheets).

Preinstall
----------
You should make sure, that your HTTP-server configured properly - `'assetsSubdomain'` and all its combinations are pointing to your `'public_html'` directory.

Install and config (available and default settings)
---------------------------------------------------
Place `StaticClientScript.php` file into `protected/components` directory.
After this, you can enhance `CClientScript` class by making some changes in your config file (`protected/config/main.php`):

<pre>
'components' => array(
   ...
    'clientScript' => array(
        'class' => 'application.components.MultidomainClientScript',
        'enableMultidomainAssets' => true,
        'assetsSubdomain' => 'assets',
        'indexedAssetsSubdomain' => false,
    ),
    ...
)
</pre>

Params
------
- `enableMultidomainAssets` - whether to use subdomains for ClientScript assets. Default is `true`
- `assetsSubdomain` - subdomain name (e.g. `http://assets.example.com`). Default is `'assets'`
- `indexedAssetsSubdomain` - whether to use indexed subdomains for registered script files basing on their `'position'` param. Default is `false`

Examples
--------
Example for `indexedAssetsSubdomain`=`true` param:

<pre>Yii::app()->clientScript->registerScriptFile('/js/script.js', CClientScript::POS_HEAD)
// will output:
&lt;head&gt;...&lt;script type=&quot;text/javascript&quot; src=&quot;http://assets0.example.com/js/script.js&quot;&gt;&lt;/script&gt;...&lt;/head&gt;&#10;</pre>

<pre>Yii::app()->clientScript->registerScriptFile('/js/script.js', CClientScript::POS_END)
// will output:
...&lt;script type=&quot;text/javascript&quot; src=&quot;http://assets2.example.com/js/script.js&quot;&gt;&lt;/script&gt;&lt;/body&gt;</pre>
