//////////// IMAGE UPLOAD IN LUGGAGE

jQuery(document).ready(function($) {
    $('#upload-button').on('click', function(e) {
        e.preventDefault();
        var fileInput = $('<input type="file" name="image" accept="image/*" style="display: none;">');
        $('body').append(fileInput);
        
        fileInput.on('change', function() {
            var file = this.files[0];
            var formData = new FormData();
            formData.append('action', 'handle_image_upload');
            formData.append('nonce', upload_vars.nonce);
            formData.append('image', file);

            $.ajax({
                url: ajaxurl, // Используем глобальную переменную ajaxurl
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert(response.data.message);
                        // Здесь вы можете добавить код для отображения загруженного изображения
                    } else {
                        alert(response.data);
                    }
                },
                error: function() {
                    alert('Произошла ошибка при загрузке файла');
                }
            });

            $(this).remove(); // Удаляем временный input после загрузки
        });

        fileInput.click();
    });
});