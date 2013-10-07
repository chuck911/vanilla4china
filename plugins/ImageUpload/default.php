<?php if (!defined('APPLICATION')) exit();

$PluginInfo['ImageUpload'] = array(
	'Name' => 'ImageUpload',
	'Description' => 'lightweight and simple image uploader',
	'Version' => '1.1',
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

class ImageUploadPlugin extends Gdn_Plugin {

	public function DiscussionController_BeforeBodyField_Handler($Sender)
	{
		echo $Sender->FetchView($this->GetView('upload_button.php'));
	}

	public function PostController_BeforeBodyInput_Handler($Sender)
	{
		echo $Sender->FetchView($this->GetView('upload_button.php'));
	}

	public function Base_Render_Before($Sender) {
		if(!in_array(get_class($Sender), array('PostController','DiscussionController')))
			return;
		$Sender->AddDefinition('ImageUpload_Url',Url('/post/imageupload'));
		$Sender->AddDefinition('ImageUpload_Multi',C('Plugins.UploadImage.Multi',TRUE));
		$Sender->AddDefinition('ImageUpload_InputFormatter',C('Garden.InputFormatter', 'Html'));
		$Sender->AddDefinition('ImageUpload_MaxFileSize', C('Plugins.UploadImage.MaxFileSize', '2mb'));
		$Sender->AddCssFile('imageupload.css', 'plugins/ImageUpload/css');
		$Sender->AddJsFile('plupload.full.js', 'plugins/ImageUpload');
		$Sender->AddJsFile('imageupload.js', 'plugins/ImageUpload');
	}

	public function PostController_Imageupload_create()
	{
		try {
			$UploadImage = new Gdn_UploadImage();
			$TmpImage = $UploadImage->ValidateUpload('image_file');

			// Generate the target image name.
			$TargetImage = $UploadImage->GenerateTargetName(PATH_UPLOADS.'/imageupload', '', TRUE);

			$Props = $UploadImage->SaveImageAs($TmpImage,$TargetImage,C('Plugins.UploadImage.MaxHeight',''),C('Plugins.UploadImage.MaxWidth',650));
			echo json_encode(array('url'=>$Props['Url'],'name'=>$UploadImage->GetUploadedFileName()));
		} catch (Exception $e) {
			header('HTTP/1.0 400', TRUE, 400);
			echo $e;
		}
	}
}
