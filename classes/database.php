<?php

/**
 * Created by PhpStorm.
 * User: Mystichal
 * Date: 2017-11-13
 * Time: 23:21
 */
class database
{

    private $db_host = "localhost";
    private $db_user = "jav";
    private $db_pass = "QMuG4FmtKL7rBWBR";
    private $db_name = "bymyst";

    private $con = false; // check to see if the connection is active
    private $myconn = ""; // mysqli object
    private $result = array(); // query storage
    private $myQuery = ""; // debugging process with SQL return
    private $numResults = ""; // used for returning the number of rows

    // create a connection to the database
    public function connect()
    {
        if (!$this->con) {
            $this->myconn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name); // mysql_connect() with variables defined at the start of Database class
            // change character set to utf8
            $this->myconn->set_charset("utf8");
            if ($this->myconn->connect_errno > 0) {
                array_push($this->result, $this->myconn->connect_error);
                return false; // problem selecting database return FALSE
            } else {
                $this->con = true;
                return true; // connection has been made return TRUE
            }
        } else {
            return true; // connection has already been made return TRUE
        }
    }

    // disconnect from the database
    public function disconnect()
    {
        // if there is a connection to the database
        if ($this->con) {
            // we have found a connection, try to close it
            if ($this->myconn->close()) {
                // we have successfully closed the connection, set the connection variable to false
                $this->con = false;
                // return true that we have closed the connection
                return true;
            } else {
                // we could not close the connection, return false
                return false;
            }
        }
    }

    public function sql($sql)
    {
        $query = $this->myconn->query($sql);
        $this->myQuery = $sql; // pass back the SQL
        if ($query) {
            // if the query returns >= 1 assign the number of rows to numResults
            $this->numResults = $query->num_rows;
            // loop through the query results by the number of rows returned
            for ($i = 0; $i < $this->numResults; $i++) {
                $r = $query->fetch_array();
                $key = array_keys($r);
                for ($x = 0; $x < count($key); $x++) {
                    // sanitizes keys so only alphavalues are allowed
                    if (!is_int($key[$x])) {
                        if ($query->num_rows >= 1) {
                            $this->result[$i][$key[$x]] = $r[$key[$x]];
                        } else {
                            $this->result = null;
                        }
                    }
                }
            }
            return true; // query was successful
        } else {
            array_push($this->result, $this->myconn->error);
            return false; // no rows where returned
        }
    }

    // SELECT from the database
    public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null)
    {
        // create query from the variables passed to the function
        $q = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($join != null) {
            $q .= ' JOIN ' . $join;
        }
        if ($where != null) {
            $q .= ' WHERE ' . $where;
        }
        if ($order != null) {
            $q .= ' ORDER BY ' . $order;
        }
        if ($limit != null) {
            $q .= ' LIMIT ' . $limit;
        }
        // echo $table;
        $this->myQuery = $q; // Pass back the SQL
        // check to see if the table exists
        if ($this->tableExists($table)) {
            // the table exists, run the query
            $query = $this->myconn->query($q);
            if ($query) {
                // if the query returns >= 1 assign the number of rows to numResults
                $this->numResults = $query->num_rows;
                // loop through the query results by the number of rows returned
                for ($i = 0; $i < $this->numResults; $i++) {
                    $r = $query->fetch_array();
                    $key = array_keys($r);
                    for ($x = 0; $x < count($key); $x++) {
                        // sanitizes keys so only alpha values are allowed
                        if (!is_int($key[$x])) {
                            if ($query->num_rows >= 1) {
                                $this->result[$i][$key[$x]] = $r[$key[$x]];
                            } else {
                                $this->result[$i][$key[$x]] = null;
                            }
                        }
                    }
                }
                return true; // query was successful
            } else {
                array_push($this->result, $this->myconn->error);
                return false; // no rows where returned
            }
        } else {
            return false; // table does not exist
        }
    }

    // insert into the database
    public function insert($table, $params = array())
    {
        // check to see if the table exists
        if ($this->tableExists($table)) {
            $sql = 'INSERT INTO `' . $table . '` (`' . implode('`, `', array_keys($params)) . '`) VALUES ("' . implode('", "', $params) . '")';
            $this->myQuery = $sql; // Pass back the SQL
            // make the query to insert to the database
            if ($ins = $this->myconn->query($sql)) {
                array_push($this->result, $this->myconn->insert_id);
                return true; // the data has been inserted
            } else {
                array_push($this->result, $this->myconn->error);
                return false; // the data has not been inserted
            }
        } else {
            return false; // table does not exist
        }
    }

    // delete table or row(s) from database
    public function delete($table, $where = null)
    {
        // check to see if table exists
        if ($this->tableExists($table)) {
            // the table exists check to see if we are deleting rows or table
            if ($where == null) {
                $delete = 'DROP TABLE ' . $table; // create query to delete table
            } else {
                $delete = 'DELETE FROM ' . $table . ' WHERE ' . $where; // create query to delete rows
            }
            // submit query to database
            if ($del = $this->myconn->query($delete)) {
                array_push($this->result, $this->myconn->affected_rows);
                $this->myQuery = $delete; // Pass back the SQL
                return true; // the query exectued correctly
            } else {
                array_push($this->result, $this->myconn->error);
                return false; // the query did not execute correctly
            }
        } else {
            return false; // the table does not exist
        }
    }

    // table name, column names and values, WHERE conditions
    // update row in database
    public function update($table, $params = array(), $where)
    {
        // check to see if table exists
        if ($this->tableExists($table)) {
            // create Array to hold all the columns to update
            $args = array();
            foreach ($params as $field => $value) {
                // seperate each column out with it's corresponding value
                $args[] = utf8_decode($field) . '="' . $value . '"';
            }
            // create the query
            $sql = 'UPDATE ' . $table . ' SET ' . implode(',', $args) . ' WHERE ' . $where;
            // make query to database
            $this->myQuery = $sql; // pass back the SQL
            if ($query = $this->myconn->query($sql)) {
                array_push($this->result, $this->myconn->affected_rows);
                return true; // update has been successful
            } else {
                array_push($this->result, $this->myconn->error);
                return false; // update has not been successful
            }
        } else {
            return false; // the table does not exist
        }
    }

    // check if table exists for use with queries
    private function tableExists($table)
    {
        $tablesInDb = $this->myconn->query('SHOW TABLES FROM ' . $this->db_name . ' LIKE "' . $table . '"');
        if ($tablesInDb) {
            if ($tablesInDb->num_rows == 1) {
                return true; // The table exists
            } else {
                array_push($this->result, $table . " does not exist in this database");
                return false; // The table does not exist
            }
        }
    }

    // return the data to the user
    public function getResult()
    {
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    // pass the SQL back for debugging
    public function getSql()
    {
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    // pass the number of rows back
    public function numRows()
    {
        $val = $this->numResults;
        $this->numResults = array();
        return $val;
    }

    // escape your string
    public function escapeString($data)
    {
        return $this->myconn->real_escape_string($data);
    }
}
