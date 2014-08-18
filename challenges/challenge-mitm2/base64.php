<?php

$decoded = '';
$encoded = '';
if(isset($_POST['encode']) && isset($_POST['decoded'])) {
// The user wants to encode some text.
	$decoded = $_POST['decoded'];
	$encoded = base64_encode($decoded);
} else if(isset($_POST['decode']) && isset($_POST['encoded'])) {
// The user wants to decode some text.
	$encoded = $_POST['encoded'];
	$decoded = base64_decode($encoded);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Base64 Encode/Decode</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script src="data/jquery.min.js"></script>
	<script src="data/bootstrap.min.js"></script>
	<link href="data/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
	<form method="post">
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading"><h1>Base64 Encode/Decode</h1></div>
					<div class="panel-body">
						<div class="col-lg-10">
							<div class="row">
								<div class="col-lg-6">
									<label for="privkey">Decoded</label><br>
									<small>
										<textarea name="decoded" rows="15" style="width:100%"><?= htmlspecialchars($decoded) ?></textarea>
									</small>
								</div>
								<div class="col-lg-6">
									<label for="pubkey">Encoded</label><br>
									<small>
										<textarea name="encoded" rows="15" style="width:100%"><?= htmlspecialchars($encoded) ?></textarea>
									</small>
								</div>
							</div>
							<div class="row">
								<label>&nbsp;</label><br>
								<button type="submit" name="encode" class="btn btn-primary">Encode</button>
								<button type="submit" name="decode" class="btn btn-primary">Decode</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>
