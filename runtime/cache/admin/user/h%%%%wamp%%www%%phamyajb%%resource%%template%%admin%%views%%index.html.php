<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php echo $this->tag->getTitle(); ?>
        <?php echo $this->tag->stylesheetLink('css/bootstrap.min.css'); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Your invoices">
        <meta name="author" content="Phalcon Team">
          <?php echo $this->tag->javascriptInclude('js/jquery.min.js'); ?>
        <?php echo $this->tag->javascriptInclude('js/bootstrap.min.js'); ?>
        <?php echo $this->tag->javascriptInclude('js/utils.js'); ?>
    </head>
    <body>
        <?php echo $this->getContent(); ?>
      
    </body>
</html>