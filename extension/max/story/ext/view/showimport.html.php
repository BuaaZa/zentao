<?php include $app->getModuleRoot() . 'port/view/showimport.html.php';?>
<?php js::set('forceReview', $forceReview)?>
<?php echo js::set('storyType', $type);?>
<script>
if(forceReview) $('#reviewer').addClass('required');
</script>
