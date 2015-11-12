<?php

define("PRE_CODE", "
<!DOCTYPE HTML>
<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<title></title>
	<link rel='stylesheet' href='/styles/default.css' type='text/css' />
</head>
<body>
");
define("POST_CODE", "
</body>
</html>
");


if (isset($_POST['mode']) && $_POST['mode'] === 'sass_edit') {
	
	file_put_contents(dirname(__FILE__).'/styles/default.sass', $_POST['code']);
	
	$sass_path = dirname(__FILE__).'/styles/default.sass';
	$css_path = dirname(__FILE__).'/styles/default.css';
	$command = "sass ".$sass_path.":". $css_path;
	
	exec($command);
}

if (isset($_POST['mode']) && $_POST['mode'] === 'html_edit') {
	file_put_contents(dirname(__FILE__).'/page.html.data', $_POST['code']);
	file_put_contents(dirname(__FILE__).'/page.html', PRE_CODE.$_POST['code'].POST_CODE);
}

$sass_code = "";
if (file_exists( dirname(__FILE__).'/styles/default.sass')) {
	$sass_code = file_get_contents(dirname(__FILE__).'/styles/default.sass');
}

$html_code = "";
if (file_exists( dirname(__FILE__).'/styles/default.sass')) {
	$html_code = file_get_contents(dirname(__FILE__).'/page.html.data');
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SASS compiler</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />
	<style>
		.editor {
			width: 900px;
		}
	</style>
</head>
<body>
    <div class="container">
    	<header>
    		<h1>SASS compiler</h1>
    	</header>
		<div>
			<a class='btn btn-success' href='/page.html' target='_blank'>PREVIEW</a>
		</div>
    	<section>
			<h2>HTML</h2>
			<form action="/index.php" method="post">
				<div>
				<?php echo nl2br(htmlspecialchars(PRE_CODE , ENT_QUOTES, 'UTF-8')); ?>
					<textarea class='editor' id="html_code" name="code" rows="10" cols="30"><?php echo $html_code; ?></textarea>
				<?php echo nl2br(htmlspecialchars(POST_CODE , ENT_QUOTES, 'UTF-8')); ?>
				</div>
				<input type="hidden" name="mode" value="html_edit"/>
				<div>
					<button class='btn default'>submit</button>
				</div>
			</form>
    	</section>
    	<section>
			<h2>SASS</h2>
			<form action="/index.php" method="post">
				<div>
					<textarea class='editor' id="sass_code" name="code" rows="10" cols="30"><?php echo $sass_code; ?></textarea>
				</div>
				<input type="hidden" name="mode" value="sass_edit"/>
				<div>
					<button class='btn default'>submit</button>
				</div>
			</form>
		</section>
	</div>
</body>
</html>
