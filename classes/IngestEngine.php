<?php

namespace Test;

require_once 'Engine.php';

class IngestEngine extends Engine
{
    private $todoLocation = "https://jsonplaceholder.typicode.com/todos";

    public function getTodos()
    {
        $string = file_get_contents($this->todoLocation);
        $json_list = json_decode($string, true);
        foreach ($json_list as $todo) {
            $result[] = $this->save($todo);
        }

        return $result;
    }

    public function save($todo)
    {
        //Need todo profanity check!
        $profane = $this->profanityCheck($todo);

        $sql = "INSERT INTO ingesttest.todos
            (userId, id, title, completed, warning) VALUES
            (:userId, :id, :title, :completed, :warning)
            ";
        $stmt = $this->db->prepare($sql);
        try {
            $result = $stmt->execute([
                "userId" => $todo['userId'],
                "id" => $todo['id'],
                "title" => $todo['title'],
                "completed" => $todo['completed']+0,
                "warning" => $profane+0,
            ]);
        } catch (\PDOException $e) {
            return "Unsuccessful: " . $e;
        }
        if (!$result) {
            //throw new Exception("could not save record");
            return "Unsuccessful: Unknown Error";
        }
        return "Success!";
    }

    private function profanityCheck($todo)
    {
        $regex = '/\b('.join('|', BADWORDS).')\b/i';
        
        if (preg_match($regex, $todo['title'])) {
            return true;
        } else {
            return false;
        }
    }
}
