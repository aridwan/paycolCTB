<?php  
 class AjaxModel extends CI_Model  
 {  
      var $table = "ctb";  
      var $select_column = array("id", "nama_visitor", "tgl_visit", "no_inet", "no_ref", "prioritas", "alamat", "customer", "nomor", "rt_rw", "kelurahan", "mk_tlp", "mk_email", "tagihan_n", "tagihan_n1", "total_tagihan", "kategori_visit", "nama_yang_ditemui", "keterangan","foto_path", "last_update");  
      var $order_column = array("id", "nama_visitor", "tgl_visit", "no_inet", "no_ref", "prioritas", "alamat", "customer", "nomor", "rt_rw", "kelurahan", "mk_tlp", "mk_email", "tagihan_n", "tagihan_n1", "total_tagihan", "kategori_visit", "nama_yang_ditemui", "keterangan","foto_path", "last_update");  

      function make_query($tanggal,$no_layanan,$prioritas)  
      {  
           $this->db->select($this->select_column);  
           $this->db->from($this->table);
           // print_r($type);
           $this->db->like('tgl_visit', $tanggal);
           $this->db->like('no_inet', $no_layanan);
           $this->db->like('prioritas', $prioritas);    
           if(isset($_POST["search"]["value"]))  
           {  
                // $this->db->like("id", $_POST["search"]["value"]);  
                // $this->db->like("merk", $_POST["search"]["value"]);  
                // $this->db->like("type", $_POST["search"]["value"]);  
                // $this->db->like("sn", $_POST["search"]["value"]);  
                // $this->db->like("mac_address", $_POST["search"]["value"]);  
                // $this->db->like("status_ap", $_POST["search"]["value"]);  
                // $this->db->like("location_type", $_POST["search"]["value"]);  
                // $this->db->like("last_update_by", $_POST["search"]["value"]);  
                // $this->db->like("last_update", $_POST["search"]["value"]);  
           } else {

           } 
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'ASC');  
           }  
      }  
      function make_datatables($tanggal,$no_layanan,$prioritas){  
           $this->make_query($tanggal,$no_layanan,$prioritas);  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();
           return $query->result();  
      }  
      function get_filtered_data($tanggal,$no_layanan,$prioritas){  
           $this->make_query($tanggal,$no_layanan,$prioritas);  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);  
           return $this->db->count_all_results();  
      }  
 }  