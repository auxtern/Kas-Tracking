$(document).on("change", ":file", function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, "/").replace(/.*\//, "");
    input.trigger("fileselect", [numFiles, label]);
});

// We can watch for our custom `fileselect` event like this
$(document).ready(function () {
    $(":file").on("fileselect", function (event, numFiles, label) {
        var input = $(this).parents(".input-group").find(":text"),
            log = numFiles > 1 ? numFiles + " files selected" : label;

        if (input.length) {
            input.val(log);
        } else {
           //
        }
    });
});

$(".dropify").dropify({
    messages: {
        default: "Drag and drop a picture here or click",
        replace: "Drag and drop or click to replace",
        remove: "Remove",
        error: "Ooops, something wrong appended.",
    },
    error: {
        fileSize: "The file size is too big (2M max).",
    },
});

var msg = $('.file-icon').html();
$('.file-icon').html("");
$('.dropify-message').append(msg);