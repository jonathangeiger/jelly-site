<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
  <head>
    <title><?php echo $title ?></title>
	<?php echo HTML::style('css/screen.css') ?>
  </head>
  <body>
  	<div id="container">
  		<?php if (isset($menu) AND ! empty($menu)) : ?>
			<ul class="breadcrumb">
			<?php foreach ($breadcrumb as $link => $title): ?>
				<li><?php echo is_int($link) ? $title : HTML::anchor($link, $title) ?></li>
			<?php endforeach ?>
			</ul>
			
			<div id="menu">
				<?php echo $menu ?>
			</div>
		<?php endif; ?>
		
  		<?php echo $content ?>
  	</div>
  </body>
</html>
