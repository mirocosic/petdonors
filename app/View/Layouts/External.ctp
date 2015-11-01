<!DOCTYPE html>
<html>
    <head>
        <title>PetDonors.org</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
         <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        
         <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
        <!-- load fonts -->
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/fonts.css"/>
        
        <!-- load custom css overrides -->
        <link rel="stylesheet" href="/css/styles.css"/>
           
        <style>
             body {background-color: cornsilk;}
        </style>
        
    </head>
    <body>
        <div id="container">
            <div id="content">

                <?php echo $this->element('Menu');?>

                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </body>
</html>

<script>
    $('ul.nav > li > a[href="' + document.location.pathname + '"]').parent().addClass('active');
</script>

       