<?php
class Database
{
    /**
     * host.
     *
     * @var string
     */
    private $host = 'localhost';

    /**
     * dbname.
     *
     * @var string
     */
    private $dbname = 'pantherfinder';

    /**
     * username.
     *
     * @var string
     */
    private $username = 'root';

    /**
     * password.
     *
     * @var string
     */
    private $password = '';
    /**
     * pdo.
     */
    private $pdo;

    /**
     * __construct.
     *
     * @return void
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            $this->createAdminsTable();
        } catch (PDOException $e) {
            exit('Database Connection Failed: ' . $e->getMessage());
        }
    }

    /**
     * createAdminsTable.
     *
     * @return void
     */
    private function createAdminsTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) UNIQUE NOT NULL,
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )';
        $this->pdo->exec($sql);
    }
}
