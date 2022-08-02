<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}

class User_model extends CI_Model {
  private $tbl = 'users';

  function __construct() {
    parent::__construct();
  }

  /**
   * Get where.
   *
   * @param array $where
   *
   * @return mixed
   */
  public function GetWhere( $where = [] ) {
    $fields = '*';
    $this->db->select($fields);
    $this->db->from($this->tbl);
    $this->db->where($where);
    $query = $this->db->get();
    $result = $query->first_row();
    $query->free_result();

    return $result;
  }

  /**
   * Update where.
   *
   * @param array $data
   * @param array $where
   *
   * @return mixed
   */
  public function UpdateWhere( $data = [], $where = [] ) {
    $this->db->where($where);
    $upd = $this->db->update($this->tbl, $data);

    return $upd;
  }

  /**
   * Add user.
   *
   * @param array $args
   *
   * @return mixed
   */
  public function add( $args = [] ) {
    $this->db->insert($this->tbl, $args);
    $id = $this->db->insert_id();

    return $id;
  }

  /**
   * Check by email.
   *
   * @param string $email
   *
   * @return mixed
   */
  public function checkByEmail( $email = '' ) {
    $fields = '*';
    $this->db->select($fields);
    $this->db->from($this->tbl);
    $this->db->where([ $this->tbl . '.email' => $email ]);
    $query = $this->db->get();
    $user = $query->first_row();
    $query->free_result();

    return $user;
  }

  /**
   * Check by id.
   *
   * @param string $id
   *
   * @return mixed
   */
  public function checkById( $id = '' ) {
    $this->db->select("*");
    $this->db->from($this->tbl);
    $this->db->where([ $this->tbl . '.id' => $id ]);
    $query = $this->db->get();
    $user = $query->first_row();
    $query->free_result();

    return $user;
  }

  /**
   * Get user login.
   *
   * @param string $email
   * @param string $pass
   *
   * @return mixed
   */
  public function GetUserLogin( $email = '', $pass = '' ) {
    $fields = '*';
    $this->db->select($fields);
    $this->db->from($this->tbl);
    $this->db->where([
                       $this->tbl . '.email' => trim($email),
                       $this->tbl . '.password' => $pass,
                       $this->tbl . '.status' => 1,
                     ]);
    $query = $this->db->get();
    $user = $query->first_row();
    $query->free_result();

    return $user;
  }
}
