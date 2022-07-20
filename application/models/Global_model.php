<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}

class Global_model extends CI_Model {

  function getAllCount( $tbl, $where = FALSE ) {
    $this->db->select('count(*) as qty');
    $this->db->from($tbl);
    if ( $where ) {
      $this->db->where($where);
    }
    $query = $this->db->get();
    $result = $query->first_row();
    $query->free_result();

    return $result->qty;
  }

  function getCountVerifiedUserByAttachedProducts() {
    $sql = 'SELECT
              count( u.id ) AS qty
            FROM
              users u
              INNER JOIN sellers s ON s.id_user = u.id
              INNER JOIN products p ON p.id = s.id_product AND p.status = 1
            WHERE
              u.status = 1 AND u.verified = "yes"';
    $query =  $this->db->query($sql);
    $result = $query->first_row();

    return $result->qty;
  }

  function getDontSellerProductsCount() {
    $sql = 'SELECT
             count( p.id ) AS qty
          FROM
            products p
          LEFT JOIN sellers s ON s.id_product = p.id
          WHERE
            p.status = 1 AND s.id_user is NULL';
    $query =  $this->db->query($sql);
    $result = $query->first_row();

    return $result->qty;
  }
}
