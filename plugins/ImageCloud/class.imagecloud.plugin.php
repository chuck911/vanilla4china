<?php if (!defined('APPLICATION')) exit();

$PluginInfo['ImageCloud'] = array(
	'Name' => 'ImageCloud',
	'Description' => 'lightweight image uploader using Qiniu Cloud as storage',
	'Version' => '1.0.0',
	'RequiredApplications' => array('Vanilla' => '2.0.18.4'),
	'RequiredTheme' => FALSE,
	'RequiredPlugins' => FALSE,
	'MobileFriendly' => TRUE,
	// 'HasLocale' => TRUE,
	'RegisterPermissions' => FALSE,
	'Author' => "chuck911",
	'AuthorEmail' => 'contact@with.cat',
	'AuthorUrl' => 'http://vanillaforums.cn/profile/chuck911'
);

class ImageCloudPlugin extends Gdn_Plugin {

	public function DiscussionController_BeforeBodyField_Handler($Sender)
	{
		$this->renderButton($Sender);
	}

	public function PostController_BeforeBodyInput_Handler($Sender)
	{
		$this->renderButton($Sender);	
	}

	protected function renderButton($controller) {
		echo $controller->FetchView($this->GetView('upload_button.php'));
	}

	public function Base_Render_Before($Sender) {
		if(!in_array(get_class($Sender), array('PostController','DiscussionController')))
			return;
		$cloud = $this->getCloud(); 
		$Sender->AddDefinition('ImageCloud_UploadUrl',$cloud->getUploadUrl());
		$Sender->AddDefinition('ImageCloud_Tokens',json_encode($cloud->getTokens()));
		$Sender->AddDefinition('ImageCloud_UrlRoot',$cloud->getRootUrl());
		$Sender->AddDefinition('ImageCloud_Suffix',$cloud->getSuffix());
		$Sender->AddDefinition('ImageCloud_Multi',C('Plugins.ImageCloud.Multi',TRUE));
		$Sender->AddDefinition('ImageCloud_InputFormatter',C('Garden.InputFormatter', 'Html'));
		$Sender->AddDefinition('ImageCloud_MaxFileSize', C('Plugins.ImageCloud.MaxFileSize', '2mb'));
		$Sender->AddCssFile('imagecloud.css', 'plugins/ImageCloud/css');
		$Sender->AddJsFile('plupload.full.js', 'plugins/ImageCloud');
		$Sender->AddJsFile('imagecloud.js', 'plugins/ImageCloud');
	}

	protected function getCloud() {
		$driver = C('Plugins.ImageCloud.Driver').'Driver';
		require_once "drivers/{$driver}.php";
		return new $driver;
	}
}
