<?php

namespace Test;

require_once 'Engine.php';

class DataEngine extends Engine
{
    public function clearTodos()
    {
        $sql = "DELETE FROM ingesttest.todos";
        $stmt = $this->db->prepare($sql);
        try {
            $result = $stmt->execute();
        } catch (\PDOException $e) {
            return "Unsuccessful: " . $e;
        }
        if (!$result) {
            return "Unsuccessful: Unknown Error";
        }
        return "Success!";
    }

    public function viewTodos()
    {
        $sql = "SELECT * FROM ingesttest.todos
                ORDER BY completed, userId, id";
        $stmt = $this->db->prepare($sql);
        try {
            $result = $stmt->execute();
        } catch (\PDOException $e) {
            return "Unsuccessful: " . $e;
        }
        if (!$result) {
            return "Unsuccessful: Unknown Error";
        }
        $results = $stmt->fetchAll();

        //Highlight profanity
        $highlightedResults = $this->highlightProfanity($results);

        return $highlightedResults;
    }

    public function viewProfanity()
    {
        $sql = "SELECT * FROM ingesttest.todos
                WHERE warning = 1
                ORDER BY userId, id";
        $stmt = $this->db->prepare($sql);
        try {
            $result = $stmt->execute();
        } catch (\PDOException $e) {
            return "Unsuccessful: " . $e;
        }
        if (!$result) {
            return "Unsuccessful: Unknown Error";
        }
        $results = $stmt->fetchAll();

        //Highlight profanity
        $highlightedResults = $this->highlightProfanity($results);

        return $highlightedResults;
    }

    protected function highlightProfanity($results)
    {
        $regex = '/\b('.join('|', BADWORDS).')\b/i';

        foreach ($results as $key => $result) {
            if ($result['warning']) {
                $results[$key]['title'] = preg_filter($regex, '<span style="color:#FF0000;">$0</span>', $result['title']);
            }
        }

        return $results;
    }
}
