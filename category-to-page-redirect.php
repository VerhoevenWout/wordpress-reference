<!-- 301 redirects do not work from archives to pages, rather do it this way -->
<!-- Put this on the top of the archives page -->
<?php
  if(is_category( 'Category Title' )) {
  $pagelink=get_page_link (get_page_by_title( 'Page Title' ));
  header("Location: $pagelink",TRUE,301);
  }
?>

<!-- Example -->
<?php
	if(is_category( 'weekly-newsletter' )) {
	$pagelink=get_page_link(get_page_by_title( 'Weekly Newsletter' ));
	header("Location: $pagelink",TRUE,301);
	}
?>
