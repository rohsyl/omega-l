var dropzone = $("#dropzone");

var uploader = new plupload.Uploader({
    browse_button: 'browse',
    drop_element: 'dropzone',
    url: $('#upload-url').val(),
    multipart_params : {
        "_token" : $('meta[name="csrf-token"]').attr('content'),
        'parent' : $('#upload-parent').val()
    }
});

uploader.init();

uploader.bind('init', function(up, params) {

    var onDragEnter = function(event) {
            event.preventDefault();
            dropzone.addClass("dragover");
        },

        onDragOver = function(event) {
            event.preventDefault();
            if(!dropzone.hasClass("dragover"))
                dropzone.addClass("dragover");
        },

        onDragLeave = function(event) {
            event.preventDefault();
            dropzone.removeClass("dragover");
        },

        onDrop = function(event) {
            event.preventDefault();
            dropzone.removeClass("dragover");
        };

    dropzone
        .on("dragenter", onDragEnter)
        .on("dragover", onDragOver)
        .on("dragleave", onDragLeave)
        .on("drop", onDrop);
});

uploader.bind('FilesAdded', function(up, files) {
    var html = '';
    plupload.each(files, function(file) {
        html += '<tr>\
				<td id="image_'+file.id+'"></td>\
				<td>' + file.name + '</td>\
				<td>' + plupload.formatSize(file.size) + '</td>\
				<td>\
					<div class="progress" style="width:80px !important;" >\
				  		<div id="progress_'+file.id+'" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">\
				  		</div>\
					</div>\
					<div id="pourcent_'+file.id+'"></div>\
				</td>\
			</tr>';
    });
    document.getElementById('filelist').innerHTML += html;
});

uploader.bind('UploadProgress', function(up, file) {
    $('#pourcent_'+file.id).html(file.percent+"%");
    $('#progress_'+file.id).css("width", file.percent+"%");
});

uploader.bind('Error', function(up, err) {
    console.log(up, err);
    $('#pourcent_'+err.file.id).html(err.message);
    $('#progress_'+err.file.id).addClass('progress-bar-danger').removeClass('progress-bar-success').removeClass('active');
    /*console.log(up, err);
    for(var i = 0; i < up.files.length; i++){
        if(up.files[i].status == 4){
            console.log(up.files[i].id);
            $('#pourcent_'+up.files[i].id).html("Error, the file is too big...");
            $('#progress_'+up.files[i].id).addClass('progress-bar-danger').removeClass('progress-bar-success').removeClass('active');
        }
    }*/
    omega.notice.success(__('Error'), err.code + ": " + err.message);
});

uploader.bind('FileUploaded', function(up, file, res) {
    console.log(res);
    json = $.parseJSON(res.response);
    console.log(json);
    if(json.success)
    {
        $('#image_'+file.id).append('<a href="'+json.url+'"><img width="80" src="'+json.url+'" alt="'+file.name+'" /></a>');
        $('#pourcent_'+file.id).html(__('Ok'));
    }
    else
    {
        $(".progress-bar").addClass('progress-bar-danger')
            .removeClass('progress-bar-success')
            .removeClass('active');

        $('#pourcent_'+file.id).html(json.message);
    }
});

uploader.bind('UploadComplete', function() {
    console.log('uplaoded');
    omega.notice.success(undefined, __('Upload completed !'));
});

$('#start-upload').click(function() {
    uploader.start();
});