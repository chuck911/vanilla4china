$(function(){

	var uploader = new plupload.Uploader({
		runtimes : 'html5,html4',
		browse_button : 'btn_imageupload',
		multi_selection:gdn.definition('ImageUpload_Multi'),
		max_file_size : gdn.definition('ImageUpload_MaxFileSize'),
		file_data_name: 'image_file',
		url : gdn.definition('ImageUpload_Url', '/post/imageupload'),
		// flash_swf_url : '/plugins/ImageUpload/js/plupload.flash.swf',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"}
		]
	});

	uploader.bind('Init', function(up, params) {
		console.log("Current runtime: " + params.runtime );
	});

	uploader.init();

	uploader.bind('FilesAdded', function(uploader, files) {
		uploader.start();
		$('#imageupload_loading').show();
	});

	uploader.bind('FileUploaded',function(uploader,file,response){
		var data = $.parseJSON(response.response);
		var url = data.url;
		var filename = data.name.substr(0, data.name.lastIndexOf('.'));
		$('#Form_Body').focus();
		var inputFormat = getInputFormat();
		var imageCode;
		switch(inputFormat) {
			case 'Html':
				imageCode = '<img src="'+url+'" alt="'+filename+'" title="'+filename+'"/>\r\n';
				break;
			case 'BBCode':
				imageCode = '[img alt="'+filename+'" title="'+filename+'"]'+url+'[/img]\r\n';
				break;
			case 'Markdown':
				imageCode = '!['+filename+']('+url+' "'+filename+'")\r\n';
				break;
			default:
				imageCode = url+'\r\n';
				break;
		}
		
		if($('#Form_Body').data('wysihtml5')) { //check Wysihtml5
			var wysihtml5 = $('#Form_Body').data('wysihtml5').editor;
			wysihtml5.setValue(wysihtml5.getValue() + imageCode);
		}else {
			$('#Form_Body').val($('#Form_Body').val() + imageCode);
			var editor = $('#Form_Body').get(0).editor;
			if(editor) editor.updateFrame();
		}
	});

	uploader.bind('UploadComplete',function(uploader,files){
		$('#imageupload_loading').hide();
	});

	function getInputFormat() {
		var editor = $('#Form_Body').get(0).editor || $('#Form_Body').data('wysihtml5');
		if(editor) return 'Html';
		var format = $('#Form_Body').attr('format');
		if (!format) format = gdn.definition('ImageUpload_InputFormatter', 'Html');
		if (!format) format = gdn.definition('InputFormat', 'Html');
		if (format == 'Raw' || format == 'Wysiwyg') format = 'Html';
		return format;
	}
});