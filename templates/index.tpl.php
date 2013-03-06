<html>
<head>
<title>Redact-o-Matic!</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="templates/css/redact.css" rel="stylesheet" type="text/css" media="all" />
</head>
<html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="templates/js/redact.js"></script>
<div class="header">
<h2>What is this?</h2>
<p>Redact-o-Matic reads the Twitter stream and 'redacts' any tweets with the hashtag #redacted.</p>
<p>All redacted tweets link back to their source.</p>
<p>Important: NOT AFFILIATED WITH TWITTER IN ANY WAY. :-)</p>
<p>Reload the page to see updates. Want to play along with development? <a href="https://github.com/paul-m/redactomatic">Try here</a>.</p>
</div>
<div class="redactedStatuses">
<?php echo $redactedStatuses ?>
</div>
</html>

