<?php
class Login extends Controller {
		public function index() {
				if (session_status() === PHP_SESSION_NONE) session_start();

				if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
						header("Location: /home");
						exit;
				}

				$this->view('login/index');
		}


		public function verify() {
				if (session_status() === PHP_SESSION_NONE) session_start();

				if (!isset($_POST['username'], $_POST['password'])) {
						die('Form input missing.');
				}

				$username = $_POST['username'];
				$password = $_POST['password'];

				$db = db_connect();
				$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
				$stmt->execute([':username' => $username]);
				$user = $stmt->fetch(PDO::FETCH_ASSOC);

				if ($user && password_verify($password, $user['password'])) {
						$_SESSION['auth'] = 1;
						$_SESSION['username'] = $user['username'];

						$log = $db->prepare("INSERT INTO log (username, attempt) VALUES (:username, 'good')");
						$log->execute([':username' => $username]);


						ob_clean(); 
						header("Location: /home");
						exit;
				} else {
						$log = $db->prepare("INSERT INTO log (username, attempt) VALUES (:username, 'bad')");
						$log->execute([':username' => $username]);

						ob_clean();
						header("Location: /login");
						exit;
				}
		}
}