<?php

// Includes and starts the PHP library for RSA:
set_include_path(get_include_path().PATH_SEPARATOR .'phpseclib');
include('Crypt/RSA.php');
$rsa = new Crypt_RSA();
$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);

$privateKey = '';
$publicKey = '';
$input = '';
$output = '';
if(isset($_POST['generate'])) {
// The users requested new public/private keys.
	$keys = $rsa->createKey();
	$privateKey = $keys['privatekey'];
	$publicKey = $keys['publickey'];

} else if(isset($_POST['private_key']) && isset($_POST['public_key'])) {
	$privateKey = $_POST['private_key'];
	$publicKey = $_POST['public_key'];

	if(isset($_POST['encrypt'])) {
	// The user wants to encrypt some text.
		$input = $_POST['input'];
		$rsa->loadKey($publicKey);
		$output = base64_encode($rsa->encrypt($input));
	} else if(isset($_POST['decrypt'])) {
	// The user wants to decrypt some text.
		$output = $_POST['output'];
		$rsa->loadKey($privateKey);
		$input = $rsa->decrypt(base64_decode($output));
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>RSA Encrypt/Decrypt</title>
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
					<div class="panel-heading"><h1>RSA Encrypt/Decrypt</h1></div>
					<div class="panel-body">
						<div class="col-lg-10">
							<div class="row">
								<div class="col-lg-6">
									<label for="privkey">Private Key</label><br>
									<small>
										<textarea name="private_key" rows="15" style="width:100%"><?= htmlspecialchars($privateKey) ?></textarea>
									</small>
								</div>
								<div class="col-lg-6">
									<label for="pubkey">Public Key</label><br>
									<small>
										<textarea name="public_key" rows="15" style="width:100%"><?= htmlspecialchars($publicKey) ?></textarea>
									</small>
								</div>
							</div>
							<div class="row">
								<label>&nbsp;</label><br>
								<button type="submit" name="generate" class="btn btn-primary">Generate new keys</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3>RSA Encryption Test</h3>
					</div>
					<div class="panel-body">
						<div class="col-lg-5">
							<label for="input">Text to encrypt:</label><br>
							<small>
								<textarea id="input" name="input" style="width: 100%" rows="4"><?= htmlspecialchars($input) ?></textarea>
							</small>
						</div>
						<div class="col-lg-2">
							<label>&nbsp;</label><br>
							<button type="submit" name="encrypt" class="btn btn-primary">Encrypt</button>
							<button type="submit" name="decrypt" class="btn btn-primary">Decrypt</button>
						</div>
						<div class="col-lg-5">
							<label for="output">Encrypted (base64):</label><br>
							<small>
								<textarea name="output" style="width: 100%" rows="4"><?= htmlspecialchars($output) ?></textarea>
							</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>
