<?php require ('../../../../../wp-load.php'); ?>
<!doctype html>
<head>
    <link rel='stylesheet' href='<?php echo get_stylesheet_uri() ?>' />

    <style>
        body {
            background : transparent !important;
            margin: 0 !important;
        }
    </style>
    
    <script type='javascript'>
        function upload_start() {
            ;
        }
    </script>
</head>
<body>
    <form target='hiddenframe' enctype='multipart/form-data'
    action='<?php echo ecu_plugin_url() . 'upload.php' ?>'
    method='POST' name='uploadform' id='uploadform'>
        <?php wp_nonce_field('ecu_upload_form') ?>
        <label for='file' name='prompt'>
	    <?php _e('Select File') ?>:
	</label>
        <input type='file' name='file' id='file'
            onchange="document.getElementById('uploadform').style.display
	        = 'none';
            document.getElementById('loading').style.display = 'block';
            document.uploadform.submit();
            document.uploadform.file.value = ''" />
    </form>

    <div align='center'>
        <img src='loading.gif' style='display: none' id='loading' />
    </div>

    <iframe name='hiddenframe' style='display : none' frameborder='0'></iframe>
</body>
