jQuery.fn.exists = function () {
    return jQuery(this).length > 0;
}
jQuery(document).ready(function($) {
 
    if($(".plupload-upload-uic").exists()) {
        var pconfig=false;
        $(".plupload-upload-uic").each(function() {
            var $this=$(this);
            var id1=$this.attr("id");
            var imgId=id1.replace("plupload-upload-ui", "");
 
            plu_show_thumbs(imgId);
 
            pconfig=JSON.parse(JSON.stringify(base_plupload_config));
 
            pconfig["browse_button"] = imgId + pconfig["browse_button"];
            pconfig["container"] = imgId + pconfig["container"];
            pconfig["drop_element"] = imgId + pconfig["drop_element"];
            pconfig["file_data_name"] = imgId + pconfig["file_data_name"];
            pconfig["multipart_params"]["imgid"] = imgId;
            pconfig["multipart_params"]["_ajax_nonce"] = $this.find(".ajaxnonceplu").attr("id").replace("ajaxnonceplu", "");
 
            if($this.hasClass("plupload-upload-uic-multiple")) {
                pconfig["multi_selection"]=true;
            }
 
            if($this.find(".plupload-resize").exists()) {
                var w=parseInt($this.find(".plupload-width").attr("id").replace("plupload-width", ""));
                var h=parseInt($this.find(".plupload-height").attr("id").replace("plupload-height", ""));
                pconfig["resize"]={
                    width : w,
                    height : h,
                    quality : 90
                };
            }
 
            var uploader = new plupload.Uploader(pconfig);
 
            uploader.bind('Init', function(up){
 //alert(1);
                });
 
            uploader.init();
 
 
 
 			uploader.bind('Error', function(up, files){
			if(files.code == -600){	alert(files.message+ ' : You tried to upload a image over 2mb');}
			else{alert(files.message);}
			});
			
            // a file was added in the queue
			totalImg = 0;
			limitImg = 3;
            uploader.bind('FilesAdded', function(up, files){
			
			//totalImg = totalImg + up.files.length;
			
			if(limitImg){
				
				if(totalImg==limitImg){
				while(up.files.length > 0) {up.removeFile(up.files[0]);} // remove images
				alert('You have reached your upload limit of '+limitImg);
				return false;
				}
				
				if(up.files.length>limitImg){
				while(up.files.length > 0) {up.removeFile(up.files[0]);} // remove images
				alert('You may only upload '+limitImg+' with this package, please try again.');
				return false;
				}
				
				if(up.files.length+totalImg>limitImg){
				while(up.files.length > 0) {up.removeFile(up.files[0]);} // remove images
				alert('You may only upload another '+(limitImg-totalImg)+' with this package, please try again.');
				return false;
				}
				
				
				
				
			
			
			
			}
	
	
		 
                $.each(files, function(i, file) {
                    $this.find('.filelist').append(
                        '<div class="file" id="' + file.id + '"><b>' +
 
                        file.name + '</b> (<span>' + plupload.formatSize(0) + '</span>/' + plupload.formatSize(file.size) + ') ' +
                        '<div class="fileprogress"></div></div>');
                });
 
                up.refresh();
                up.start();
            });
 
            uploader.bind('UploadProgress', function(up, file) {
 
                $('#' + file.id + " .fileprogress").width(file.percent + "%");
                $('#' + file.id + " span").html(plupload.formatSize(parseInt(file.size * file.percent / 100)));
            });
 
            // a file was uploaded
            uploader.bind('FileUploaded', function(up, file, response) {
 
totalImg++;
up.removeFile(up.files[0]); // remove images

                $('#' + file.id).fadeOut();
                response=response["response"]
                // add url to the hidden field
                if($this.hasClass("plupload-upload-uic-multiple")) {
                    // multiple
                    var v1=$.trim($("#" + imgId).val());
                    if(v1) {
                        v1 = v1 + "," + response;
                    }
                    else {
                        v1 = response;
                    }
                    $("#" + imgId).val(v1);
                }
                else {
                    // single
                    $("#" + imgId).val(response + "");
                }
 
                // show thumbs 
                plu_show_thumbs(imgId);
            });
 
 
 
        });
    }
});
 
function plu_show_thumbs(imgId) {
    var $=jQuery;
    var thumbsC=$("#" + imgId + "plupload-thumbs");
    thumbsC.html("");
    // get urls
    var imagesS=$("#"+imgId).val();
    var images=imagesS.split(",");
    for(var i=0; i<images.length; i++) {
        if(images[i]) {
            var thumb=$('<div class="thumb" id="thumb' + imgId +  i + '"><img src="' + images[i] + '" alt="" /><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#">Remove</a></div> <div class="clear"></div></div>');
            thumbsC.append(thumb);
            thumb.find("a").click(function() {
				alert('del');
				totalImg--;// remove image from total
				alert(totalImg);
                var ki=$(this).attr("id").replace("thumbremovelink" + imgId , "");
                ki=parseInt(ki);
                var kimages=[];
                imagesS=$("#"+imgId).val();
                images=imagesS.split(",");
                for(var j=0; j<images.length; j++) {
                    if(j != ki) {
                        kimages[kimages.length] = images[j];
                    }
                }
                $("#"+imgId).val(kimages.join());
                plu_show_thumbs(imgId);
                return false;
            });
        }
    }
    if(images.length > 1) {
        thumbsC.sortable({
            update: function(event, ui) {
                var kimages=[];
                thumbsC.find("img").each(function() {
                    kimages[kimages.length]=$(this).attr("src");
                    $("#"+imgId).val(kimages.join());
                    plu_show_thumbs(imgId);
                });
            }
        });
        thumbsC.disableSelection();
    }
}