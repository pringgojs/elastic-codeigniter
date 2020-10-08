<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Elastic extends CI_Controller {

	public $client;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('elasticsearchclient');
		$this->client = $this->elasticsearchclient->client();
	}

	public function index()
	{
		$data = ['title' => 'Hello, Blade'];
		return view('backend.dashboard', $data);
	}

	/**
	 * membuat index
	 */
	public function create_index()
	{
		$params = [
			'index' => 'kendaraan'
		];
		
		$response = $this->client->indices()->create($params);
		dd($response);
	}

	/**
	 * membuat index dengan mapping
	 */
	public function create_index_with_mapping()
	{
		$params = [
			'index' => 'kendaraan',
			'body' => [
					'settings' => [
							'number_of_shards' => 3,
							'number_of_replicas' => 2
					],
					'mappings' => [
							'_source' => [
									'enabled' => true
							],
							'properties' => [
									'jenis' => [
										'type' => 'text'
									],
									'merek' => [
										'type' => 'text'
									],
									'nopol' => [
										'type' => 'text'
									],
									'warna' => [
										'type' => 'text'
									],
									'created_at' => [
											'type' => 'text'
									]
							]
					]
			]
		];

		$response = $this->client->indices()->create($params);
		dd($response);
	}

	/**
	 * mengahpus index
	 */
	public function delete_index()
	{
		$params = ['index' => 'kendaraan'];
	
		try {
			$response = $this->client->indices()->delete($params);
			dd($response);
		} catch (\Throwable $th) {
			dd("index sudah dihapus");
		}
	}

	/**
	 * Membuat index dan sekaligus menambahkan dokumen
	 */
	public function create_new_doc()
	{
		$params = [
			'index' => 'kendaraan',
			'type' => 'kendaraan',
			'id' => 'ykboBnUBlYsLAFRIXQba', // ID jika dikosongkan maka akan tergenerate otomatis
			'body'  => [
				'jenis' => 'MTB',
				'merek' => 'Honda',
				'nama' => 'Kijang Inova',
				'nopol' => 'AB 8989 B',
				'warna' => 'Hitam',
				'created_at' => date('Y-m-d H:i:s')
			]
		];
		
		// Document will be indexed to my_index/_doc/my_id
		$response = $this->client->index($params);
		dd($response);
	}

	/** mendapatkan dokumen */
	public function get_doc()
	{
		$params = [
				'index' => 'kendaraan',
				'type' => 'kendaraan',
				'id' => 'ykboBnUBlYsLAFRIXQba'
		];
		
		// Get doc at /my_index/my_type/my_id
		$response = $this->client->get($params);
		dd($response);
	}

	/** update document */
	public function update_doc()
	{
		$params = [
			'index' => 'kendaraan',
			'type' => 'kendaraan',
			'id' => 'ykboBnUBlYsLAFRIXQba',
			'body'  => [
				'doc' => [
					'new_field' => 'field_baru'
				]
			]
		];
		
		// Update doc at /my_index/my_type/my_id
		$response = $this->client->update($params);
		dd($response);
	}

	/** delete document */
	public function delete_doc()
	{
		$params = [
			'index' => 'kendaraan',
			'type' => 'kendaraan',
			'id' => 'ykboBnUBlYsLAFRIXQba'
		];
		
		// Delete doc at /my_index/my_type/my_id
		$response = $this->client->delete($params);
		dd($response);
	}

	/** search: berdasarkan merek */
	public function search()
	{
		$params = [
			'index' => 'kendaraan',
			'type' => 'kendaraan',
			'body' => [
				'query' => [
						'match' => [
							'merek' => 'Honda'
						]
				]
			]
		];
	
		$results = $this->client->search($params);
		dd($results);
	}
}
