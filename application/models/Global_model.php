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
    $result = $query->row();
    $query->free_result();
    if ( !empty($result) && !empty($result->qty) ) {
      return $result->qty;
    }
    return 0;
  }

  function getCountVerifiedUserByAttachedProducts() {
    $this->db->select('count( u.id ) AS qty');
    $this->db->from('users u');
    $this->db->join('sellers s', 's.id_user = u.id', 'INNER');
    $this->db->join('products p', 'p.id = s.id_product AND p.status = 1', 'INNER');
    $this->db->where(array('u.status' => 1, 'u.verified' =>'yes' ));
    $query = $this->db->get();
    $row = $query->row();
    $query->free_result();
    if ( !empty($row) && !empty($row->qty) ) {
      return $row->qty;
    }

    return 0;
  }

  function getDontSellerProductsCount() {
    $this->db->select('count( p.id ) AS qty');
    $this->db->from('products p');
    $this->db->join('sellers s', 's.id_product = p.id', 'LEFT');
    $this->db->where(array('p.status' => 1, 's.id_user is NULL' => NULL ));
    $query = $this->db->get();
    $row = $query->row();
    if ( !empty($row) && !empty($row->qty) ) {
      return $row->qty;
    }

    return 0;
  }

  function getUserProducts() {
    $this->db->select('u.name, count(p.id) AS qty');
    $this->db->from('users u');
    $this->db->join('sellers s', 's.id_user = u.id', 'INNER');
    $this->db->join('products p', 'p.id = s.id_product AND p.status = 1', 'INNER');
    $this->db->where(array('u.status' => 1, 'u.verified' => 'yes'));
    $this->db->group_by('u.id');
    $query = $this->db->get();
    $result = $query->result();

    if ( !empty($result) ) {
      return $result;
    }

    return array();
  }

  function getActiveAttachedProducts() {
    $this->db->select('SUM(s.per_price * qty ) AS price');
    $this->db->from('users u');
    $this->db->join('sellers s', 's.id_user = u.id', 'INNER');
    $this->db->join('products p', 'p.id = s.id_product AND p.status = 1', 'INNER');
    $this->db->where(array('u.status' => 1, 'u.verified' => 'yes'));
    $query = $this->db->get();
    $row = $query->row();
    if ( !empty($row) && !empty($row->price) ) {
      return $row->price;
    }
    return 0;
  }

  function getActiveProductsPerUser() {
    $this->db->select('u.id, u.name, SUM(s.per_price * qty ) AS price');
    $this->db->from('users u');
    $this->db->join('sellers s', 's.id_user = u.id', 'INNER');
    $this->db->join('products p', 'p.id = s.id_product AND p.status = 1', 'INNER');
    $this->db->where(array('u.status' => 1, 'u.verified' => 'yes'));
    $this->db->group_by('s.id_user');
    $query = $this->db->get();
    $result = $query->result();
    if ( !empty($result) ) {
      return $result;
    }

    return array();
  }
}
