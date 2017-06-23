var CustomJs = function () {
    return {
        init: function () {
            $('#uploadForm').submit(function (event) {

                var formData = new FormData();
                formData.append('title', $('#title').val());
                formData.append('description', $('#description').val());
                formData.append("file", $("#file").prop('files')[0]);
                formData.append('user', $('#user').val());

                $.ajax({
                    type: 'POST',
                    url: '/api/picture',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        alert(data.data);
                        window.location.replace('v-2/user/' +  $('#user').val())
                    },
                    error: function (data) {
                        if (!$('#title').val()) {
                            alert('Title field cannot be empty !');
                        }
                        alert(data.data);
                    }
                });
                event.preventDefault();
            });
        }
    }
}();
