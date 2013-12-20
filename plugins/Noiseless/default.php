<?php if (!defined('APPLICATION')) exit();

$PluginInfo['Noiseless'] = array(
	'Name' => 'Noiseless 只看楼主',
	'Description' => 'Only show comments by the discussion author',
	'Version' => '0.1.2',
	'RequiredApplications' => array('Vanilla' => '2.0.18.4'),
	'RequiredTheme' => FALSE,
	'RequiredPlugins' => FALSE,
	'MobileFriendly' => TRUE,
	'SettingsPermission' => 'Garden.Settings.Manage',
	'HasLocale' => TRUE,
	'RegisterPermissions' => FALSE,
	'Author' => "chuck911",
	'AuthorEmail' => 'contact@with.cat',
	'AuthorUrl' => 'http://vanillaforums.cn/profile/chuck911'
);

class NoiselessPlugin extends Gdn_Plugin {
	public function DiscussionController_BeforeDiscussionRender_Handler($Sender,$Args) {
		if(!isset($_GET['noiseless'])) return;
		$Discussion = $Sender->Data('Discussion');
		$Sql = Gdn::SQL();
		$Sql->Select('*')
			->From('Comment c')
			->Where('c.DiscussionID', $Discussion->DiscussionID, TRUE, FALSE)
			->Where('c.InsertUserID',$Discussion->InsertUserID,TRUE,FALSE)
			->OrderBy('c.DateInserted', 'asc');
		$Result = $Sql->Get();
		Gdn::UserModel()->JoinUsers($Result, array('InsertUserID', 'UpdateUserID'));
		if(self::checkVersion('2.0'))
			$Sender->SetData('CommentData',$Result,TRUE);
		$Sender->SetData('Comments', $Result);
		$Sender->Pager->Configure(0,0,0,'',TRUE);
		$Sender->Offset = 0;
	}

	public function DiscussionController_BeforeDiscussionOptions_Handler($Sender,$Args) {
		if(!self::checkVersion('2.1')) return;
		$this->showLink($Sender);
	}

	public function DiscussionController_CommentInfo_Handler($Sender,$Args) {
		if(!self::checkVersion('2.0')) return;
		if($Sender->EventArguments['Type'] == 'Discussion')
			$this->showLink($Sender);
	}

	protected function showLink($Sender){
		$Discussion = $Sender->Data('Discussion');
		if(!isset($_GET['noiseless']))
			echo Anchor(T('Noiseless_on','noiseless'),'/discussion/'.$Discussion->DiscussionID.'?noiseless','noiseless_btn noiseless_on');
		else
			echo Anchor(T('Noiseless_off','show all'),'/discussion/'.$Discussion->DiscussionID,'noiseless_btn noiseless_off');
	}

	public static function checkVersion($Version)
	{
		return APPLICATION_VERSION >= $Version;
	}
}
