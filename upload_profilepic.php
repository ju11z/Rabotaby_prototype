<?php require 'db_connect.php';

if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}

?>
    <input id="sortpicture" type="file" name="sortpic" />
    <button id="upload">Upload</button>

    <script src="js/jquery.js"></script>
    <script>
    /*
    * $.ajax({
            type: "POST",
            url: 'functions/print_skills.php',
            data: {resume_id:resume_id},
            success: function(response)
            {
                console.log(response);
                $('#resume_skills').html(response);
            },
            error: function () {
            }
        });
    * */


            $('#upload').on('click', function() {
                alert('dude?');
                var file_data = $('#sortpicture').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                //alert(form_data);

                /*
                $.ajax({
                    type: "POST",
                    url: 'functions/upload_img.php',
                    data: {form_data:form_data},
                    success: function(php_script_response)
                    {
                        alert(php_script_response); // <-- display response from the PHP script, if any
                    },
                    error: function () {
                    }
                });
                */


                $.ajax({
                    url: 'functions/upload_img.php', // <-- point to server-side PHP script
                    dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(php_script_response){
                        alert(php_script_response); // <-- display response from the PHP script, if any
                    }
                });


            });

    </script>
<?php

