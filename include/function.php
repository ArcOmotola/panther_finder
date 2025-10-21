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
            $this->CategoryTable();
            $this->ColorTable();
            $this->UsersTable();
            $this->ClaimantTable();
            $this->FinderReportsTable();
            $this->FinderClaimants();
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

    public function CategoryTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description VARCHAR(255) NULL,
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )';
        $this->pdo->exec($sql);
    }

    public function ColorTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS colors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )';
        $this->pdo->exec($sql);
    }

    public function UsersTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(255) NULL,
            address VARCHAR(255)  NULL,
            profile VARCHAR(255) NULL,
            country_id INT NOT NULL,
            state_id INT NOT NULL,
            city VARCHAR(255) NULL,
            role ENUM("finder", "loser") DEFAULT "finder",
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
            FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE CASCADE
        )';
        $this->pdo->exec($sql);
    }

    public function FinderReportsTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS finder_reports (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL UNIQUE,
            image VARCHAR(255) NOT NULL,
            phone VARCHAR(255) NULL,
            category_id INT NOT NULL,
            color_id INT NOT NULL,            
            role ENUM("pending", "logged", "delivered") DEFAULT "pending",
            visibility ENUM("public", "private") DEFAULT "public",
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
            FOREIGN KEY (color_id) REFERENCES colors(id) ON DELETE CASCADE
        )';
        $this->pdo->exec($sql);
    }

    public function ClaimantTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS claimant_reports (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL UNIQUE,
            image VARCHAR(255) NOT NULL,
            phone VARCHAR(255) NULL,
            category_id INT NOT NULL,
            color_id INT NOT NULL,            
            role ENUM("pending", "logged", "delivered") DEFAULT "pending",
            visibility ENUM("public", "private") DEFAULT "public",
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
            FOREIGN KEY (color_id) REFERENCES colors(id) ON DELETE CASCADE
        )';
        $this->pdo->exec($sql);
    }

    public function FinderClaimants()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS finder_claimants (
            id INT AUTO_INCREMENT PRIMARY KEY,
            finder_report_id INT NOT NULL,
            claimant_report_id INT NOT NULL,
            match_percentage VARCHAR(255) DEFAULT 0,
            admin_comment VARCHAR(255) NULL,
            match_status ENUM("pending", "approved", "declined") DEFAULT "pending",
            smart_pin VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (finder_report_id) REFERENCES finder_reports(id) ON DELETE CASCADE,
            FOREIGN KEY (claimant_report_id) REFERENCES claimant_reports(id) ON DELETE CASCADE
        )';
        $this->pdo->exec($sql);
    }

    // Method to execute SELECT queries
    public function fetchAll($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Method to execute single row SELECT queries
    public function fetch($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // Method to execute INSERT, UPDATE, DELETE queries
    public function execute($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    // Get last inserted ID
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function CheckLogin()
    {
        if (isset($_SESSION['last_login_time'])) {
            return true;
        } else {
            return false;
        }
    }
}
