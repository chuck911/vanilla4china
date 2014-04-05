<?php if (!defined('APPLICATION')) exit();

class OrchidThemeHooks extends Gdn_Plugin {	
	public function Base_AfterJsCdns_Handler($Sender,$Args){
		$Args['Cdns'] = array('jquery.js' => 'http://cdn.staticfile.org/jquery/1.10.2/jquery.min.js');
	}

	public function HeadModule_BeforeToString_Handler($Sender,$Args)
	{
		if(Gdn::Request()->PathAndQuery()=='') $Sender->ClearTag('link','rel','canonical');
	}
}

// if (!function_exists('UserPhotoDefaultUrl')) {
//    function UserPhotoDefaultUrl($User) {
//       return Url('/themes/orchid/design/default-avatar.jpg',TRUE);
//    }
// }