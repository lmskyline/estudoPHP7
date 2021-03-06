<?php
// demonstrates form processing with token

session_start();
// form which is unprotected from CSRF attacks
define('DB_CONFIG_FILE', '/../data/config/db.config.php');

// setup class autoloading
require __DIR__ . '/../../Application/Autoload/Loader.php';

// add current directory to the path
Application\Autoload\Loader::init(__DIR__ . '/../..');

use Application\Database\Connection;
$conn = new Connection(include __DIR__ . DB_CONFIG_FILE);

if ($_POST['process']) {

	// process tokens
	$sessToken = $_SESSION['token'] ?? 1;
	$postToken = $_POST['token'] ?? 2;

	// invalidate token stored in session
	unset($_SESSION['token']);

	if ($sessToken != $postToken) {
		$_SESSION['message'] = 'ERROR: token mismatch';
	} else {
		$_SESSION['message'] = 'SUCCESS: form processed';

		$filter = [
			'trim' => function ($item) { return trim($item); },
			'email' => function ($item) { return filter_var($item, FILTER_SANITIZE_EMAIL); },
			'length' => function ($item, $length) { return substr($item, 0, $length); },
			'stripTags' => function ($item) { return strip_tags($item); },
		];

		$assignments = [
			'*'			=> ['trim' => NULL, 'stripTags' => NULL],
			'email' 	=> ['length' => 249, 'email' => NULL],
			'name' 	    => ['length' => 128],
			'comments' 	=> ['length' => 249],
		];

		$data = $_POST;
		foreach ($data as $field => $item) {
			foreach ($assignments['*'] as $key => $option) {
				$item = $filter[$key]($item, $option);
			}
			if (isset($assignments[$field])) {
				foreach ($assignments[$field] as $key => $option) {
					$item = $filter[$key]($item, $option);
				}
				$filteredData[$field] = $item;
			}
		}
		try {
			$filteredData['visit_date'] = date('Y-m-d H:i:s');
			$sql = 'INSERT INTO visitors (email,name,comments,visit_date) VALUES (:email,:name,:comments,:visit_date)';
			$insertStmt = $conn->pdo->prepare($sql);
			$insertStmt->execute($filteredData);
		} catch (PDOException $e) {
			error_log(__FILE__ . ':' . $e->getMessage());
			// take appropriate action
		}
	}
}

header('Location: form_view_results.php');
exit;
