$(document).ready(function() {

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square' //circle or square
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $('#photo_profile').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function() {
                //console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#upload_modal').modal('show');
    });


    $('.pangkas_photo').on('click', function(event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response) {
            $('#photo').val(response);
            $('#form_photo_profile').submit();
        })
    });
});


function biodataSetValue(jenisKelamin, provinsi) {
    if(jenisKelamin == 'Laki-Laki'){
        $('#jklk').attr('checked', true);
    }else{
        $('#jkpr').attr('checked', true);
    }

    $('#provinsi').val(provinsi);
}
    
