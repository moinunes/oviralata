<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>jQuery File Upload Example</title>
</head>
<body>


   xxxxxxxxxxxxx
   xxxxxxxxxx
<input id="fileupload" type="file" name="files[]" data-url="server/php/" multiple>

<script src="./dist/js/jquery-3.3.1.min.js"></script>

<script src="dist/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="dist/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="dist/jquery_file_upload/js/jquery.fileupload.js"></script>
<script>

$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {

                $('<p/>').text(file.name).appendTo(document.body);
                alert(file.name)

            });
        }
    });
});
</script>
</body> 
</html>