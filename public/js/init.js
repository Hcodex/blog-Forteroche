
feather.replace();

$(window).scroll(function () {
    $('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
});

tinymce.init({
    selector: '.tinyMCE',
    plugins: 'code autoresize',
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent  |' + 'forecolor backcolor emoticons | help |' + 'code',
    toolbar_mode: 'floating',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
});

$("#img-select-btn").click(function () {
    $("#picture_file_name").val($('.custom-select>option[selected="selected"]').attr('data-filename'));
    $("#picked_img").attr('src', $(".img-select.selected").attr('src'));
    $('#image_manager').modal('hide');

});

$("#img-list").on('click', '.img-select', function () {
    $val = $(this).attr('data-img')
    $('.custom-select>option[data-filename="' + $val + '"]').attr('selected') ?
        $('.custom-select>option[data-filename="' + $val + '"]').removeAttr('selected') : $('.custom-select>option[data-filename="' + $val + '"]').attr('selected', 'selected');
    $(this).toggleClass('border border-primary selected');
    $('.img-select.selected').length == 1 ?
        $("#img-select-btn").removeClass('disabled') : $("#img-select-btn").addClass('disabled', 'disabled');
    $('.custom-select>option[selected="selected"]').length < 1 ?
        $(".img-delete-btn").attr('disabled', 'disabled') : $(".img-delete-btn").removeAttr('disabled');
});

$('.custom-file input').change(function (e) {
    if (e.target.files.length) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
    }
});

$('#image_manager').on('hide.bs.modal', function (e) {
    $('.img-select.selected').removeClass('selected border-primary border');
    $('.custom-select>option').removeAttr('selected')
});

function setConfirmModal(data, message) {
    event.preventDefault();
    $("#confirmModal #confirmBtn").attr('href', data);
    $("#confirmModal .modal-body").html('<p>' + message + '</p>');
    $("#confirmModal").modal();
}

$('.comment-text-area').on("input", function () {
    var maxlength = $(this).attr("maxlength");
    var currentLength = $(this).val().length;

    if (currentLength >= maxlength) {
        $('#char_counter').text(currentLength + "/" + maxlength + 'max')
        $('#char_counter').removeClass('text-muted');
        $('#char_counter').addClass('text-danger');
    } else {
        $('#char_counter').text(currentLength + "/" + maxlength + 'max')
        $('#char_counter').addClass('text-muted');
        $('#char_counter').removeClass('text-danger');
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})



$("#uploadForm").submit(function (e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: 'index?route=ajax',
        data: new FormData(this),
        contentType: false,
        processData: false,
        xhr: function () {
            //upload Progress
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    var position = event.loaded || event.position;
                    var total = event.total;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                        $('.progress').removeClass('d-none');
                    }
                    if (percent == 100) {
                        $('.progress-bar').text("Envoi terminé, compression en cours...");
                        $('.progress-bar').width(percent + "%");
                        $('.progress-bar').addClass('progress-bar-striped progress-bar-animated');

                    } else {
                        $('.progress-bar').text(percent + "%");
                        $('.progress-bar').width(percent + "%");
                    }
                }, true);
            }
            return xhr;
        },
        //end upload progress
        success: function (data) {
            $('.progress-bar').removeClass('progress-bar-striped progress-bar-animated');
            $('.progress-bar').text("Terminé");
            const response = JSON.parse(data);
            if (response["success"] === true) {
                showAlert("<strong>Upload réussi</strong>", "success", 5000);
                $('#image_manager #file_selector').append('<option value="' + response["imageThumbail"] + '" data-filename="' + response["imageName"] + '"></option>');
                $('#image_manager #file_selector').append('<option value="' + response["imageSrc"] + '" data-filename="' + response["imageName"] + '"></option>');
                $('#image_manager #uploaded-img-list').append('<img class="img-select" alt="" src="' + response["imageThumbail"] + '" style=" max-width : 100%; max-height:80px" data-img="' + response["imageName"] + '">');

            } else {
                showAlert(response["errorMessage"], "danger", 5000);
            }
        },
        error: function () {
            showAlert("<strong>Erreur</strong>, la reqête n'a pu aboutir", "danger", 5000);
        }
    });
});

$("#filesDelete").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'index?route=ajaxFilesDelete',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            const response = JSON.parse(data);
            if (response["success"] === true) {
                showAlert("<strong>Supression réussie</strong>", "success", 5000);
                $('#image_manager #file_selector>option[selected="selected"]').remove();
                $('#image_manager #uploaded-img-list .selected').remove();
            } else {
                showAlert(response["errorMessage"], "danger", 5000);
            }
        },
        error: function () {
            showAlert("<strong>Erreur</strong>, la reqête n'a pu aboutir", "danger", 5000);
        }
    });
});

function showAlert(message, type, closeDelay) {

    var $cont = $("#alerts-container");

    if ($cont.length == 0) {
        // alerts-container does not exist, create it
        $cont = $('<div id="alerts-container" class="msg-box">')
            .appendTo($("body"));
    }

    // default to alert-info; other options include success, warning, danger
    type = type || "info";

    // create the alert div
    var alert = $('<div>')
        .addClass("fade in show alert alert-" + type)
        .append(
            $('<button type="button" class="close" data-dismiss="alert">')
                .append("&times;")
        )
        .append(message);

    // add the alert div to top of alerts-container, use append() to add to bottom
    $cont.prepend(alert);

    // if closeDelay was passed - set a timeout to close the alert
    if (closeDelay)
        window.setTimeout(function () { alert.alert("close") }, closeDelay);
}














