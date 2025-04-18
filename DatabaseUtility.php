<?php
require_once 'config.php';
class DatabaseUtility
{
public ?PDO $pdo = null; // https://www.php.net/manual/en/class.pdo.php PDO object for database connection
private ?PDOStatement $_last_prepared = null;

    function __construct(string $dsn, string $username, string $password )
    {
        if (IS_DEBUG) {echo "new DatabaseUtility started<br>";}
        try {
            $this->pdo = new PDO($dsn, $username, $password );
        } catch (PDOException $e) { $e->errorInfo ;}
    }

    public function prepare(string $statement) : array   {
        if (IS_DEBUG) {echo "DatabaseUtility prepare statement: "; nl_dump($statement);}
        try {
            $this->_last_prepared = $this->pdo->prepare($statement);
            if (IS_DEBUG) {nl_dump($this->_last_prepared);}
        } catch (Exception $e) {
            return [0, 'prepare failed', $e->getMessage()];
        }
        return [1, 'prepare successful'];
    }
    public function execute(array $param = []): array
    {
        $attempt = false;
        if (IS_DEBUG) {echo "DatabaseUtility execute param: "; nl_dump($param);}
        try {
            $attempt = $this->_last_prepared->execute($param);
             } catch (Exception $e) {
            return [0, 'execute failed', $e->getMessage()];
        }
        if ($attempt) {return  [1, 'execute success'];}
        return [0, 'execute failed', $this->errorInfo()];
    }

    public function get_last_results(): array
    {
        if (IS_DEBUG) {echo "DatabaseUtility->get_last_results "; nl_dump(get_class($this->_last_prepared));}
        try {
            return [1, 'fecthAll success', $this->_last_prepared->fetchAll() ];
        } catch (Exception $e) {
            return [1, 'fecthAll fail', $e->getMessage()];
        }
    }
    public function get_full_table(string $table_name) : array {
        if (IS_DEBUG) {echo "DatabaseUtility->get_full_table table_name:"; nl_dump($table_name); };
        $results = [];
        try {
            $results = $this->prepare("SELECT * FROM " . $table_name);
            if (IS_DEBUG) {nl_dump($results);}
            if ($results[0]) {
                $results = $this->execute() ;
                if (IS_DEBUG) {nl_dump($results);}
                if ($results[0]) {
                    $results = $this->get_last_results();
                }
            }
        } catch (Exception $e) { $results[0] = 0; $results[1] = $e->getMessage(); }
        return $results;
    }
    public function add_entry(string $table, array $params) : array {
        if (IS_DEBUG) {echo "DatabaseUtility::add_entry table: $table, params: "; nl_dump($params);}
        $statement = "INSERT INTO $table  ( ".join(', ', array_keys($params))." ) VALUES ( :".join(', :',
                array_keys($params))." )";
        if (IS_DEBUG) { nl_dump($statement);}
        $results = $this->prepare($statement);
        if ($results[0]) {
            $results = $this->execute($params);
        }
        return $results;
    }

    public static function get_headers(array $row) : array {
        $out = [];
        $a = array_keys($row);
        if (IS_DEBUG) {echo "DatabaseUtility->get_headers row "; nl_dump($a );}
        foreach ($row as $key => $value) {
            if (is_numeric($key)) {continue;}
            if (str_starts_with($key, '__')) {continue;}
            array_push($out, $key);
        }
        return $out;
    }
}