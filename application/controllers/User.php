<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{

    public function index()
    {
        // TITLE
        $data['title'] = 'Home';
        $data['sub_title'] = 'Dashboard';
        $data['status'] = 'User';
        $data['corp_name'] = 'Kotree';
        $data['kelompok'] = 'Kelompok 3';

        // QUERY
        $username = $this->session->userdata('username');

        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['jumlah_pinjaman'] = $this->app_models->getWhereNumRow('pinjaman');
        $data['jumlah_simpanan'] = $this->app_models->getWhereNumRow('simpanan');

        $data['transaksi_simpanan'] = $this->app_models->getUserTransaksi('simpanan', $username);
        $data['transaksi_pinjaman'] = $this->app_models->getUserTransaksi('pinjaman', $username);

        $query = " SELECT `username`, (SELECT SUM(`pinjaman_pokok`) FROM `pinjaman` WHERE `username` = '$username') AS pinjaman, (SELECT SUM(`simpanan`) FROM `simpanan`  WHERE `username` = '$username') AS simpanan FROM `user` WHERE `username` = '$username' ";
        $total = $this->app_models->getUserTotalSP($username);
        $persen = $total['simpanan'] + $total['pinjaman'];


        $data['total'] = $total['simpanan'] + $total['pinjaman'];
        $data['total_simpanan'] = $total['simpanan'];
        $data['total_pinjaman'] = $total['pinjaman'];
        $data['total'] = $total['simpanan'] + $total['pinjaman'];
        $data['simpanan'] = round(($total['simpanan'] / $persen) * 100);
        $data['pinjaman'] = round(($total['pinjaman'] / $persen) * 100);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer', $data);
    }
}