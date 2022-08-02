<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}

class Global_model extends CI_Model {

  /**
   * Get all.
   *
   * @param string $tbl
   * @param int    $perPage
   * @param int    $pageNum
   * @param array  $where
   * @param array  $order
   * @param string $return
   *
   * @return mixed
   */
  function getAll( $tbl = '', $perPage = 0, $pageNum = 0, $where = array(), $order = array(), $return = 'object' ) {
    $this->db->select('*');
    $this->db->from($tbl);
    if ( $where ) {
      $this->db->where($where);
    }
    if ( $perPage ) {
      $this->db->limit($perPage, $pageNum);
    }
    if ( $order ) {
      foreach ( $order as $k => $v ) {
        $this->db->order_by($tbl . '.' . $k, $v);
      }
    }
    else {
      $this->db->order_by($tbl . '.id', 'DESC');
    }
    $query = $this->db->get();
    if ( $return != 'object' ) {
      $result = $query->result_array();
    }
    else {
      $result = $query->result();
    }
    $query->free_result();

    return $result;
  }

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

  /**
   * Get by id.
   *
   * @param string $tbl
   * @param string $id
   *
   * @return mixed
   */
  function getById( $tbl = '', $id = '' ) {
    $this->db->select("*");
    $this->db->from($tbl);
    $this->db->where(array( 'id' => $id));
    $query = $this->db->get();
    $user = $query->first_row();
    $query->free_result();

    return $user;
  }

  function getWhere( $tbl = '', $where = [] ) {
    $this->db->select('*');
    $this->db->from($tbl);
    $this->db->where($where);
    $query = $this->db->get();
    $result = $query->first_row();
    $query->free_result();

    return $result;
  }

  function getWhereList( $tbl = '', $where = [] ) {
    $this->db->select('*');
    $this->db->from($tbl);
    $this->db->where($where);
    $query = $this->db->get();
    $result = $query->result();
    $query->free_result();

    return $result;
  }

  function updateById( $tbl = '', $data = [], $id = '' ) {
    $this->db->where('id', $id);
    $this->db->update($tbl, $data);

    return $id;
  }

  function updateByIn( $tbl = '', $data = [], $name = [], $where_in = [], $where = [] ) {
    $this->db->where_in($name, $where_in);
    if ( $where ) {
      $this->db->where($where);
    }
    $update = $this->db->update($tbl, $data);
    if ( $update ) {
      return TRUE;
    }

    return FALSE;
  }

  function updateWhere( $tbl = '', $data = [], $where = [] ) {
    if ( $where ) {
      $this->db->where($where);
    }
    $upd = $this->db->update($tbl, $data);

    return $upd;
  }

  function removeById( $tbl = '', $id = '' ) {
    $this->db->where('id', $id);
    $this->db->delete($tbl);

    return $id;
  }

  function removeWhere( $tbl = '', $where = [] ) {
    $this->db->where($where);
    $del = $this->db->delete($tbl);

    return $del;
  }

  function toggleById( $tbl = '', $id = '', $fld = 'status' ) {
    $query = "UPDATE {$tbl} SET {$fld} = 1 - {$fld} WHERE id = {$id}";
    $this->db->query($query);

    return $id;
  }

  function insert( $tbl = '', $data = [] ) {
    $this->db->insert($tbl, $data);
    $id = $this->db->insert_id();

    return $id;
  }

  function is_unique_field_by_id( $val = '', $fields = '', $operator = '!=' ) {
    @list($tbl, $field, $fid, $vid) = explode('.', $fields);
    if ( !empty($fid) && !empty($vid) ) {
      $query = $this->db->limit(1)->get_where($tbl, array(
        '`' . $tbl . '`.`' . $field . '`' => $val,
        '`' . $tbl . '`.`' . $fid . '` '. $operator => $vid,
      ));
    }
    else {
      $query = $this->db->limit(1)->get_where($tbl, array( $tbl . '.' . $field => $val ));
    }

    return $query->num_rows() === 0;
  }

  function getCountVerifiedUserByAttachedProducts() {
    $this->db->select('u.id');
    $this->db->from('users u');
    $this->db->join('sellers s', 's.id_user = u.id', 'INNER');
    $this->db->join('products p', 'p.id = s.id_product AND p.status = 1', 'INNER');
    $this->db->where(array('u.status' => 1, 'u.verified' =>'yes' ));
    $this->db->group_by('u.id');
    $query = $this->db->get();
    $qty = $query->num_rows();
    $query->free_result();
    if ( !empty($qty) ) {
      return $qty;
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
    $this->db->select('u.name, SUM(s.qty) AS qty');
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

  function getAllMyProducts( $perPage = 0, $pageNum = 0, $where = [] ) {
    $this->db->select('p.*, s.id_product, s.qty, s.per_price, s.timestamps AS s_timestamps');
    $this->db->from('products p');
    $this->db->join('sellers s', 's.id_product = p.id', 'INNER');
    $this->db->where( ['p.status' => 1] );
    if ( $where ) {
      $this->db->where($where);
    }
    $query1 = $this->db->get();
    $result['total_rows'] = $query1->num_rows();
    $query1->free_result();

    $this->db->select('p.title, p.price, p.image, s.id, s.id_product, s.qty, s.per_price, s.timestamps AS s_timestamps');
    $this->db->from('products p');
    $this->db->join('sellers s', 's.id_product = p.id', 'INNER');
    $this->db->where( ['p.status' => 1] );
    if ( $where ) {
      $this->db->where($where);
    }
    if ( $perPage ) {
      $this->db->limit($perPage, $pageNum);
    }
    $this->db->order_by('s_timestamps', 'DESC');
    $query = $this->db->get();
    $result['items'] = $query->result();
    $query->free_result();

    return $result;
  }
}
