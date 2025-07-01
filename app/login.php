<?php
class Login extends Controller {
		public function index() {
				$this->view('login');
		}

		public function check() {
				$username = $_POST['username'] ?? '';
				$password = $_POST['password'] ?? '';
				$userModel = new User();
				$user = $userModel->find($username);

				if (!isset($_SESSION['login_attempts'])) {
						$_SESSION['login_attempts'] = [];
				}

				$now = time();
				$attempts = $_SESSION['login_attempts'][$username] ?? [];
				$attempts = array_filter($attempts, fn($t) => $now - $t < 60);
				$_SESSION['login_attempts'][$username] = $attempts;

				if (count($attempts) >= 3) {
						echo "Account locked. Try again in 60 seconds.";
						return;
				}

				if ($user && password_verify($password, $user['password'])) {
						$_SESSION['auth'] = 1;
						$_SESSION['username'] = $username;
						$this->log_attempt($username, 'good');
						$_SESSION['login_attempts'][$username] = [];
						header("Location: /home");
				} else {
						$this->log_attempt($username, 'bad');
						$_SESSION['login_attempts'][$username][] = $now;
						header("Location: /login");
				}
		}

		public function create() {
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						$username = $_POST['username'] ?? '';
						$password = $_POST['password'] ?? '';
						$userModel = new User();
						$userModel->create($username, $password);
						header("Location: /login");
				} else {
						$this->view('register');
				}
		}
	public function logout() {
			session_destroy();
			header('Location: /login');
			exit;
	}

		private function log_attempt($username, $attempt) {
				$db = db_connect();
				$stmt = $db->prepare("INSERT INTO log (username, attempt, time) VALUES (:u, :a, NOW())");
				$stmt->execute([':u' => $username, ':a' => $attempt]);
		}
}
